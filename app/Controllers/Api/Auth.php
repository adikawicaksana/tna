<?php
namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
    use ResponseTrait;
    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $key = getenv('JWT_SECRET');
            
            $accessPayload = [
                'sub' => $user['id'],
                'username' => $user['username'],
                'ip' => $this->request->getIPAddress(),
                'ua' => $_SERVER['HTTP_USER_AGENT'],
                'jti' => bin2hex(random_bytes(8)),
                'iat' => time(),
                'exp' => time() + 60 // 15 menit
            ];

            $refreshPayload = [
                'sub' => $user['id'],
                'type' => 'refresh',
                'jti' => bin2hex(random_bytes(8)),
                'exp' => time() + (86400 * 2) // 2 hari
            ];

            $accessToken = JWT::encode($accessPayload, $key, 'HS256');
            $refreshToken = JWT::encode($refreshPayload, $key, 'HS256');

            // Simpan refresh token ke DB (opsional)
            $model->update($user['id'], [
                'refresh_token' => $refreshToken,
                'refresh_token_expire' => date('Y-m-d H:i:s', $refreshPayload['exp'])
            ]);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Login berhasil',
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken
            ]);
        }

        return $this->response->setJSON([
            'status' => false,
            'message' => 'Username atau password salah'
        ])->setStatusCode(401);
    }

    public function logout()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        if (!$authHeader || !str_contains($authHeader, 'Bearer ')) {
            return $this->fail('Token tidak ditemukan', 401);
        }

        $token = explode(' ', $authHeader)[1];
        try {
            $decoded = JWT::decode($token, new \Firebase\JWT\Key(getenv('JWT_SECRET'), 'HS256'));
            $jti = $decoded->jti ?? null;
            if ($jti) {
                $db = \Config\Database::connect();
                $db->table('token_blacklist')->insert([
                    'jti' => $jti,
                    'expired_at' => date('Y-m-d H:i:s', $decoded->exp)
                ]);
            }

            return $this->respond(['message' => 'Logout sukses, token tidak bisa digunakan lagi']);
        } catch (\Exception $e) {
            return $this->fail('Token tidak valid', 401);
        }
    }


    public function refreshToken()
    {
        $token = $this->request->getPost('refresh_token');
        if (!$token) {
            return $this->fail('Refresh token required', 401);
        }

        try {
            $decoded = JWT::decode($token, new \Firebase\JWT\Key(getenv('JWT_SECRET'), 'HS256'));
            if ($decoded->type !== 'refresh') {
                return $this->fail('Invalid token type', 403);
            }

            $user = (new UserModel())->find($decoded->sub);
            if (!$user || $user['refresh_token'] !== $token) {
                return $this->fail('Invalid refresh token', 401);
            }

            // Buat token baru
            $accessPayload = [
                'sub' => $user['id'],
                'username' => $user['username'],
                'ip' => $this->request->getIPAddress(),
                'ua' => $_SERVER['HTTP_USER_AGENT'],
                'jti' => bin2hex(random_bytes(8)),
                'iat' => time(),
                'exp' => time() + 900
            ];

            $accessToken = JWT::encode($accessPayload, getenv('JWT_SECRET'), 'HS256');

            return $this->respond([
                'access_token' => $accessToken
            ]);
        } catch (\Exception $e) {
            return $this->fail('Token tidak valid atau kadaluarsa', 401);
        }
    }

}
