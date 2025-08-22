<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Models\UserDetailModel;
use App\Models\UsersFasyankesModel;
use App\Models\UsersNonFasyankesModel;
use App\Models\ReferenceDataModel;
use App\Models\UsersJobdescModel;
use App\Models\UsersCompetenceModel;
use App\Models\FasyankesModel;
use App\Services\NotificationService;
use CodeIgniter\HTTP\ResponseInterface;

class Profile extends BaseController
{

    protected $userModel;
    protected $userDetailModel;
    protected $usersFasyankesModel;
    protected $usersNonFasyankesModel;
    protected $fasyankesModel;

    public function __construct()
    {
        $this->fasyankesModel = new FasyankesModel();
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
            'bidangkerja' => $this->request->getPost('user_bidangkerja'),
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
            $fasyankesData = $this->fasyankesModel
                ->where('fasyankes_code', $fasyankes_code)
                ->first();

            $existing = $this->usersFasyankesModel
                ->where('_id_users', $_id_users)
                ->where('_id_master_fasyankes', $fasyankesData['id'])
                ->first();

            if ($existing) {
                if ($existing['status'] === 'true') {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Data fasyankes sudah pernah ditambahkan.'
                    ]);
                } else {
                    $this->usersFasyankesModel->update($existing['id'], [
                        'status' => 'true'
                    ]);

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Data fasyankes berhasil disimpan.'
                    ]);
                }
            }            

            // generate UUID baru
            $idUsersFasyankes = Uuid::uuid7()->toString();

            $this->usersFasyankesModel->insert([
                'id' => $idUsersFasyankes,
                '_id_users'             => $_id_users,
                '_id_master_fasyankes'  =>  $fasyankesData['id'],
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

    public function getUserFasyankes()
    {
        try {
            $session = session();
            $_id_users = $session->get('_id_users');

            $usersFasyankesModel = new \App\Models\UsersFasyankesModel();
            $fasyankes = $usersFasyankesModel
                ->select('*, users_fasyankes.id as id_userfasyankes')
                ->join('master_fasyankes', 'master_fasyankes.id = users_fasyankes._id_master_fasyankes', 'left')
                ->where('users_fasyankes.status', 'true')
                ->where('users_fasyankes._id_users', $_id_users)
                ->findAll();

            $data = [];
            $no = 1;
            foreach ($fasyankes as $row) {
                $data[] = [
                    'no'       => $no++,
                    'fasyankes' => strtoupper($row['fasyankes_type'] . ' ' . $row['fasyankes_name']),
                    'alamat'   => $row['fasyankes_address'],
                    'aksi'     => '<button class="btn rounded-pill btn-danger btn-sm delete-fasyankes" data-id="' . $row['id_userfasyankes'] . '"><i class="icon-base ti tabler-trash icon-sm"></i></button>'
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
        $_id_users = $session->get('_id_users');

        if (empty($nonfasyankes_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama Non Fasyankes wajib diisi.'
            ]);
        }

        try {
            $existing = $this->usersNonFasyankesModel
                ->where('_id_users', $_id_users)
                ->where('_id_master_nonfasyankes', $nonfasyankes_id)
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
                'id'                        => Uuid::uuid7()->toString(),
                '_id_users'                 => $_id_users,
                '_id_master_nonfasyankes'   => $nonfasyankes_id
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
            $_id_users = $session->get('_id_users');

            $usersNonFasyankesModel = new \App\Models\UsersNonFasyankesModel();
            $fasyankes = $usersNonFasyankesModel
                ->select('*, users_nonfasyankes.id as id_users_nonfasyankes')
                ->join('master_nonfasyankes', 'master_nonfasyankes.id = users_nonfasyankes._id_master_nonfasyankes', 'left')
                ->where('users_nonfasyankes.status', 'true')
                ->where('users_nonfasyankes._id_users', $_id_users)
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

    $_id_users      = $session->get('_id_users');
    $jobdescModel   = new UsersJobdescModel();
    $competenceModel= new UsersCompetenceModel();

    $jobDescription = $this->request->getPost('user_uraiantugas');
    $trainings      = $this->request->getPost('user_pelatihan'); 

    // Cek apakah jobdesc sudah ada
    $jobdesc = $jobdescModel
        ->where('_id_users', $_id_users)
        ->where('job_description', $jobDescription)
        ->first();

    if (!$jobdesc) {
        // Generate UUID baru untuk tabel jobdesc
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

    // Insert kompetensi kalau ada data training
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
