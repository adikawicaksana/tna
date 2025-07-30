<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\UserDetailModel;


class Register extends BaseController
{
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
        $mobile   = "62" . str_replace(' ', '', $request->getPost('user_mobilenumber'));
        $captcha  = strtoupper($request->getPost('captcha'));

        
        if (!$request->getPost('user_mobilenumber')) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Masukan Nomor Handphone',
                'data'    => []
            ]);
        }
        
        if (!$email) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Masukan Email',
                'data'    => []
            ]);
        }


        // --- Validasi Captcha ---
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

        if (!password_verify($captcha, $captchaData['hash'])) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Captcha salah',
                'data'    => []
            ]);
        }

        $session->remove('captcha');

        // --- Validasi Mobile ---
        $detailModel = new UserDetailModel();
        if ($detailModel->where('mobile', $mobile)->first()) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Nomor Handphone sudah terdaftar',
                'data'    => []
            ]);
        }

        // --- Validasi Email ---
        $userModel = new UserModel();
        if ($userModel->where('email', $email)->first()) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Email sudah terdaftar',
                'data'    => []
            ]);
        }

        // --- Simpan user ---
        $userId = $userModel->insert([
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'status'   => 'pending'
        ], true);

        $detailModel->insert([
            'user_id' => $userId,
            'email'   => $email,
            'mobile'  => $mobile
        ]);

        // --- Generate OTP ---
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $session->set('otp_data', [
            'hash'        => password_hash($otp, PASSWORD_DEFAULT),
            'expire'      => time() + 300,
            'generated_at'=> time(),
            'user_id'     => $userId,
            'email'       => $email
        ]);

        // --- Kirim OTP ke API ---
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
        if (isset($otpData['generated_at']) && (time() - $otpData['generated_at']) < 10) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Silakan tunggu 1 menit sebelum meminta OTP lagi'
            ]);
        }

        // Ambil data nomor HP dari users_detail
        $userDetailModel = new \App\Models\UserDetailModel();
        $detail = $userDetailModel->where('email', $otpData['email'])->first();

        if (!$detail || empty($detail['mobile'])) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Nomor HP tidak ditemukan'
            ]);
        }

        // Generate OTP baru
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
        $apiUrl = "https://api-whatsapp.adikawicaksana.my.id/api/send-message"; 
        $apiKey = "murnajati_garlat"; // Ganti dengan API key asli

        $payload = [
            // 'phone'   => $phone,            
            "apikey" => "murnajati_garlat",
            "receiver" => $phone,
            "mtype" => "text",
            "text" => "Kode OTP Anda adalah: $otp. Berlaku 5 menit."
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/x-www-form-urlencoded"
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['success' => false, 'message' => 'Gagal mengirim OTP: ' . $error];
        }

        $result = json_decode($response, true);

        if (isset($result['status']) && $result['status'] === 'success') {
            return ['success' => true, 'message' => 'OTP berhasil dikirim'];
        }

        return ['success' => false, 'message' => $result['message'] ?? 'OTP gagal dikirim'];
    }
    
}
