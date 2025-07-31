<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\UserDetailModel;
use App\Services\NotificationService;

class Register extends BaseController
{
    protected $notifService;
    
     public function __construct()
    {
        $this->notifService = new NotificationService();
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

        $email    = strtolower(trim($request->getPost('user_email')));
        $password = $request->getPost('user_password');
        $mobile   = "62" . preg_replace('/\D/', '', $request->getPost('user_mobilenumber'));
        $captcha  = strtoupper(trim($request->getPost('captcha')));

        $rules = [
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

        $userModel   = new UserModel();
        $detailModel = new UserDetailModel();

        $builder = $userModel->builder();
        $builder->select('users.email, users.status, users_detail.mobile');
        $builder->join('users_detail', 'users_detail.email = users.email', 'left');
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

        $userModel->insert([
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'status'   => 'pending'
        ]);

        $detailModel->insert([ 
            'email'   => $email,
            'mobile'  => $mobile
        ]);

        return $this->generateOtpAndResponse($session, $mobile, $email);

    }

    private function handlePendingUser($user, $session, $mobile)
    {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $session->set('otp_data', [
            'hash'        => password_hash($otp, PASSWORD_DEFAULT),
            'expire'      => time() + 300,
            'generated_at'=> time(),
            'user_id'     => $user['email'], 
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

    private function generateOtpAndResponse($session, $mobile, $email)
    {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $session->set('otp_data', [
            'hash'        => password_hash($otp, PASSWORD_DEFAULT),
            'expire'      => time() + 300,
            'generated_at'=> time(),
            'user_id'     => $email, 
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
        $userModel->update($otpData['email'], ['status' => 'active']);
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

        if (!$otpData || empty($otpData['email'])) {
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
        $detail = $userDetailModel->where('email', $otpData['email'])->first();

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
        
        $result = $this->notifService->sendWhatsApp(
            $phone,
            "Kode OTP Anda: $otp (berlaku 5 menit)");

        if (isset($result['status']) && $result['status'] === 'success') {
            return ['success' => true, 'message' => 'OTP berhasil dikirim'];
        }

        return ['success' => false, 'message' => $result['message'] ?? 'OTP gagal dikirim'];
    }
    
}
