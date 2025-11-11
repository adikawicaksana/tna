<?php

namespace App\Controllers;

use App\Models\UserDetailModel;

class Support extends BaseController
{
    protected $userDetailModel;
    public function __construct()
    {
        $this->userDetailModel = (new UserDetailModel())->getUserDetail();
    }

    public function index()
    {
        return view('support', [
            'title' => 'Dokumentasi & Bantuan',
            'userDetail' => $this->userDetailModel,
        ]);
    }
}