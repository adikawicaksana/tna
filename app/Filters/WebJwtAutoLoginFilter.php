<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class WebJwtAutoLoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->get('logged_in')) {
            $cookie = $request->getCookie('refresh_token');
            if ($cookie) {
                try {
                    $decoded = JWT::decode($cookie, new Key(getenv('JWT_SECRET'), 'HS256'));

                    if ($decoded->type !== 'refresh') {
                        throw new \Exception('Invalid token type');
                    }

                    // Buat token baru & login user
                    $payload = [
                        'sub' => $decoded->sub,
                        'jti' => bin2hex(random_bytes(8)),
                        'iat' => time(),
                        'exp' => time() + 900, // 15 menit
                    ];

                    $newToken = JWT::encode($payload, getenv('JWT_SECRET'), 'HS256');

                    $session->set([
                        'token' => $newToken,
                        'user_id' => $decoded->sub,
                        'logged_in' => true
                    ]);
                } catch (\Exception $e) {
                    // Token invalid atau expired → biarkan login biasa
                }
            }
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
