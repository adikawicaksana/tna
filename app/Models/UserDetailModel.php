<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserDetailModel extends Model
{
    protected $table      = 'users_detail';
    protected $primaryKey = 'email';
    protected $allowedFields = ['email','nik','nip','front_title','fullname','back_title','mobile','address','users_provinces','users_regencies','users_districs','users_villages'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}
