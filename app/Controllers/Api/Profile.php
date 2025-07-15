<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Profile extends ResourceController
{
    public function index()
    {
        return $this->respond([
            'message' => 'API Accessed Successfully',
            'user' => 'from JWT'
        ]);
    }
}
