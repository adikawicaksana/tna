<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Otp extends BaseController
{
    // Kirim OTP ke API eksternal
    public function sendOtp()
    {
        $session = session();
        $phone   = $this->request->getPost('phone');

        if (!$phone) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'message' => 'Nomor telepon wajib diisi'
            ]);
        }

        // Rate limiting: cek jika baru saja request OTP
        $lastOtp = $session->get('otp_data');
        if ($lastOtp && (time() - $lastOtp['generated_at']) < 60) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 429,
                'message' => 'Tunggu 1 menit sebelum meminta OTP lagi'
            ]);
        }

        // Generate OTP 6 digit
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan ke session (dengan hash)
        $session->set('otp_data', [
            'hash'        => password_hash($otp, PASSWORD_DEFAULT),
            'expire'      => time() + 300, // berlaku 5 menit
            'generated_at'=> time(),
            'phone'       => $phone
        ]);

        // Kirim ke API pihak ketiga
        $apiUrl = "https://api-otp-provider.com/send";
        $payload = [
            'phone'   => $phone,
            'message' => "Kode OTP Anda adalah: $otp. Berlaku 5 menit."
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        return $this->response->setJSON([
            'status'  => true,
            'code'    => 200,
            'message' => 'OTP berhasil dikirim',
            'api_response' => $response
        ]);
    }

    // Verifikasi OTP
    public function verifyOtp()
    {
        $session  = session();
        $inputOtp = $this->request->getPost('otp');
        $otpData  = $session->get('otp_data');

        if (!$otpData) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'message' => 'OTP tidak ditemukan atau sudah kedaluwarsa'
            ]);
        }

        // Cek expire
        if (time() > $otpData['expire']) {
            $session->remove('otp_data');
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'message' => 'OTP sudah kedaluwarsa'
            ]);
        }

        // Cek OTP dengan hash
        if (!password_verify($inputOtp, $otpData['hash'])) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'message' => 'OTP salah'
            ]);
        }

        // Hapus setelah valid
        $session->remove('otp_data');

        return $this->response->setJSON([
            'status'  => true,
            'code'    => 200,
            'message' => 'OTP valid'
        ]);
    }
}
