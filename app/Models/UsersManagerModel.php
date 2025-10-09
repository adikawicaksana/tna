<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UsersManagerModel extends Model
{
    protected $table      = 'users_manager';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id','_id_users','_id_institutions'];
    protected $useTimestamps = true;


    public function searchByIDusers($_id_users)
    {
        try {
            $user_manager = $this->select('users_manager.*, master_institutions.*')
                ->join('master_institutions', 'master_institutions.id = users_manager._id_institutions', 'left')
                ->where('users_manager._id_users', $_id_users)
                ->findAll();

            return $user_manager ?? null; // kembalikan null jika tidak ditemukan
        } catch (Exception $e) {
            log_message('error', '[UsersManagerModel::search] ' . $e->getMessage());
            return false; // atau bisa juga lempar kembali exception dengan: throw $e;
        }
    }

}
