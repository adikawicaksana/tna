<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersNonFasyankesModel extends Model
{
    protected $table      = 'users_nonfasyankes';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['id','email','nonfasyankes_id','status']; 
    protected $useTimestamps = true;

}



