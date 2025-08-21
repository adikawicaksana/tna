<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserDetailModel extends Model
{
    protected $table      = 'users_detail';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false; 
    protected $allowedFields = [
        'id','_id_users','nik','nip','front_title','fullname','back_title','pangkatgolongan','jabatan','bidangkerja','mobile','address',
        '_id_provinces','_id_regencies','_id_districts','_id_villages',
        'jenjang_pendidikan','jurusan_profesi'
    ];
    protected $useTimestamps = true;

    public function getUserDetail($id = null)
    {
        $id = $id ?? session()->get('_id_users');

        if (!$id) {
            return null;
        }

        return $this->select('users.*, users_detail.*, master_area_provinces.name as users_provinsi, master_area_regencies.name as users_kabkota, master_area_districts.name as users_kecamatan, master_area_villages.name as users_kelurahan')
            ->join('users', 'users.id = users_detail._id_users', 'left')
            ->join('master_area_provinces', 'master_area_provinces.id = users_detail._id_provinces', 'left')
            ->join('master_area_regencies', 'master_area_regencies.id = users_detail._id_regencies', 'left')
            ->join('master_area_districts', 'master_area_districts.id = users_detail._id_districts', 'left')
            ->join('master_area_villages', 'master_area_villages.id = users_detail._id_villages', 'left')
            ->where('users.id', $id)
            ->first();
    }
}
