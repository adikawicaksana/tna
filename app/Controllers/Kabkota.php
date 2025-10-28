<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\CommonHelper;
use App\Models\UserDetailModel;
use App\Models\InstitutionsModel;
use App\Models\UsersInstitutionsModel;
use App\Models\UsersManagerModel;
use App\Models\SurveyModel;
use App\Models\QuestionnaireModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Kabkota extends BaseController
{

    protected $userModel;
    protected $userDetailModel;
    protected $institutions;
    protected $userInstitutions;
    protected $managerInstitution;
    protected $survey;


    public function __construct()
    {
        $this->institutions = new InstitutionsModel();
        $this->userInstitutions = new UsersInstitutionsModel;
        $this->userModel = new UserModel();
        $this->userDetailModel = new UserDetailModel();
        $this->managerInstitution = new UsersManagerModel();
        $this->survey = new SurveyModel();

    }

    public function index($id = null)
    {
        if ($this->request->isAJAX()) {
            $status = SurveyModel::listStatus();
            $request = $this->request->getGet();

            $id = isset($request['id']) ? $request['id'] : null;
            $year = isset($request['year']) ? $request['year'] : date('Y');
            $draw = isset($request['draw']) ? (int)$request['draw'] : 1;
            $start = isset($request['start']) ? (int)$request['start'] : 0;
            $length = isset($request['length']) ? (int)$request['length'] : 10;
            $search = isset($request['search']['value']) ? $request['search']['value'] : '';

            $builder = \Config\Database::connect();
            $builder = $builder->table('survey s')
                ->select('survey_id, s.created_at, institution_id, i.category AS institution_category, respondent_id, front_title, fullname, back_title, survey_status, approved_at');
            $builder->select("CONCAT(i.type, ' ', i.name) AS institution_name", false)
                ->join('users_detail u', 's.respondent_id = u._id_users')
                ->join('master_institutions i', 's.institution_id = i.id')
                ->where('EXTRACT(YEAR FROM s.created_at) =', $year, false)
                ->where('i.type','kabkota')
                ->where('s.institution_id', $id);

            // Filtering
            if (!empty($search)) {
                $builder->groupStart()
                    ->like('institution_name', $search)
                    ->orLike('fullname', $search)
                    ->groupEnd();
            }

            // Sorting
            $columns = ['created_at', 'institution_category', 'institution_name', 'fullname', 'survey_status', 'approved_at'];
            if (isset($request['order'][0])) {
                $columnIndex = $request['order'][0]['column'];
                $columnName = $request['columns'][$columnIndex]['data'];
                $columnSortOrder = $request['order'][0]['dir'];

                if (in_array($columnName, $columns)) {
                    $builder->orderBy($columnName, $columnSortOrder);
                }
            }

            $builderClone = clone $builder;
            $totalRecords = $this->survey->countAll();
            $totalFiltered = $builder->countAllResults(false);

            // Pagination
            $builderClone->limit($length, $start);
            $data = $builderClone->get()->getResultArray();

            // Set data
            $rows = [];
            foreach ($data as $index => $each) {
                $rows[] = [
                    'no' => $start + $index + 1,
                    'created_at' => CommonHelper::formatDate($each['created_at']),
                    'institution_category' => $each['institution_category'],
                    'institution_name' => ucwords($each['institution_name']),
                    'fullname' => $each['fullname'],
                    'survey_status' => $status[$each['survey_status']],
                    'approved_at' => !empty($each['approved_at']) ? CommonHelper::formatDate($each['approved_at']) : '-',
                    'action' => '<a href="' . route_to("survey.show", $each['survey_id']) . '" class="btn btn-outline-info btn-sm p-2"><i class="fas fa-eye"></i></a>',
                ];
            }

            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $rows,
            ]);
        }

        $id = $this->request->getGet('i') ?? null;
        $year = $this->request->getGet('y') ?? date("Y");
        $userDetail = $this->userDetailModel->getUserDetail();
        $session = session();
        $institusi=[];

        $m_institutions = (new UsersManagerModel())->searchByIDusers($session->get('_id_users'), 'kabkota');

        if (!empty($userDetail['mobile']) && str_starts_with($userDetail['mobile'], '62')) {
            $userDetail['mobile'] = substr($userDetail['mobile'], 2);
        }

        if (!empty($m_institutions) && $session->get('user_role') == UserModel::ROLE_USER) {
            $p_institusi = array_column($m_institutions, '_id_institutions');
        }elseif ($session->get('user_role') != UserModel::ROLE_USER) {
            $p_institusi = array_merge(array_column($this->institutions->getParentsBySurvey('kabkota'), 'parent_id'),array_column($m_institutions, '_id_institutions'));
        }
       
        $institusi = !empty($p_institusi) ? $this->institutions->whereIn('id', $p_institusi)->findAll(): [];

        $selectedId = ($id && in_array($id, $p_institusi, true)) ? $id : ($p_institusi[0] ?? null);

        $institusiDetail = $selectedId ? $this->institutions->detail($selectedId) : null;

        if ($institusiDetail) {
            $jumlahUserInstitusi = $this->userInstitutions->countByInstitution($institusiDetail['id']) ?? 0;
            $totalSurvey = count($this->survey->surveyByInstitusi($institusiDetail['id'], $year)) ?? 0;

            $pengelola = $this->managerInstitution->searchByIDInstitution($institusiDetail['id']);

            $child['puskesmas'] = $this->institutions->getByParentID($institusiDetail['id'],'puskesmas');            
            $child['rumahsakit'] = $this->institutions->getByParentID($institusiDetail['id'],'rumahsakit');       
            $child['institusi'] = $this->institutions->getByParentID($institusiDetail['id'],'institusi');
            
            $datapermintaan = $this->survey->getTrainingSummaryByYear($year, $institusiDetail['id']);
        }



        return view('kabkota/index', [
            'title'      => 'Dinas Kabupaten / Kota',
            'userDetail' => $userDetail,
            'data'       => [
                'institusi'         => $institusi,
                'institusi_selected' => $selectedId,
                'institusi_detail'   => $institusiDetail,
                'total_users_institusi'=> $jumlahUserInstitusi,
                'total_users_survey' => $totalSurvey,
                'child' => $child,
                'questionnaire_type' => QuestionnaireModel::listType('institusi'),
                'years' => CommonHelper::years(date('Y')),
                'pengelola' => $pengelola,
                'datapermintaan' => $datapermintaan,
                
            ],
        ]);
    }

    public function index_child($id = null)
    {
        if ($this->request->isAJAX()) {
            $status = SurveyModel::listStatus();
            $request = $this->request->getGet();

            $id_child = isset($request['id']) ? $request['id'] : null;
            $year = isset($request['year']) ? $request['year'] : date('Y');
            $draw = isset($request['draw']) ? (int)$request['draw'] : 1;
            $start = isset($request['start']) ? (int)$request['start'] : 0;
            $length = isset($request['length']) ? (int)$request['length'] : 10;
            $search = isset($request['search']['value']) ? $request['search']['value'] : '';

            $builder = \Config\Database::connect();
            $builder = $builder->table('survey s')
                ->select('survey_id, s.created_at, institution_id, i.category AS institution_category, respondent_id, front_title, fullname, back_title, survey_status, approved_at');
            $builder->select("CONCAT(i.type, ' ', i.name) AS institution_name", false)
                ->join('users_detail u', 's.respondent_id = u._id_users')
                ->join('master_institutions i', 's.institution_id = i.id')
                ->where('EXTRACT(YEAR FROM s.created_at) =', $year, false)
                // ->where('i.type','kabkota')
                ->where('s.institution_id', $id_child);

            // Filtering
            if (!empty($search)) {
                $builder->groupStart()
                    ->like('institution_name', $search)
                    ->orLike('fullname', $search)
                    ->groupEnd();
            }

            // Sorting
            $columns = ['created_at', 'institution_category', 'institution_name', 'fullname', 'survey_status', 'approved_at'];
            if (isset($request['order'][0])) {
                $columnIndex = $request['order'][0]['column'];
                $columnName = $request['columns'][$columnIndex]['data'];
                $columnSortOrder = $request['order'][0]['dir'];

                if (in_array($columnName, $columns)) {
                    $builder->orderBy($columnName, $columnSortOrder);
                }
            }

            $builderClone = clone $builder;
            $totalRecords = $this->survey->countAll();
            $totalFiltered = $builder->countAllResults(false);

            // Pagination
            $builderClone->limit($length, $start);
            $data = $builderClone->get()->getResultArray();

            // Set data
            $rows = [];
            foreach ($data as $index => $each) {
                $rows[] = [
                    'no' => $start + $index + 1,
                    'created_at' => CommonHelper::formatDate($each['created_at']),
                    'institution_category' => $each['institution_category'],
                    'institution_name' => ucwords($each['institution_name']),
                    'fullname' => $each['fullname'],
                    'survey_status' => $status[$each['survey_status']],
                    'approved_at' => !empty($each['approved_at']) ? CommonHelper::formatDate($each['approved_at']) : '-',
                    'action' => '<a href="' . route_to("survey.show", $each['survey_id']) . '" class="btn btn-outline-info btn-sm p-2"><i class="fas fa-eye"></i></a>',
                ];
            }

            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $rows,
            ]);
        }

        
        $id_child = $this->request->getGet('ic') ?? null;
        $year = $this->request->getGet('y') ?? date("Y");
        $userDetail = $this->userDetailModel->getUserDetail();
        $session = session();
        $institusi=[];
        $p_institusi = [];

        
        $m_institutions = (new UsersManagerModel())->searchByIDusers($session->get('_id_users'), 'kabkota');

       if (!in_array($id, array_column($m_institutions, '_id_institutions')) && $session->get('user_role') == UserModel::ROLE_USER) {
            throw PageNotFoundException::forPageNotFound();
        }

        $parent = $this->institutions->where('id', $id)->first();

        if (!empty($userDetail['mobile']) && str_starts_with($userDetail['mobile'], '62')) {
            $userDetail['mobile'] = substr($userDetail['mobile'], 2);
        }

        $p_institusi = $this->survey->findColumn('institution_id') ?? [];
        $institusi = $p_institusi ? $this->institutions->where('parent', $id)->findAll() : [];


        $selectedId = $id_child ?: $institusi[0]['id'];
        $institusiDetail = $this->institutions->detail($selectedId);
        
        if ($institusiDetail) {
            $jumlahUserInstitusi = $this->userInstitutions
                ->countByInstitution($institusiDetail['id']) ?? 0;
            $totalSurvey = count($this->survey->surveyByInstitusi($institusiDetail['id'], $year)) ?? 0;

            $pengelola = $this->managerInstitution->searchByIDInstitution($institusiDetail['id']);

        }



        return view('kabkota/child', [
            'title'      => $parent['name'],
            'userDetail' => $userDetail,
            'data'       => [
                'institusi'         => $institusi,
                'institusi_selected' => $selectedId,
                'institusi_detail'   => $institusiDetail,
                'total_users_institusi'=> $jumlahUserInstitusi,
                'total_users_survey' => $totalSurvey,
                'questionnaire_type' => QuestionnaireModel::listType('institusi'),
                'years' => CommonHelper::years(date('Y')),
                'pengelola' => $pengelola
            ],
        ]);
    }



   



}
