<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersJobdescModel extends Model
{
    protected $table      = 'users_jobdesc';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'email',
        'job_description',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;   
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
