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

    public static function getCompetence($user_id = '')
    {
        return (new UsersCompetenceModel())
            ->select('users_competence.id, users_jobdesc._id_users')
            ->join('users_jobdesc', 'users_jobdesc.id = users_competence._id_users_jobdesc')
            ->where('_id_users', $user_id)
            ->orderBy('users_competence.id', 'ASC')
            ->findAll();
    }
}
