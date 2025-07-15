<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenBlacklistModel extends Model
{
    protected $table = 'token_blacklist';
    protected $primaryKey = 'jti';
    protected $allowedFields = ['jti', 'expired_at'];
    public $timestamps = false;
}
