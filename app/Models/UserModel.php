<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false; 
    protected $allowedFields = ['id','email', 'password', 'refresh_token', 'refresh_token_expire','status'];
    protected $useTimestamps = true;
}
