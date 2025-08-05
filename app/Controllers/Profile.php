<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\UserDetailModel;
use App\Models\UsersFasyankesModel;
use App\Services\NotificationService;

class Profile extends BaseController
{
    
    protected $usersFasyankesModel;

    public function __construct()
    {
        $this->usersFasyankesModel = new UsersFasyankesModel();
    }
    
    public function index()
    {  
        $session = session();
        $email = $session->get('email'); 

        $userModel = new UserModel();

        $data = $userModel->select('users.*, users_detail.*')
            ->join('users_detail', 'users.email = users_detail.email', 'left')
            ->where('users.email', $email)
            ->first();

            if (!empty($data['mobile']) && substr($data['mobile'], 0, 2) === '62') {
                $data['mobile'] = substr($data['mobile'], 2); 
            }
            

        $p = $this->request->getGet('p');

        $views = [
            'fasyankes' => ['users/fasyankes', 'Fasyankes'],
            'alamat'     => ['users/address', 'Alamat'],
        ];

        if ($p && isset($views[$p])) {
            return view($views[$p][0], [
                'title' => $views[$p][1],
                'data'  => $data
            ]);
        }

        // default
        return view('users/profile', ['title' => 'Profile','data'  => $data]);
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
                ->where('status','true')
                ->first();

            if ($existing) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data fasyankes sudah pernah ditambahkan.'
                ]);
            }

            // Jika belum ada, simpan baru
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
                ->where('users_fasyankes.status','true')
                ->where('users_fasyankes.email', $email)
                ->findAll();

            $data = [];
            $no = 1;
            foreach ($fasyankes as $row) {
                $data[] = [
                    'no'       => $no++,
                    'fasyankes'=> strtoupper($row['fasyankes_type'].' '.$row['fasyankes_name']),
                    'alamat'   => $row['fasyankes_address'],
                    'aksi'     => '<button class="btn btn-danger btn-sm delete-fasyankes" data-id="'.$row['id'].'"><i class="icon-base ti tabler-trash icon-sm"></i></button>'
                ];
            }

            return $this->response->setJSON(['data' => $data]);
        } catch (\Throwable $e) {
            log_message('error', 'Error getUserFasyankes: '.$e->getMessage());
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

}
