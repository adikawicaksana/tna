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
        if ($session->has('_id_users')) {
            $_id_users = $session->get('_id_users');

            $user = model('UserModel')->where('id', $_id_users)->first();
            $userDetail = null;

            if ($user) {
                $userDetail = model('UserDetailModel')
                    ->where('_id_users', $_id_users)
                    ->first();

                $userCompetence = model('UsersJobdescModel')
                    ->where('_id_users', $_id_users)
                    ->get()
                    ->getResultArray();
            }

            $requiredFields = [
                'nik',
                'nip',
                'fullname',
                'mobile',
                'address',
                '_id_provinces',
                '_id_regencies',
                '_id_districts',
                '_id_villages',
                'jenjang_pendidikan',
                'jurusan_profesi',
            ];

            if (!$userDetail) {
                if (current_url() !== site_url('/profile')) {
                    return redirect()->to(base_url('profile'))
                        ->with('warning_profile', 'Lengkapi profil Anda terlebih dahulu.');
                }
            } else {
                if (current_url() !== site_url('/profile')) {
                    if (empty($userCompetence)) {
                        return redirect()->to(base_url('profile'))
                            ->with('warning_profile', 'Lengkapi profil Anda terlebih dahulu.' . $userDetail['fullname']);
                    }

                    foreach ($requiredFields as $field) {
                        if (empty($userDetail[$field])) {
                            return redirect()->to(base_url('profile'))
                                ->with('warning_profile', 'Lengkapi profil Anda terlebih dahulu.' . $userDetail['fullname']);
                        }
                    }
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
