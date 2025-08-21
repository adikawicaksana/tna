<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersJobdescModel extends Model
{
    protected $table      = 'users_jobdesc';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false; 
    protected $allowedFields = [
        'id',
        '_id_users',
        'job_description', 
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;   
}

