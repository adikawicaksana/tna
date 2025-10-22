<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Models\UserDetailModel;
use App\Models\InstitutionsModel;
use App\Models\UsersInstitutionsModel;
use App\Services\NotificationService;
use App\Helpers\CommonHelper;

class Register extends BaseController
{
    protected $notifService;
    protected $institutions;
    protected $userInstitutions;
    
     public function __construct()
    {
        $this->notifService = new NotificationService();
        $this->institutions = new InstitutionsModel();
        $this->userInstitutions = new UsersInstitutionsModel;
    }

    public function index()
    {
        $data = [
            'title' => 'Register'
        ];

        return view('register', $data);
    }


    public function store()
    {
        $request = $this->request;
        $session = session();

        $mode     = $request->getPost('fasyankes_mode');
        $email    = strtolower(trim($request->getPost('user_email')));
        $password = $request->getPost('user_password');
        $fullname = $request->getPost('user_fullname');
        $mobile   = "62" . preg_replace('/\D/', '', $request->getPost('user_mobilenumber'));
        $captcha  = strtoupper(trim($request->getPost('captcha')));

        $rules = [
            'user_fullname'     => 'Masukan Nama lengkap Anda (tanpa gelar).',
            'user_mobilenumber' => 'Masukan Nomor Handphone.',
            'user_email'        => 'Email tidak boleh kosong.',
            'user_password'     => 'Password tidak boleh kosong.'
        ];
        foreach ($rules as $field => $message) {
            if (! $request->getPost($field)) {
                return $this->response->setJSON([
                    'status'  => false,
                    'code'    => 400,
                    'type'    => 'warning',
                    'message' => $message,
                    'data'    => []
                ]);
            }
        }

        $captchaData = $session->get('captcha');
        if (!$captchaData) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Masukan Captcha',
                'data'    => []
            ]);
        }
        if (time() > $captchaData['expire']) {
            $session->remove('captcha');
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Captcha kadaluarsa',
                'data'    => []
            ]);
        }
        if (! password_verify($captcha, $captchaData['hash'])) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Captcha salah',
                'data'    => []
            ]);
        }
        $session->remove('captcha');
        
       $checknumber = $this->notifService->checkNumberWhatsApp($mobile);
       if(empty($checknumber['jid'])){
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Nomor yang anda masukan tidak terdaftar sebagai Nomor WhatsApp, Masukan nomor WhatsApp anda',
                'data'    => []
            ]);
        }

        $userModel   = new UserModel();
        $detailModel = new UserDetailModel();

        $builder = $userModel->builder();
        $builder->select('users.id, users.email, users.status, users_detail.mobile');
        $builder->join('users_detail', 'users_detail._id_users = users.id', 'left');
        $builder->groupStart()
            ->where('users.email', $email)
            ->orWhere('users_detail.mobile', $mobile)
            ->groupEnd();
        $user = $builder->get()->getRowArray();

        if ($user) {
            if ($user['status'] === 'pending') {
                return $this->handlePendingUser($user, $session, $user['mobile']);
            }
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Email atau Nomor Handphone sudah terdaftar dan aktif.',
                'data'    => []
            ]);
        }

        $newIDUser=Uuid::uuid7()->toString();
        $newIDDetailUser=Uuid::uuid7()->toString();
        $userModel->insert([
            'id'        => $newIDUser,
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'status'    => 'pending',
            'user_role' => 3
        ]);

        $detailModel->insert([ 
            'id'       => $newIDDetailUser,
            '_id_users'=> $newIDUser,
            'fullname' => $fullname,
            'email'    => $email,
            'mobile'   => $mobile
        ]);


 $detail_user = $detailModel->where('_id_users', $newIDUser)->first();
    if($detail_user){
       if (in_array($mode, ['fasyankes', 'non-fasyankes'])) {
            $data = [
                'id'        => Uuid::uuid7()->toString(),
                '_id_users' => $newIDUser
            ];            

           if ($mode === 'fasyankes') {
                $institution = $this->institutions
                    ->where('code', $request->getPost('fasyankes_code'))
                    ->first();
            } else {
                $institution = $this->institutions
                    ->where('id', $request->getPost('nonfasyankes_id'))
                    ->first();
            }

            if ($institution) {
                $data['_id_master_institutions'] = $institution['id'];
                $this->userInstitutions->insert($data);
            }
        }

        $this->generateOtpAndResponse($session, $mobile, $email, $newIDUser);

        
       

        return $this->response->setJSON([
                'status'    => true,
                'code'      => 200,
                'type'      => 'success',
                'message'   => 'Registrasi diterima, dan OTP telah dikirim.'.$checknumber,
                'data'      => $detail_user
            ])->setStatusCode(200);

        }else{

        return $this->response->setJSON([
        'status'  => false,
        'code'    => 400,
        'type'    => 'warning',
        'message' => 'Registrasi Gagal',
        'data'    => []
            ])->setStatusCode(400);
        }

    }

    private function handlePendingUser($user, $session, $mobile)
    {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $session->set('otp_data', [
            'hash'        => password_hash($otp, PASSWORD_DEFAULT),
            'expire'      => time() + 300,
            'generated_at'=> time(),
            'id'     => $user['id'], 
            'email'       => $user['email']
        ]);

        $sendStatus = $this->sendOtpToApi($mobile, $otp);

        return $this->response->setJSON([        
            'status'  => false,
            'code'    => 400,
            'type'    => 'warning',
            'message' => 'Akun Anda belum aktif. Kami telah mengirim OTP baru.',
            'show_otp_modal'=> true,
            'data'    => ["mobile"=>$mobile]
        ]);
    }

    private function generateOtpAndResponse($session, $mobile, $email, $newIDUser)
    {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $session->set('otp_data', [
            'hash'        => password_hash($otp, PASSWORD_DEFAULT),
            'expire'      => time() + 300,
            'generated_at'=> time(),
            'id'          => $newIDUser, 
            'email'       => $email
        ]);

        $sendStatus = $this->sendOtpToApi($mobile, $otp);

        return $this->response->setJSON([
            'status'        => $sendStatus['success'],
            'message'       => $sendStatus['message'],
            'show_otp_modal'=> $sendStatus['success']
        ]);
    }

    public function verifyOtp()
    {
        $session  = session();
        $inputOtp = $this->request->getPost('otp');
        $otpData  = $session->get('otp_data');

        if (!$otpData) {
             return $this->response->setJSON([
                'status'    => false,
                'code'      => 400,
                'type'      => 'warning',
                'message'   => 'OTP tidak ditemukan',
                'data'      => []
            ])->setStatusCode(200);
        }
        if (time() > $otpData['expire']) {
            $session->remove('otp_data');
            
             return $this->response->setJSON([
                'status'    => false,
                'code'      => 400,
                'type'      => 'warning',
                'message'   => 'OTP sudah kadaluarsa',
                'data'      => []
            ])->setStatusCode(200);
        }
        if (!password_verify($inputOtp, $otpData['hash'])) {
            
             return $this->response->setJSON([
                'status'    => false,
                'code'      => 400,
                'type'      => 'warning',
                'message'   => 'OTP salah',
                'data'      => []
            ])->setStatusCode(200);
        }

        $userModel = new UserModel();
        $userModel->update($otpData['id'], ['status' => 'active']);
        $session->remove('otp_data');

         return $this->response->setJSON([
                'status'    => true,
                'code'      => 200,
                'type'      => 'success',
                'message'   => 'Registrasi Berhasil, silahkan login menggunakan email anda.',
                'data'      => []
            ])->setStatusCode(200);
    }

    public function resendOtp()
    {
        $session = session();
        $otpData = $session->get('otp_data');

        if (!$otpData || empty($otpData['id'])) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Sesi OTP tidak ditemukan, silakan registrasi ulang'
            ]);
        }

        // Cegah spam OTP (minimal jeda 60 detik)
        if (isset($otpData['generated_at']) && (time() - $otpData['generated_at']) < 60) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Silakan tunggu 1 menit sebelum meminta OTP lagi'
            ]);
        }

        $userDetailModel = new \App\Models\UserDetailModel();
        $detail = $userDetailModel->where('_id_users', $otpData['id'])->first();

        if (!$detail || empty($detail['mobile'])) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Nomor HP tidak ditemukan'
            ]);
        }

        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan ke session (replace OTP lama)
        $session->set('otp_data', [
            'hash'        => password_hash($otp, PASSWORD_DEFAULT),
            'expire'      => time() + 300,
            'generated_at'=> time(),
            'id'           => $otpData['id'],
            'email'     => $otpData['email']
        ]);

        

        // Kirim OTP ke API
        $sendStatus = $this->sendOtpToApi($detail['mobile'], $otp);

        return $this->response->setJSON([
            'status'  => $sendStatus['success'],
            'message' => $sendStatus['message']
        ]);
    }

    
    private function sendOtpToApi(string $phone, string $otp): array
    {
        
        $pesan = "Hallo Sobat Murnajati, Selamat ".CommonHelper::timeGreeting().". \n\n";
        $pesan .= "Kode OTP Anda: $otp \n(berlaku 5 menit)";
        $footer = "Seksi Penyelenggaran Pelatihan";
        $result = $this->notifService->sendWhatsApp($phone,$pesan,$footer);

        if (isset($result['status']) && $result['status'] === 'success') {
            return ['success' => true, 'message' => 'OTP berhasil dikirim'];
        }

        return ['success' => false, 'message' => $result['message'] ?? 'OTP gagal dikirim'];
    }
    
}
