<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\UserDetailModel;
use App\Models\UsersFasyankesModel;
use App\Models\UsersNonFasyankesModel;
use App\Services\NotificationService;

class Profile extends BaseController
{
    
    protected $usersFasyankesModel;
    protected $usersNonFasyankesModel;

    public function __construct()
    {
        $this->usersFasyankesModel = new UsersFasyankesModel();
        $this->usersNonFasyankesModel = new UsersNonFasyankesModel();
    }
    
    public function index()
    {  
        $session = session();
        $email = $session->get('email'); 

        $userModel = new UserModel();

        $data = $userModel->select('users.*, users_detail.*, master_area_provinces.name as users_provinsi, master_area_regencies.name as users_kabkota, master_area_districts.name as users_kecamatan, master_area_villages.name as users_kelurahan')
            ->join('users_detail', 'users.email = users_detail.email', 'left')            
            ->join('master_area_provinces', 'master_area_provinces.id = users_detail.users_provinces', 'left')
            ->join('master_area_regencies', 'master_area_regencies.id = users_detail.users_regencies', 'left')
            ->join('master_area_districts', 'master_area_districts.id = users_detail.users_districts', 'left')
            ->join('master_area_villages', 'master_area_villages.id = users_detail.users_villages', 'left')
            ->where('users.email', $email)
            ->first();

            if (!empty($data['mobile']) && substr($data['mobile'], 0, 2) === '62') {
                $data['mobile'] = substr($data['mobile'], 2); 
            }
            
            $jenjangPendidikan = [
                'tk'       => 'Taman Kanak-kanak (TK)',
                'sd'       => 'Sekolah Dasar (SD)',
                'smp'      => 'Sekolah Menengah Pertama (SMP)',
                'sma-smk'  => 'Sekolah Menengah Atas / SMK (SMA/SMK)',
                'd1'       => 'Diploma 1 (D1)',
                'd2'       => 'Diploma 2 (D2)',
                'd3'       => 'Diploma 3 (D3)',
                'd4'       => 'Diploma 4 (D4)',
                's1'       => 'Sarjana (S1)',
                's2'       => 'Magister (S2)',
                's3'       => 'Doktor (S3)',
            ];

            $jurusanProfesi = [
                // Tenaga Medis
                'dokter-umum'           => 'Dokter Umum',
                'dokter-spesialis'      => 'Dokter Spesialis',
                'dokter-gigi'           => 'Dokter Gigi',
                'dokter-gigi-spesialis' => 'Dokter Gigi Spesialis',
                'bidan'                 => 'Bidan',
                'perawat'               => 'Perawat',
                'perawat-gigi'          => 'Perawat Gigi',

                // Tenaga Kesehatan Lain
                'farmasi'               => 'Apoteker (Farmasi)',
                'asisten-apoteker'      => 'Tenaga Teknis Kefarmasian',
                'analis-kesehatan'      => 'Analis Kesehatan / Teknologi Laboratorium Medis',
                'sanitarian'            => 'Sanitarian (Kesehatan Lingkungan)',
                'gizi'                  => 'Ahli Gizi / Nutrisionis',
                'radiografer'           => 'Radiografer',
                'fisioterapis'          => 'Fisioterapis',
                'terapis-okupasi'       => 'Terapis Okupasi',
                'terapis-wicara'        => 'Terapis Wicara',
                'rekam-medis'           => 'Perekam Medis dan Informasi Kesehatan',
                'psikolog-klinis'       => 'Psikolog Klinis',
                'skm'                   => 'Sarjana Kesehatan Masyarakat (SKM)',

                // Lainnya
                'lainnya'               => 'Lainnya'
            ];


        // default
        return view('users/profile', ['title' => 'Profile','data'  => $data, 'jenjangPendidikan' => $jenjangPendidikan, 'jurusanProfesi' => $jurusanProfesi]);
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
           return redirect()->back()->with('update_profil', ['type' => 'success','message' => 'Profil berhasil diperbarui']);
        } else {
           return redirect()->back()->with('update_profil', ['type' => 'error','message' => 'Gagal memperbarui profil']);
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
                
                if($existing['status']=='true'){                    
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Data fasyankes sudah pernah ditambahkan.'
                    ]);
                }else{
                    
                $updated = $this->usersFasyankesModel->update($existing['id'], ['status' => 'true']);

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Data fasyankes berhasil disimpan.'
                    ]);

                }

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
                
                if($existing['status']=='true'){                    
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Data Non Fasyankes sudah pernah ditambahkan.'
                    ]);
                }else{
                    
                $updated = $this->usersNonFasyankesModel->update($existing['id'], ['status' => 'true']);

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Data Non Fasyankes berhasil disimpan.'
                    ]);

                }

            // Jika belum ada, simpan baru
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
                'message' => 'Gagal menyimpan data'
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
                ->where('users_nonfasyankes.status','true')
                ->where('users_nonfasyankes.email', $email)
                ->findAll();

            $data = [];
            $no = 1;
            foreach ($fasyankes as $row) {
                $data[] = [
                    'no'       => $no++,
                    'non_fasyankes'=> $row['nonfasyankes_name'],
                    'alamat'   => $row['nonfasyankes_address'],
                    'aksi'     => '<button class="btn btn-danger btn-sm delete-non-fasyankes" data-id="'.$row['id_users_nonfasyankes'].'"><i class="icon-base ti tabler-trash icon-sm"></i></button>'
                ];
            }

            return $this->response->setJSON(['data' => $data]);
        } catch (\Throwable $e) {
            log_message('error', 'Error getUserFasyankes: '.$e->getMessage());
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

}
