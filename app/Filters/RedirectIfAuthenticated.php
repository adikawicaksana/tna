<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class RedirectIfAuthenticated implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if ($session->get('logged_in') && $session->get('token')) {
            try {
                $decoded = JWT::decode(
                    $session->get('token'),
                    new Key(env('JWT_SECRET'), 'HS256')
                );

                // Kalau token valid, cek URL yang dibuka
                $path = service('uri')->getPath();
                if (in_array($path, ['', '/', 'home', 'login', 'register'])) {
                    return redirect()->to(base_url('dashboard'));
                }

            } catch (\Exception $e) {
                // Token invalid / expired
                $session->remove('token');
                $session->remove('logged_in');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // kosong
    }
}