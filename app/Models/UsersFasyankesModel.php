<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersFasyankesModel extends Model
{
    protected $table      = 'users_fasyankes';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['id','email','fasyankes_code','status']; 
    protected $useTimestamps = true;

    // Tidak perlu timestamps kalau tidak ada
    // public $useTimestamps = false;
    
}



