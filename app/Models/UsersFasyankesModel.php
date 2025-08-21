<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersFasyankesModel extends Model
{
    protected $table      = 'users_fasyankes';
    protected $primaryKey = 'id'; 
    protected $useAutoIncrement = false; 
    protected $allowedFields = ['id','_id_users','_id_master_fasyankes','status']; 
    protected $useTimestamps = true;
}



