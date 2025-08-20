<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersCompetenceModel extends Model
{
    protected $table      = 'users_competence';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_users_jobdesc',
        'id_training',
        'status'
    ];

    protected $useTimestamps = true;  
}
