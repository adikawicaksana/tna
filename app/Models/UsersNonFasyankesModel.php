<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersNonFasyankesModel extends Model
{
    protected $table      = 'users_nonfasyankes';
    protected $primaryKey = 'id'; 
    protected $useAutoIncrement = false; 
    protected $allowedFields = ['id','_id_users','_id_master_nonfasyankes','status']; 
    protected $useTimestamps = true;

}



