<?php

namespace App\Controllers;

use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
     use ResponseTrait;
    public function login()
    {

        return view('auth/login');
    }

    public function loginPost()
    {
        $session = session();
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model    = new UserModel();
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user     = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $key = env('JWT_SECRET');
            $ip  = $this->request->getIPAddress();
            $ua  = $_SERVER['HTTP_USER_AGENT'];

            // Access Token
            $payload = [
                'sub'       => $user['id'],
                '_id_users' => $user['id'],
                'ip'        => $ip,
                'ua'        => $ua,
                'jti'       => bin2hex(random_bytes(8)),
                'iat'       => time(),
                'exp'       => time() + (60 * 15) // 15 menit
            ];
            $token = JWT::encode($payload, $key, 'HS256');

            // Refresh Token
            $refreshPayload = [
                'sub' => $user['id'],
                'type' => 'refresh',
                'ip'  => $ip,
                'ua'  => $ua,
                'jti' => bin2hex(random_bytes(8)),
                'iat' => time(),
                'exp' => time() + (60 * 60 * 24 * 7) // 7 hari
            ];
            $refreshToken = JWT::encode($refreshPayload, $key, 'HS256');

            // Simpan ke database
            $model->update($user['id'], [
                'refresh_token'        => $refreshToken,
                'refresh_token_expire' => date('Y-m-d H:i:s', $refreshPayload['exp'])
            ]);

            // Simpan ke session
            $session->set([
                'token'         => $token,
                'refresh_token' => $refreshToken,
                '_id_users'     => $user['id'],
                'logged_in'     => true
            ]);

            $response = service('response');
            return $response
                ->setCookie([
                    'name'     => 'refresh_token',
                    'value'    => $refreshToken,
                    'expire'   => 60 * 60 * 24 * 7,
                    'httponly' => true,
                    'secure'   => false, // true jika HTTPS
                    'samesite' => 'Strict',
                ])
                ->redirect(base_url('dashboard'));
        }

        return redirect()->to(base_url('login'))
                         ->with('error', '<strong>Oopss!</strong> e-mail atau password salah!');
    }

    public function refreshWebToken()
    {
        $cookie = $this->request->getCookie('refresh_token');
        $key    = env('JWT_SECRET');

        if (!$cookie) {
            return $this->response->setJSON(['error' => 'No refresh token'])->setStatusCode(401);
        }

        try {
            $decoded = JWT::decode($cookie, new Key($key, 'HS256'));
            if ($decoded->type !== 'refresh') {
                throw new \Exception('Invalid refresh token');
            }

            // Validasi IP & UA
            if ($decoded->ip !== $this->request->getIPAddress() || $decoded->ua !== $_SERVER['HTTP_USER_AGENT']) {
                throw new \Exception('Device mismatch');
            }

            // Buat access token baru
            $accessPayload = [
                'sub' => $decoded->sub,
                'ip'  => $this->request->getIPAddress(),
                'ua'  => $_SERVER['HTTP_USER_AGENT'],
                'jti' => bin2hex(random_bytes(8)),
                'iat' => time(),
                'exp' => time() + (60 * 15) // 15 menit
            ];

            $newToken = JWT::encode($accessPayload, $key, 'HS256');
            session()->set('token', $newToken);

            return $this->response->setJSON(['access_token' => $newToken]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Refresh gagal'])->setStatusCode(401);
        }
    }

    public function logout()
    {
        $session = session();
        $token = $session->get('token');

        if ($token) {
            try {
                $decoded = JWT::decode($token, new \Firebase\JWT\Key(env('JWT_SECRET'), 'HS256'));

                $jti = $decoded->jti ?? null;
                if ($jti) {
                    $model = new \App\Models\TokenBlacklistModel();
                    $model->insert([
                        'jti' => $jti,
                        'expired_at' => date('Y-m-d H:i:s', $decoded->exp)
                    ]);
                }
            } catch (\Exception $e) {
                // Token rusak atau kadaluarsa, abaikan
            }
        }

        // Hapus refresh_token dari cookie
            $response = service('response');
            $response->deleteCookie('refresh_token');
            
        $session->destroy();
        return redirect()->to(base_url())->with('success', 'Berhasil logout');
    }

}
