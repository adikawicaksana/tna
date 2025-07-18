<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services; 
use App\Models\TokenBlacklistModel;


class JwtAuthFilter implements FilterInterface
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
        $authHeader = $request->getHeaderLine('Authorization');
        if (!$authHeader || !str_contains($authHeader, 'Bearer ')) {
            return Services::response()->setJSON(['error' => 'Token tidak ditemukan'])->setStatusCode(401);
        }

        $token = explode(' ', $authHeader)[1];
        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
            
            // setelah decode
            $jti = $decoded->jti ?? null;
            if ($jti) {
                $blacklist = new TokenBlacklistModel();
                if ($blacklist->find($jti)) {
                    return Services::response()->setJSON(['error' => 'Token telah diblacklist'])->setStatusCode(401);
                }
            }
        } catch (\Exception $e) {
            return Services::response()->setJSON(['error' => 'Token tidak valid'])->setStatusCode(401);
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
