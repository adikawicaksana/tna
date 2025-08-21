<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserDetailModel;
use App\Models\UsersFasyankesModel;
use App\Models\UsersNonFasyankesModel;
use App\Models\ReferenceDataModel;
use App\Models\UsersJobdescModel;
use App\Models\UsersCompetenceModel;
use App\Services\NotificationService;

class Profile extends BaseController
{

    protected $userModel;
    protected $userDetailModel;
    protected $usersFasyankesModel;
    protected $usersNonFasyankesModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userDetailModel = new UserDetailModel();
        $this->usersFasyankesModel = new UsersFasyankesModel();
        $this->usersNonFasyankesModel = new UsersNonFasyankesModel();
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

    public function putDetail()
    {
        $userDetailModel = new UserDetailModel();
        $session = session();

        $data = [
            'email' => $this->request->getPost('user_email'),
            'nik'   => $this->request->getPost('user_nik'),
            'nip'   => $this->request->getPost('user_nip'),
            'front_title' => $this->request->getPost('user_front_title'),
            'fullname' => $this->request->getPost('user_fullname'),
            'back_title' => $this->request->getPost('user_back_title'),
            'pangkatgolongan' => $this->request->getPost('user_pangkatgolongan'),
            'jabatan' => $this->request->getPost('user_jabatan'),
            'bidangkerja' => $this->request->getPost('user_bidangkerja'),
            'mobile' => "62" . preg_replace('/\D/', '', $this->request->getPost('user_mobilenumber')),
            'address' => $this->request->getPost('user_address'),
            'users_provinces' => $this->request->getPost('user_provinces'),
            'users_regencies' => $this->request->getPost('user_regencies'),
            'users_districts' => $this->request->getPost('user_districts'),
            'users_villages' => $this->request->getPost('user_villages'),
            'jenjang_pendidikan' => $this->request->getPost('user_jenjang_pendidikan'),
            'jurusan_profesi' => $this->request->getPost('user_jurusan_profesi'),
        ];

        if ($userDetailModel->update($session->get('email'), $data)) {
            return redirect()->back()->with('update_profil', ['type' => 'success', 'message' => 'Profil berhasil diperbarui']);
        } else {
            return redirect()->back()->with('update_profil', ['type' => 'error', 'message' => 'Gagal memperbarui profil']);
        }
    }

