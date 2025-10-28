<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Helpers\CommonHelper;
use App\Models\UserDetailModel;
use App\Models\InstitutionsModel;
use App\Models\UsersInstitutionsModel;
use App\Models\ReferenceDataModel;
use App\Models\UsersJobdescModel;
use App\Models\UsersCompetenceModel;
use App\Services\NotificationService;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\QuestionnaireModel;
use App\Models\UsersManagerModel;
use App\Models\SurveyModel;

class Institusi extends BaseController
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

   public function index()
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
                ->where("EXTRACT(YEAR FROM s.created_at) =", $year, false)
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
        $institusi = [];
        $p_institusi = [];

        $m_institutions = (new UsersManagerModel())->searchByIDusers($session->get('_id_users'), 'institusi');

        if (!empty($userDetail['mobile']) && str_starts_with($userDetail['mobile'], '62')) {
            $userDetail['mobile'] = substr($userDetail['mobile'], 2);
        }

        if (!empty($m_institutions) && $session->get('user_role') == UserModel::ROLE_USER) {
            $p_institusi = array_column($m_institutions, '_id_institutions');
        } elseif ($session->get('user_role') != UserModel::ROLE_USER) {          
            $p_institusi = array_merge(array_column($m_institutions, '_id_institutions'),$this->survey->findColumn('institution_id') ?? []);
        }

        if (!empty($p_institusi)) {
            $institusi = $this->institutions->whereIn('id', $p_institusi)->findAll();
        }

        $selectedId = ($id && in_array($id, $p_institusi, true)) ? $id : ($p_institusi[0] ?? null);

        $institusiDetail = $selectedId ? $this->institutions->detail($selectedId) : null;

        if ($institusiDetail) {
            $institusiId = $institusiDetail['id'];
            $jumlahUserInstitusi = $this->userInstitutions->countByInstitution($institusiId) ?? 0;
            $totalSurvey = count($this->survey->surveyByInstitusi($institusiId, $year)) ?? 0;
            $pengelola = $this->managerInstitution->searchByIDInstitution($institusiId) ?? 0;
            $datapermintaan = $this->survey->getTrainingSummaryByYear($year, $institusiId);
               
        }

        return view('institusi/index', [
            'title'      => 'Institusi',
            'userDetail' => $userDetail,
            'data'       => [
                'institusi'         => $institusi,
                'institusi_selected' => $selectedId,
                'institusi_detail'   => $institusiDetail,
                'total_users_institusi'=> $jumlahUserInstitusi,
                'total_users_survey' => $totalSurvey,
                'questionnaire_type' => QuestionnaireModel::listType('institusi'),
                'years' => CommonHelper::years(date('Y')),
                'pengelola' => $pengelola,
                'datapermintaan' => $datapermintaan,
            ],
        ]);
    }



    public function putDetail()
    {
        $userDetailModel = new UserDetailModel();
        $userModel = new UserModel();
        $session = session();

        $datauser = [
            'email' => $this->request->getPost('user_email'),
        ];

        $data = [
            'email' => $this->request->getPost('user_email'),
            'nik'   => $this->request->getPost('user_nik'),
            'nip'   => $this->request->getPost('user_nip'),
            'front_title' => $this->request->getPost('user_front_title'),
            'fullname' => $this->request->getPost('user_fullname'),
            'back_title' => $this->request->getPost('user_back_title'),
            'pangkatgolongan' => $this->request->getPost('user_pangkatgolongan'),
            'jabatan' => $this->request->getPost('user_jabatan'),
            'mobile' => "62" . preg_replace('/\D/', '', $this->request->getPost('user_mobilenumber')),
            'address' => $this->request->getPost('user_address'),
            '_id_provinces' => $this->request->getPost('user_provinces'),
            '_id_regencies' => $this->request->getPost('user_regencies'),
            '_id_districts' => $this->request->getPost('user_districts'),
            '_id_villages' => $this->request->getPost('user_villages'),
            'jenjang_pendidikan' => $this->request->getPost('user_jenjang_pendidikan'),
            'jurusan_profesi' => $this->request->getPost('user_jurusan_profesi'),
        ];


        if ($userDetailModel->where('_id_users', $session->get('_id_users'))->set($data)->update() || $userModel->where('id', $session->get('_id_users'))->set($datauser)->update()) {
            return redirect()->back()->with('update_profil', ['type' => 'success', 'message' => 'Profil berhasil diperbarui']);
        } else {
            return redirect()->back()->with('update_profil', ['type' => 'error', 'message' => 'Gagal memperbarui profil']);
        }
    }

    public function storeUserFasyankes()
    {
        $session = session();
        $fasyankes_code = $this->request->getPost('fasyankes_code');
        $_id_users = $session->get('_id_users');

        if (empty($fasyankes_code)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kode Fasyankes wajib diisi.'
            ]);
        }

        try {
            $fasyankesData = $this->institutions
                ->where('code', $fasyankes_code)
                ->first();

            $existing = $this->userInstitutions
                ->where('_id_users', $_id_users)
                ->where('_id_master_institutions', $fasyankesData['id'])
                ->first();

            if ($existing) {
                if ($existing['status'] === 'true') {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Data fasyankes sudah pernah ditambahkan.'
                    ]);
                } else {
                    $this->userInstitutions->update($existing['id'], [
                        'status' => 'true'
                    ]);

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Data fasyankes berhasil disimpan.'
                    ]);
                }
            }

            $idUsersFasyankes = Uuid::uuid7()->toString();

            $this->userInstitutions->insert([
                'id' => $idUsersFasyankes,
                '_id_users'             => $_id_users,
                '_id_master_institutions'  =>  $fasyankesData['id'],
                'status'                => 'true'
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data fasyankes berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    public function getUserInstitutions()
    {
        $category = $this->request->getGet('c') ?? 'fasyankes';
        $session = session();
        $_id_users = $session->get('_id_users');
        if($category=='nonfasyankes') $classbutton = 'non-fasyankes'; else $classbutton = 'fasyankes';

        $fasyankes  =  $this->userInstitutions->getInstitutionsByUser($_id_users, $category);
        $data = [];
        $no = 1;

        if (empty($fasyankes)) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Data tidak ditemukan',
            ])->setStatusCode(200);
        }

            foreach ($fasyankes as $row) {
                $data[] = [
                    'no'       => $no++,
                    'name'     => strtoupper($row['type'] . ' ' . $row['name']),
                    'address'   => $row['address'],
                    'action'     => '<button class="btn rounded-pill btn-danger btn-sm delete-'.$classbutton.'" data-id="' . $row['id_usersinstitutions'] . '"><i class="icon-base ti tabler-trash icon-sm"></i></button>'
                ];
            }

            return $this->response->setJSON([
                'status'  => true,
                'code'    => 200,
                'type'    => 'success',
                'message' => 'Data ditemukan',
                'data'    => $data
            ])->setStatusCode(200);
    }

    public function deleteUserInstitutions($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'ID wajib diisi']);
            }


            $this->userInstitutions->delete($id);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Institusi berhasil dihapus'
                ]);

        } catch (\Throwable $e) {
            log_message('error', 'Gagal menghapus fasyankes');
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => $e->getMessage()]);
        }

    }

    public function storeUserNonFasyankes()
    {
        $session = session();
        $nonfasyankes_id = $this->request->getPost('nonfasyankes_id');
        $_id_users = $session->get('_id_users');

        if (empty($nonfasyankes_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama Non Fasyankes wajib diisi.'
            ]);
        }

        try {

            $existing = $this->userInstitutions
                ->where('_id_users', $_id_users)
                ->where('_id_master_institutions', $nonfasyankes_id)
                ->first();

            if ($existing) {
                if ($existing['status'] === 'true') {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Data Non Fasyankes sudah pernah ditambahkan.'
                    ]);
                }

                $this->userInstitutions->update($existing['id'], ['status' => 'true']);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data Non Fasyankes berhasil disimpan.'
                ]);
            }

            $this->userInstitutions->insert([
                'id'                        => Uuid::uuid7()->toString(),
                '_id_users'                 => $_id_users,
                '_id_master_institutions'   => $nonfasyankes_id
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data Non fasyankes berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan data' . $e
            ]);
        }
    }



