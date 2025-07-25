<?php

namespace App\Models;

use CodeIgniter\Model;

class InstitutionModel extends Model
{
    protected $table      = 'master_institution';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['id','institution_name','institution_address','institution_villages','institution_districts','institution_regencies','institution_provinces']; // Sesuaikan field-nya

    // Tidak perlu timestamps kalau tidak ada
    // public $useTimestamps = false;

    public function search($keyword)
        {
             return $this->db->table($this->table)
                ->where('LOWER(institution_name) LIKE', '%' . strtolower($keyword) . '%')
                ->limit(10)
                ->get()
                ->getResultArray();        
        }
}



