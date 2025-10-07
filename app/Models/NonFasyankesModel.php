<?php

namespace App\Models;

use CodeIgniter\Model;

class NonFasyankesModel extends Model
{
    protected $table      = 'master_nonfasyankes';
    protected $primaryKey = 'id'; 
    protected $useAutoIncrement = false; 
    protected $allowedFields = ['id','nonfasyankes_name','nonfasyankes_address','nonfasyankes_villages','nonfasyankes_districts','nonfasyankes_regencies','nonfasyankes_provinces']; 

    // Tidak perlu timestamps kalau tidak ada
    // public $useTimestamps = false;

    public function search($keyword)
    {
        return $this->db->table($this->table)
        ->where('LOWER(nonfasyankes_name) LIKE', '%' . strtolower($keyword) . '%')
        ->limit(10)
        ->get()
        ->getResultArray();        
    }
}



