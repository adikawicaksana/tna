<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\FasyankesModel;
use App\Models\NonFasyankesModel;
use App\Models\MasterTrainingModel;

class General extends ResourceController
{
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

     public function postFasyankesSearch()
        {
            $keyword = $this->request->getPost('keyword');
            $model = new FasyankesModel();
            $results = $model->search($keyword);

            $data = [];
            foreach ($results as $row) {
                $data[] = [
                    'fasyankes_code' => $row['fasyankes_code'],
                    'text' => $row['fasyankes_name']
                ];
            }


            if (empty($data)) {
                return $this->response->setJSON([
                    'status'    => false,
                    'code'      => 204,
                    'type'      => 'error',
                    'message'   => 'Data Fasyankes tidak ditemukan',
                    'data'      => []
                ]);
            }

            return $this->response->setJSON([
                    'status'    => true,
                    'code'      => 200,
                    'type'      => 'success',
                    'message'   => 'Data Fasyankes ditemukan',
                    'data'      => $data
                ]);
        }


    public function postNonFasyankesCheck(){
        $fasyankesId = $this->request->getPost('id');

        // Validasi jika kosong
        if (empty($fasyankesId)) {
            return $this->response->setJSON([
                'status'    => false,
                'code'      => 400,
                'type'      => 'warning',
                'message'   => 'ID Institusi tidak boleh kosong'
            ])->setStatusCode(200);
        }

        $model = new NonFasyankesModel();
        $data = $model->where('id', $fasyankesId)->first();

        if ($data) {
            return $this->response->setJSON([
                'status'    => true,
                'code'      => 200,
                'type'      => 'success',
                'message'   => 'Data Non Fasyankes ditemukan',
                'data'      => $data
            ]);
        } else {
            return $this->response->setJSON([
                'status'    => false,
                'type'      => 'warning',
                'code'      => 204, // Data tidak ditemukan (no content secara logika)
                'message'   => 'ID Non Fasyankes tidak ditemukan'
            ])->setStatusCode(200);
        }
    }


     public function postNonFasyankesSearch()
        {
            $keyword = $this->request->getPost('keyword');
            $models = new NonFasyankesModel();
            $results = $models->search($keyword);

            $data = [];
            foreach ($results as $row) {
                $data[] = [
                    'id' => $row['id'],
                    'text' => $row['nonfasyankes_name']
                ];
            }

            if (empty($data)) {
                return $this->response->setJSON([
                    'status'    => false,
                    'code'      => 204,
                    'type'      => 'error',
                    'message'   => 'Data Non Fasyankes tidak ditemukan',
                    'data'      => []
                ]);
            }


            return $this->response->setJSON([
                    'status'    => true,
                    'code'      => 200,
                    'type'      => 'success',
                    'message'   => 'Data Non Fasyankes ditemukan ',
                    'data'      => $data
                ]);
        }

   public function postPelatihanSiakpel()
{
    $term = $this->request->getGet('q');
    $model = new MasterTrainingModel();

    $query = $model->select('id, nama_pelatihan');

    if ($term) {
        $query->where("nama_pelatihan ILIKE '%" . $term . "%'");
    }

    $results = $query->findAll(20);

    $data = [];
    foreach ($results as $row) {
        $data[] = [
            'id'   => $row['id'],
            'text' => $row['nama_pelatihan']
        ];
    }

    return $this->response->setJSON($data);
}
}
