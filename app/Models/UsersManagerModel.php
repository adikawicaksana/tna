<?php
namespace App\Models;

use CodeIgniter\Model;

class UsersManagerModel extends Model
{
    protected $table      = 'users_manager';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id','_id_users','_id_institutions'];
    protected $useTimestamps = true;

}
