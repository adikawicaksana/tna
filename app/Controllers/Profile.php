<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Models\UserDetailModel;
use App\Models\InstitutionsModel;
use App\Models\UsersInstitutionsModel;
use App\Models\ReferenceDataModel;
use App\Models\UsersJobdescModel;
use App\Models\UsersCompetenceModel;
use App\Models\MasterTrainingModel;
use App\Services\NotificationService;
use CodeIgniter\HTTP\ResponseInterface;

class Profile extends BaseController
{

    protected $userModel;
    protected $userDetailModel;
    protected $institutions;
    protected $userInstitutions;


    public function __construct()
    {
        $this->institutions = new InstitutionsModel();
        $this->userInstitutions = new UsersInstitutionsModel;
        $this->userModel = new UserModel();
        $this->userDetailModel = new UserDetailModel();

    }

    public function index()
    {

        $userDetail = $this->userDetailModel->getUserDetail();

        if (!empty($userDetail['mobile']) && substr($userDetail['mobile'], 0, 2) === '62') {
            $userDetail['mobile'] = substr($userDetail['mobile'], 2);
        }

        $refModel = new ReferenceDataModel();
        $jenjangPendidikan = $refModel->getJenjangPendidikan();
        $jurusanProfesi = $refModel->getJurusanProfesi();


        return view('users/profile', ['title' => 'Profile', 'userDetail' => $userDetail, 'data'  => $userDetail, 'jenjangPendidikan' => $jenjangPendidikan, 'jurusanProfesi' => $jurusanProfesi]);
    }

    /**
     * Helper response
     */
    private function errorResponse(string $message, int $code = 400)
    {
        return $this->response->setJSON([
            'success' => false,
            'message' => $message
        ], $code);
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
        
        $data['jurusan_profesi_others'] = $this->request->getPost('user_jurusan_profesi_manual') ?? null;



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
        if ($category == 'nonfasyankes') $classbutton = 'non-fasyankes';
        else $classbutton = 'fasyankes';

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
                'action'     => '<button class="btn rounded-pill btn-danger btn-sm delete-' . $classbutton . '" data-id="' . $row['id_usersinstitutions'] . '"><i class="icon-base ti tabler-trash icon-sm"></i></button>'
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

        $_id_users = $session->get('_id_users');
        if (!$_id_users) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ], ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $jobDescription = trim((string) $this->request->getPost('user_uraiantugas'));
        $trainings      = $this->request->getPost('user_pelatihan');

        if ($jobDescription === '') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Uraian tugas wajib diisi!'
            ], 400);
        }

        if (!is_array($trainings) || empty($trainings)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pengembangan kompetensi wajib diisi!'
            ], 400);
        }

        $validatedTrainings = [];
        $trainingIds        = [];

        foreach ($trainings as $training) {

            if (!is_string($training)) {
                return $this->errorResponse('Data pengembangan kompetensi tidak valid');
            }

            $parts = explode('&&', $training, 2);
            if (count($parts) !== 2) {
                return $this->errorResponse('Format data pengembangan kompetensi tidak valid');
            }

            [$trainingId, $status] = $parts;

            if ($trainingId === '' || !in_array($status, ['0', '1'], true)) {
                return $this->errorResponse('Data pengembangan kompetensi tidak valid');
            }

            $validatedTrainings[] = [
                'training_id' => $trainingId,
                'status'      => $status
            ];

            $trainingIds[] = $trainingId;
        }

        $trainingModel = new \App\Models\MasterTrainingModel();

        $existingIds = $trainingModel
            ->whereIn('id', $trainingIds)
            ->findColumn('id');

        if (count($existingIds) !== count(array_unique($trainingIds))) {
            return $this->errorResponse('Data pengembangan kompetensi tidak ditemukan');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $jobdescModel    = new \App\Models\UsersJobdescModel();
            $competenceModel = new \App\Models\UsersCompetenceModel();

            // Jobdesc
            $jobdesc = $jobdescModel
                ->where('_id_users', $_id_users)
                ->where('job_description', $jobDescription)
                ->first();

            $idUsersJobdesc = $jobdesc['id'] ?? Uuid::uuid7()->toString();

            if (!$jobdesc) {
                $jobdescModel->insert([
                    'id'              => $idUsersJobdesc,
                    '_id_users'       => $_id_users,
                    'job_description' => $jobDescription
                ]);
            }

            // Existing competence
            $existingCompetence = $competenceModel
                ->where('_id_users_jobdesc', $idUsersJobdesc)
                ->findColumn('_id_master_training');

            // Insert competence
            foreach ($validatedTrainings as $item) {
                if (in_array($item['training_id'], $existingCompetence, true)) {
                    continue;
                }

                $competenceModel->insert([
                    'id'                  => Uuid::uuid7()->toString(),
                    '_id_users_jobdesc'   => $idUsersJobdesc,
                    '_id_master_training' => $item['training_id'],
                    'status'              => $item['status']
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return $this->errorResponse('Gagal menyimpan data', 500);
            }

            $db->transCommit();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil disimpan.'
            ], ResponseInterface::HTTP_OK);

        } catch (\Throwable $e) {

            $db->transRollback();
            log_message('error', $e->getMessage());

            return $this->errorResponse('Terjadi kesalahan sistem', 500);
        }
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
        $no = 1;
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

    public function getIncompleteCompetence()
    {
        $_id_users = $this->request->getGet('_id_users') ?? session()->get('_id_users');
        $builder = \Config\Database::connect();
        $result = $builder->table('users_competence c')
            ->join('users_jobdesc j', 'c._id_users_jobdesc = j.id')
            ->join('master_training t', 'c._id_master_training = t.id')
            ->select('DISTINCT(c._id_master_training) AS training_id, t.nama_pelatihan')
            ->where([
                'c.status' => 0,
                'j._id_users' => $_id_users
            ])
            ->get()
            ->getResult();

        return $this->response->setJSON($result);
    }
}