public function storeJobdescCompetence()
{
    $session = session();

    $_id_users      = $session->get('_id_users');
    $jobdescModel   = new UsersJobdescModel();
    $competenceModel= new UsersCompetenceModel();

    $jobDescription = $this->request->getPost('user_uraiantugas');
    $trainings      = $this->request->getPost('user_pelatihan');

    $jobdesc = $jobdescModel
        ->where('_id_users', $_id_users)
        ->where('job_description', $jobDescription)
        ->first();

    if (!$jobdesc) {
        $newJobdescId = Uuid::uuid7()->toString();

        $jobdescModel->insert([
            'id'              => $newJobdescId,
            '_id_users'       => $_id_users,
            'job_description' => $jobDescription
        ]);

        $idUsersJobdesc = $newJobdescId;
    } else {
        $idUsersJobdesc = $jobdesc['id'];
    }

    if (is_array($trainings)) {
        foreach ($trainings as $training) {
            $trainingData = explode("&&", $training);

            $exists = $competenceModel
                ->where('_id_users_jobdesc', $idUsersJobdesc)
                ->where('_id_master_training', $trainingData[0])
                ->first();

            if (!$exists) {
                $newCompetenceId = Uuid::uuid7()->toString();
                $competenceModel->insert([
                    'id'                  => $newCompetenceId,
                    '_id_users_jobdesc'   => $idUsersJobdesc,
                    '_id_master_training' => $trainingData[0],
                    'status'              => $trainingData[1]
                ]);
            }
        }
    }

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Data berhasil disimpan.'
    ], ResponseInterface::HTTP_OK);
}

    public function listJobDescCompetence()
    {
        $request = service('request');
        $draw   = $request->getVar('draw');
        $start  = $request->getVar('start');
        $length = $request->getVar('length');
        $search = $request->getVar('search')['value'];

        $jobdescModel    = new UsersJobdescModel();
        $competenceModel = new UsersCompetenceModel();

        $totalRecords = $jobdescModel->countAll();

        $builder = $jobdescModel;

        if (!empty($search)) {
            $builder = $builder->like('job_description', $search, 'both', null, true);
        }

        $jobdescs = $builder->where('_id_users', session()->get('_id_users'))->findAll($length, $start);

        if (!empty($search)) {
            $totalFiltered = $jobdescModel
                ->like('job_description', $search, 'both', null, true)
                ->countAllResults(false);
        } else {
            $totalFiltered = $totalRecords;
        }
        $no=1;
        $data = [];
        foreach ($jobdescs as $jd) {
            $kompetensi = $competenceModel
                ->select('users_competence.id, master_training.nama_pelatihan, users_competence.status')
                ->join('master_training', 'master_training.id = users_competence._id_master_training')
                ->where('_id_users_jobdesc', $jd['id'])
                ->orderBy('users_competence.id', 'ASC')
                ->findAll();

            $data[] = [
                'no'                => $no++,
                'id'                => $jd['id'],
                'job_description'   => $jd['job_description'],
                'jumlah_kompetensi' => count($kompetensi),
                'kompetensi'        => $kompetensi
            ];
        }

        return $this->response->setJSON([
            "draw"            => intval($draw),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
        ]);
    }

    public function updateStatusCompetence()
    {
        $id     = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $competenceModel = new UsersCompetenceModel();

        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID tidak ditemukan'
            ]);
        }

        $update = $competenceModel->update($id, ['status' => $status]);

        if ($update) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status berhasil diupdate'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal update database'
            ]);
        }
    }

    public function deleteCompetence()
    {
        $id = $this->request->getPost('id');
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID tidak valid'
            ]);
        }

        $competenceModel = new UsersCompetenceModel();
        $jobdescModel    = new UsersJobdescModel();

        $idUserJobdesc = $competenceModel->where('id', $id)->get()->getRowArray()['_id_users_jobdesc'] ?? null;
        if (!$idUserJobdesc) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data kompetensi tidak ditemukan'
            ]);
        }

        if ($competenceModel->delete($id)) {
            if ($competenceModel->where('_id_users_jobdesc', $idUserJobdesc)->countAllResults() == 0) {
                $jobdescModel->delete($idUserJobdesc);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kompetensi berhasil dihapus'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus kompetensi'
        ]);
    }



}
