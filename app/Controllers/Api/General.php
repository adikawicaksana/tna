<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\InstitutionsModel;
use App\Models\MasterTrainingModel;

class General extends ResourceController
{
     
    protected $institutions;

    public function __construct()
    {
        $this->institutions = new InstitutionsModel();
    }

    private function isValidUuid(string $uuid): bool
    {
        return (bool) preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $uuid
        );
    }

    public function getInstitution()
    {
        $category = $this->request->getGet('c') ?? 'fasyankes';
        $keyword  = $this->request->getGet('k');
        $page  = $this->request->getGet('p') ?? 1;

        if (empty($keyword)) {
            return $this->response->setJSON([
                'status'  => false,
                'code'    => 400,
                'type'    => 'warning',
                'message' => 'Parameter keyword wajib diisi.'
            ])->setStatusCode(400);
        }

        $result = ['total' => 0, 'page' => 0, 'last_page'=> 0, 'per_page' => 0,'data'  => []];

        if ($this->isValidUuid($keyword)) {
            $row = $this->institutions->where('id', $keyword)->first();
            if ($row) {
                $result['total'] = 1; $result['page'] = 1; $result['last_page'] = 1; $result['per_page'] = 1; $result['data']  = [$row];
            }
        } elseif (ctype_digit($keyword)) {
            $row = $this->institutions->where('code', $keyword)->first();
            if ($row) {
                $result['total'] = 1; $result['data']  = [$row];
            } else {
                $result = $this->institutions->search($keyword, $category, $page);
            }
        } else {
            $result = $this->institutions->search($keyword, $category, $page);
        }

        if ($result['total'] > 0) {
            return $this->response->setJSON([
                'status'  => true,
                'code'    => 200,
                'type'    => 'success',
                'message' => 'Data ditemukan',
                'total'   => $result['total'],
                'page'     => $result['page'],
                'last_page'=> $result['last_page'],
                'per_page' => $result['per_page'],
                'data'    => $result['data']
            ]);
        }

        return $this->response->setJSON([
            'status'  => false,
            'code'    => 204,
            'type'    => 'warning',
            'message' => 'Data ' . $category . ' tidak ditemukan'
        ])->setStatusCode(200);

    }

    public function getPelatihanSiakpel()
    {
        $term = $this->request->getGet('q');
        $maxData = $this->request->getGet('maxData');
        $model = new MasterTrainingModel();

        $query = $model->select('id, nama_pelatihan');

        if ($term) {
            $query->where("nama_pelatihan ILIKE '%" . $term . "%'");
        }

        $results = $query->findAll($maxData);

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
