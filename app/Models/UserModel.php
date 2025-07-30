<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'email';
    protected $allowedFields = ['email', 'password', 'refresh_token', 'refresh_token_expire','status'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}
