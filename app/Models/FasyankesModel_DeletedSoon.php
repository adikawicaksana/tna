<?php

namespace App\Models;

use CodeIgniter\Model;

class FasyankesModel extends Model
{
    protected $table      = 'master_fasyankes';
    protected $primaryKey = 'id'; 
    protected $useAutoIncrement = false; 
    protected $allowedFields = ['id','fasyankes_code','fasyankes_type','fasyankes_name','fasyankes_address','fasyankes_villages','fasyankes_districts','fasyankes_regencies','fasyankes_provinces']; 

  

    public function search($keyword)
        {
            return $this->like('fasyankes_code', $keyword)->findAll(8); // limit 10 hasil
        }
}
