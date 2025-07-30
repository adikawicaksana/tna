<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AreaModel;
use CodeIgniter\API\ResponseTrait;


class Area extends ResourceController
{
    use ResponseTrait;
    protected $areaModel;

    public function __construct()
    {
        $this->areaModel = new AreaModel();
    }

    public function index()
    {
        //  $data = [
        //     'title' => 'Register'
        // ];

        // return view('register', $data);
    }

    public function provinsi()
    {
        $search = $this->request->getVar('search');
        $data = $this->areaModel->searchProvinces($search);
        return $this->respond($data);
    }

    public function kabupaten()
    {
        $search   = $this->request->getVar('search');
        $prov_id  = $this->request->getVar('prov_id');
        $data = $this->areaModel->searchRegencies($prov_id, $search);
        return $this->respond($data);
    }

    public function kecamatan()
    {
        $search   = $this->request->getVar('search');
        $kab_id   = $this->request->getVar('kab_id');
        $data = $this->areaModel->searchDistricts($kab_id, $search);
        return $this->respond($data);
    }

    public function kelurahan()
    {
        $search   = $this->request->getVar('search');
        $kec_id   = $this->request->getVar('kec_id');
        $data = $this->areaModel->searchVillages($kec_id, $search);
        return $this->respond($data);
    }

    
}
