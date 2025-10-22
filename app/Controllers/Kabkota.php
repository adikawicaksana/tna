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

        if(array_column($m_institutions, '_id_institutions')){
            $p_institusi = array_column($m_institutions, '_id_institutions');

        $institusi = $this->institutions
            ->whereIn('id', $p_institusi)
            ->findAll();
        }

        $selectedId = ($id && in_array($id, $p_institusi, true)) ? $id : ($p_institusi[0] ?? null);

        $institusiDetail = $selectedId ? $this->institutions->detail($selectedId) : null;

        if ($institusiDetail) {
            $jumlahUserInstitusi = $this->userInstitutions
                ->countByInstitution($institusiDetail['id']) ?? 0;
            $totalSurvey = count($this->survey->surveyByInstitusi($institusiDetail['id'], $year)) ?? 0;

            $pengelola = $this->managerInstitution->searchByIDInstitution($institusiDetail['id']);

            $child['puskesmas'] = $this->institutions->searchByParent($institusiDetail['id'],'puskesmas');            
            $child['rumahsakit'] = $this->institutions->searchByParent($institusiDetail['id'],'rumahsakit');       
            $child['institusi'] = $this->institutions->searchByParent($institusiDetail['id'],'institusi');
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
                'pengelola' => $pengelola
            ],
        ]);
    }

    public function index_child($id = null)
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

        if(array_column($m_institutions, '_id_institutions')){
            $p_institusi = array_column($m_institutions, '_id_institutions');

        $institusi = $this->institutions
            ->whereIn('id', $p_institusi)
            ->findAll();
        }

        $selectedId = ($id && in_array($id, $p_institusi, true)) ? $id : ($p_institusi[0] ?? null);

        $institusiDetail = $selectedId ? $this->institutions->detail($selectedId) : null;

        if ($institusiDetail) {
            $jumlahUserInstitusi = $this->userInstitutions
                ->countByInstitution($institusiDetail['id']) ?? 0;
            $totalSurvey = count($this->survey->surveyByInstitusi($institusiDetail['id'], $year)) ?? 0;

            $pengelola = $this->managerInstitution->searchByIDInstitution($institusiDetail['id']);

            $child['puskesmas'] = $this->institutions->searchByParent($institusiDetail['id'],'puskesmas');            
            $child['rumahsakit'] = $this->institutions->searchByParent($institusiDetail['id'],'rumahsakit');       
            $child['institusi'] = $this->institutions->searchByParent($institusiDetail['id'],'institusi');
        }



        return view('kabkota/child', [
            'title'      => 'Institusi Kabupaten / Kota',
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
                'pengelola' => $pengelola
            ],
        ]);
    }



   



}
