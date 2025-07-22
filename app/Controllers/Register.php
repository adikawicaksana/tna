<?php

namespace App\Controllers;
use App\Models\FasyankesModel;

class Register extends BaseController
{
    public function index()
    {
        echo view('register');
        exit();
    }

    public function postFasyankesCheck(){
        $fasyankesCode = $this->request->getPost('fasyankes_code');

        // Validasi jika kosong
        if (empty($fasyankesCode)) {
            return $this->response->setJSON([
                'status'    => false,
                'code'      => 400,
                'type'      => 'warning',
                'message'   => 'Kode Fasyankes tidak boleh kosong'
            ])->setStatusCode(200);
        }

        // Validasi format (hanya huruf dan angka)
        if (!ctype_digit($fasyankesCode)) {
            return $this->response->setJSON([
                'status'    => false,
                'code'      => 400,
                'type'      => 'warning',
                'message'   => 'Format kode Fasyankes tidak valid, hanya angka yang diperbolehkan.'
            ])->setStatusCode(200);
        }

        $model = new FasyankesModel();
        $data = $model->where('fasyankes_code', $fasyankesCode)->first();

        if ($data) {
            return $this->response->setJSON([
                'status'    => true,
                'code'      => 200,                
                'type'      => 'success',
                'message'   => 'Data Fasyankes ditemukan',
                'data'      => $data
            ]);
        } else {
            return $this->response->setJSON([
                'status'    => false,
                'type'      => 'warning',
                'code'      => 204, // Data tidak ditemukan (no content secara logika)
                'message'   => 'Kode Fasyankes tidak ditemukan'
            ])->setStatusCode(200);
        }
    }
}
