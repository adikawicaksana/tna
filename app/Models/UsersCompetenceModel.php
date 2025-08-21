<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersCompetenceModel extends Model
{
    protected $table      = 'users_competence';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false; 

    protected $allowedFields = [
        'id',
        '_id_users_jobdesc',
        '_id_master_training',
        'status'
        
    ];

    protected $useTimestamps = true;  
}
