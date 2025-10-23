<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Models\TokenBlacklistModel;

class JwtWebFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $token   = $session->get('token');
        $key     =  env('JWT_SECRET');

        if (!$token) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login dulu.');
        }

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // if ($decoded->ip !== $request->getIPAddress() || $decoded->ua !== $_SERVER['HTTP_USER_AGENT']) {
            //     return redirect()->to(base_url('login'))->with('error', 'Token tidak sah (device mismatch)');
            // }

            if ($decoded->ua !== $_SERVER['HTTP_USER_AGENT']) {
                return redirect()->to(base_url('login'))->with('error', 'Token tidak sah (device mismatch)');
            }

            $jti = $decoded->jti ?? null;
            if ($jti) {
                $model = new TokenBlacklistModel();
                if ($model->find($jti)) {
                    return redirect()->to(base_url('login'))->with('error', 'Token sudah logout');
                }
            }

        } catch (ExpiredException $e) {
            $refreshToken = $request->getCookie('refresh_token');
            if ($refreshToken) {
                try {
                    $decodedRefresh = JWT::decode($refreshToken, new Key($key, 'HS256'));
                    if ($decodedRefresh->type === 'refresh'
                        && $decodedRefresh->exp > time()
                        // && $decodedRefresh->ip === $request->getIPAddress()
                        && $decodedRefresh->ua === $_SERVER['HTTP_USER_AGENT']) {

                        $newPayload = [
                            'sub' => $decodedRefresh->sub,
                            // 'ip'  => $request->getIPAddress(),
                            'ua'  => $_SERVER['HTTP_USER_AGENT'],
                            'jti' => bin2hex(random_bytes(8)),
                            'iat' => time(),
                            'exp' => time() + (60 * 15)
                        ];
                        $newToken = JWT::encode($newPayload, $key, 'HS256');

                        $session->set('token', $newToken);
                        return; // lanjut request
                    }
                } catch (\Exception $ex) {
                    // refresh gagal
                }
            }

            $session->destroy();
            return redirect()->to(base_url('login'))->with('error', 'Sesi berakhir, silakan login ulang.');
        } catch (\Exception $e) {
            $session->destroy();
            return redirect()->to(base_url('login'))->with('error', 'Token tidak valid.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak dipakai
    }
}