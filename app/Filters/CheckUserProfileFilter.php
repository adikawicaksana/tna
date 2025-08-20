<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CheckUserProfileFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Pastikan email tersimpan di session
        if ($session->has('email')) {
            $email = $session->get('email');

            $user = model('UserModel')->where('email', $email)->first();
            $userDetail = null;

            if ($user) {
                $userDetail = model('UserDetailModel')
                    ->where('email', $email)
                    ->first();
            }

            $requiredFields = [
                'nik',
                'nip',
                // 'front_title',
                'fullname',
                // 'back_title',
                'mobile',
                'address',
                'users_provinces',
                'users_regencies',
                'users_districts',
                'users_villages',
            ];

            if (!$userDetail) {
                if (current_url() !== site_url('/profile')) {
                    return redirect()->to(base_url('profile'))
                        ->with('warning_profile', 'Lengkapi profil Anda terlebih dahulu.');
                }
            } else {
                foreach ($requiredFields as $field) {
                    if (empty($userDetail[$field])) {
                        if (current_url() !== site_url('/profile')) {
                            return redirect()->to(base_url('profile'))
                                ->with('warning_profile', 'Lengkapi profil Anda terlebih dahulu.');
                        }
                    }
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu dipakai
    }
}
