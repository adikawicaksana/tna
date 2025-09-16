<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersInstitutionsModel extends Model
{
    protected $table      = 'users_institutions';
    protected $primaryKey = 'id'; 
    protected $useAutoIncrement = false; 
    protected $allowedFields = ['id','_id_users','_id_master_institutions','status']; 
    protected $useTimestamps = true;

    public function getInstitutionsByUser(string $userId, string $category = 'fasyankes'): array
    {
        try {
            return $this->select('users_institutions.*, master_institutions.*, users_institutions.id as id_usersinstitutions')
                ->join('master_institutions', 'users_institutions."_id_master_institutions" = master_institutions."id"')
                ->where('users_institutions."_id_users"', $userId)
                ->where('master_institutions.category', $category)
                ->findAll();
        } catch (\Exception $e) {
            log_message('error', '[UserInstitutionModel] Error: ' . $e->getMessage());
            return []; 
        }
    }

    public function countByInstitution($institutionId): int
    {
        return $this->where('_id_master_institutions', $institutionId)
                    ->countAllResults();
    }
}



