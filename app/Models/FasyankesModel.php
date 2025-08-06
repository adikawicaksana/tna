<?php

namespace App\Models;

use CodeIgniter\Model;

class FasyankesModel extends Model
{
    protected $table      = 'master_fasyankes';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['fasyankes_code','fasyankes_type','fasyankes_name','fasyankes_address','fasyankes_kec','fasyankes_kab','fasyankes_prov']; 

    // Tidak perlu timestamps kalau tidak ada
    // public $useTimestamps = false;

    public function search($keyword)
        {
            return $this->like('fasyankes_code', $keyword)->findAll(8); // limit 10 hasil
        }
}
