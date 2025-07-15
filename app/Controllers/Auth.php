<?php

namespace App\Controllers;

use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function login()
    {

        // $userModel = new UserModel();
        // $userModel->save([
        //     'username' => 'admin',
        //     'password' => password_hash('admin123', PASSWORD_DEFAULT)
        // ]);


        $session = session();

        if ($session->get('logged_in') && $session->get('token')) {
            try {
                $decoded = JWT::decode($session->get('token'), new Key(getenv('JWT_SECRET'), 'HS256'));

                // Jika token masih valid, langsung redirect
                return redirect()->to(base_url('dashboard'));
            } catch (\Exception $e) {
                // Token tidak valid, hapus dan lanjut ke tampilan login
                $session->remove('token');
                $session->remove('logged_in');
            }
        }

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

        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $key = getenv('JWT_SECRET');
            $payload = [
                'sub' => $user['id'],
                'email' => $user['email'],
                'ip' => $this->request->getIPAddress(),
                'ua' => $_SERVER['HTTP_USER_AGENT'],
                'jti' => bin2hex(random_bytes(8)),
                'iat' => time(),
                'exp' => time() + 10 //15 menit
            ];

            $token = JWT::encode($payload, $key, 'HS256');

            // Tambahkan refresh token
            $refreshPayload = [
                'sub' => $user['id'],
                'type' => 'refresh',
                'jti' => bin2hex(random_bytes(8)),
                'exp' => time() + (86400 * 7) // 7 hari
            ];

            $refreshToken = JWT::encode($refreshPayload, $key, 'HS256');

            // Simpan ke database
            $model->update($user['id'], [
                'refresh_token' => $refreshToken,
                'refresh_token_expire' => date('Y-m-d H:i:s', $refreshPayload['exp'])
            ]);

            // Simpan ke session (opsional jika ingin pakai di web)
            $session->set([
                'token' => $token,
                'refresh_token' => $refreshToken,
                'email' => $user['email'],
                'user_id' => $user['id'],
                'logged_in' => true
            ]);

            $response = service('response');
            // Set cookie HttpOnly & Secure
            return $response
                ->setCookie([
                    'name'     => 'refresh_token',
                    'value'    => $refreshToken,
                    'expire'   => 60 * 60 * 24 * 7, // 7 hari
                    'httponly' => true,
                    'secure'   => false, // Ubah ke true jika pakai HTTPS
                    'samesite' => 'Strict',
                ])
                ->redirect(base_url('dashboard'));
        }

        return redirect()->to(base_url('login'))->with('error', '<strong>Oopss!</strong> e-mail atau password salah!');
    }

    public function refreshWebToken()
    {
        $cookie = $this->request->getCookie('refresh_token');
        $key = getenv('JWT_SECRET');

        if (!$cookie) {
            return $this->response->setJSON(['error' => 'No refresh token'])->setStatusCode(401);
        }

        try {
            $decoded = JWT::decode($cookie, new Key($key, 'HS256'));
            if ($decoded->type !== 'refresh') {
                throw new \Exception('Invalid refresh token');
            }

            // Buat access token baru
            $accessPayload = [
                'sub' => $decoded->sub,
                'jti' => bin2hex(random_bytes(8)),
                'ip' => $this->request->getIPAddress(),
                'ua' => $_SERVER['HTTP_USER_AGENT'],
                'iat' => time(),
                'exp' => time() + 900 // 15 menit
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
                $decoded = JWT::decode($token, new \Firebase\JWT\Key(getenv('JWT_SECRET'), 'HS256'));

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

    public function register()
    {
        helper(['form']);
        echo view('auth/register');
    }

    public function registerPost()
    {
        helper(['form']);
        $rules = [
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $model->save([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->to(base_url('login'))->with('success', 'Registrasi berhasil, silakan login.');
    }
}
