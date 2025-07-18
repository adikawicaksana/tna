<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\TokenBlacklistModel;

class JwtWebFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $token = $session->get('token');

        if (!$token) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login dulu.');
        }

        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));

            // Validasi IP & User-Agent
            if ($decoded->ip !== $request->getIPAddress() || $decoded->ua !== $_SERVER['HTTP_USER_AGENT']) {
                return redirect()->to(base_url('login'))->with('error', 'Token tidak sah (device mismatch)');
            }

            // Cek blacklist
            $jti = $decoded->jti ?? null;
            if ($jti) {
                $model = new TokenBlacklistModel();
                if ($model->find($jti)) {
                    return redirect()->to(base_url('login'))->with('error', 'Token sudah logout');
                }
            }

        } catch (\Exception $e) {
            // return redirect()->to(base_url('login'))->with('error', 'Token kadaluarsa atau tidak valid');
            $session = session();
            $session->remove('token');
            $session->remove('logged_in');
            return redirect()->to(base_url('login'))->with('error', 'Sesi kadaluarsa, silakan login ulang');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