    public function storeUserFasyankes()
    {
        $session = session();
        $fasyankes_code = $this->request->getPost('fasyankes_code');
        $email = $session->get('email');

        if (empty($fasyankes_code)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kode Fasyankes wajib diisi.'
            ]);
        }

        try {
            $existing = $this->usersFasyankesModel
                ->where('email', $email)
                ->where('fasyankes_code', $fasyankes_code)
                ->first();

            if ($existing) {

                if ($existing['status'] == 'true') {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Data fasyankes sudah pernah ditambahkan.'
                    ]);
                } else {

                    $updated = $this->usersFasyankesModel->update($existing['id'], ['status' => 'true']);

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Data fasyankes berhasil disimpan.'
                    ]);
                }
            }

            $this->usersFasyankesModel->insert([
                'email'          => $email,
                'fasyankes_code' => $fasyankes_code
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data fasyankes berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan data'
            ]);
        }
    }

    public function getUserFasyankes()
    {
        try {
            $session = session();
            $email = $session->get('email');

            $usersFasyankesModel = new \App\Models\UsersFasyankesModel();
            $fasyankes = $usersFasyankesModel
                ->select('*')
                ->join('master_fasyankes', 'master_fasyankes.fasyankes_code = users_fasyankes.fasyankes_code', 'left')
                ->where('users_fasyankes.status', 'true')
                ->where('users_fasyankes.email', $email)
                ->findAll();

            $data = [];
            $no = 1;
            foreach ($fasyankes as $row) {
                $data[] = [
                    'no'       => $no++,
                    'fasyankes' => strtoupper($row['fasyankes_type'] . ' ' . $row['fasyankes_name']),
                    'alamat'   => $row['fasyankes_address'],
                    'aksi'     => '<button class="btn rounded-pill btn-danger btn-sm delete-fasyankes" data-id="' . $row['id'] . '"><i class="icon-base ti tabler-trash icon-sm"></i></button>'
                ];
            }

            return $this->response->setJSON(['data' => $data]);
        } catch (\Throwable $e) {
            log_message('error', 'Error getUserFasyankes: ' . $e->getMessage());
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function deleteUserFasyankes($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'ID wajib diisi']);
            }

            $usersFasyankesModel = new \App\Models\UsersFasyankesModel();

            $updated = $usersFasyankesModel->update($id, ['status' => 'false']);

            if ($updated) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Fasyankes berhasil dihapus'
                ]);
            } else {
                return $this->response->setStatusCode(400)
                    ->setJSON(['success' => false, 'message' => 'Gagal menghapus fasyankes']);
            }
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
        $email = $session->get('email');

        if (empty($nonfasyankes_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama Non Fasyankes wajib diisi.'
            ]);
        }

        try {
            $existing = $this->usersNonFasyankesModel
                ->where('email', $email)
                ->where('nonfasyankes_id', $nonfasyankes_id)
                ->first();
            if ($existing) {
                if ($existing['status'] === 'true') {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Data Non Fasyankes sudah pernah ditambahkan.'
                    ]);
                }

                $this->usersNonFasyankesModel->update($existing['id'], ['status' => 'true']);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data Non Fasyankes berhasil disimpan.'
                ]);
            }

            $this->usersNonFasyankesModel->insert([
                'email'          => $email,
                'nonfasyankes_id' => $nonfasyankes_id
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

    public function getUserNonFasyankes()
    {
        try {
            $session = session();
            $email = $session->get('email');

            $usersNonFasyankesModel = new \App\Models\UsersNonFasyankesModel();
            $fasyankes = $usersNonFasyankesModel
                ->select('*, users_nonfasyankes.id as id_users_nonfasyankes')
                ->join('master_nonfasyankes', 'master_nonfasyankes.id = users_nonfasyankes.nonfasyankes_id', 'left')
                ->where('users_nonfasyankes.status', 'true')
                ->where('users_nonfasyankes.email', $email)
                ->findAll();

            $data = [];
            $no = 1;
            foreach ($fasyankes as $row) {
                $data[] = [
                    'no'       => $no++,
                    'non_fasyankes' => $row['nonfasyankes_name'],
                    'alamat'   => $row['nonfasyankes_address'],
                    'aksi'     => '<button class="btn rounded-pill btn-danger btn-sm delete-non-fasyankes" data-id="' . $row['id_users_nonfasyankes'] . '"><i class="icon-base ti tabler-trash icon-sm"></i></button>'
                ];
            }

            return $this->response->setJSON(['data' => $data]);
        } catch (\Throwable $e) {
            log_message('error', 'Error getUserFasyankes: ' . $e->getMessage());
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function deleteUserNonFasyankes($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'ID wajib diisi']);
            }

            $usersNonFasyankesModel = new \App\Models\UsersNonFasyankesModel();

            $updated = $usersNonFasyankesModel->update($id, ['status' => 'false']);

            if ($updated) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Non Fasyankes berhasil dihapus'
                ]);
            } else {
                return $this->response->setStatusCode(400)
                    ->setJSON(['success' => false, 'message' => 'Gagal menghapus non fasyankes']);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Gagal menghapus non fasyankes');
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function storeJobdescCompetence()
    {
        $session = session();

        $email = $session->get('email');
        $jobdescModel     = new UsersJobdescModel();
        $competenceModel  = new UsersCompetenceModel();

        $jobDescription = $this->request->getPost('user_uraiantugas');
        $trainings      = $this->request->getPost('user_pelatihan'); 

        $jobdesc = $jobdescModel
            ->where('email', $email)
            ->where('job_description', $jobDescription)
            ->first();

        if (!$jobdesc) {
            $idUsersJobdesc = $jobdescModel->insert([
                'email'          => $email,
                'job_description'=> $jobDescription
            ], true); 
        } else {
            $idUsersJobdesc = $jobdesc['id'];
        }

        if (is_array($trainings)) {
            foreach ($trainings as $training) {
                $trainingData = explode("&&",$training);
                $exists = $competenceModel
                    ->where('id_users_jobdesc', $idUsersJobdesc)
                    ->where('id_training', $trainingData[0])
                    ->first();

                if (!$exists) {
                    $competenceModel->insert([
                        'id_users_jobdesc' => $idUsersJobdesc,
                        'id_training'              => $trainingData[0],
                        'status'            => $trainingData[1]
                    ]);
                }
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
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

        $jobdescs = $builder->findAll($length, $start);

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
                ->join('master_training', 'master_training.id = users_competence.id_training')
                ->where('id_users_jobdesc', $jd['id'])
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

        $idUserJobdesc = $competenceModel->where('id', $id)->get()->getRowArray()['id_users_jobdesc'] ?? null;
        if (!$idUserJobdesc) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data kompetensi tidak ditemukan'
            ]);
        }

        if ($competenceModel->delete($id)) {
            if ($competenceModel->where('id_users_jobdesc', $idUserJobdesc)->countAllResults() == 0) {
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
