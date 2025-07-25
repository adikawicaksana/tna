<?php

namespace App\Controllers;


class Register extends BaseController
{
    public function index()
    {
        echo view('register');
        exit();
    }

    
}
