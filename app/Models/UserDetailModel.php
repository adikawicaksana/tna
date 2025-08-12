<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserDetailModel extends Model
{
    protected $table      = 'users_detail';
    protected $primaryKey = 'email';
    protected $allowedFields = [
        'email','nik','nip','front_title','fullname','back_title','mobile','address',
        'users_provinces','users_regencies','users_districts','users_villages',
        'jenjang_pendidikan','jurusan_profesi'
    ];
    protected $useTimestamps = true;

    public function getUserDetail($email = null)
    {
        $email = $email ?? session()->get('email');

        if (!$email) {
            return null;
        }

        return $this->select('users.*, users_detail.*, master_area_provinces.name as users_provinsi, master_area_regencies.name as users_kabkota, master_area_districts.name as users_kecamatan, master_area_villages.name as users_kelurahan')
            ->join('users', 'users.email = users_detail.email', 'left')
            ->join('master_area_provinces', 'master_area_provinces.id = users_detail.users_provinces', 'left')
            ->join('master_area_regencies', 'master_area_regencies.id = users_detail.users_regencies', 'left')
            ->join('master_area_districts', 'master_area_districts.id = users_detail.users_districts', 'left')
            ->join('master_area_villages', 'master_area_villages.id = users_detail.users_villages', 'left')
            ->where('users_detail.email', $email)
            ->first();
    }
}
