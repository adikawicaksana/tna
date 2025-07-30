<?php

namespace App\Models;

use CodeIgniter\Model;

class AreaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $returnType       = 'array';

    public function searchProvinces($keyword = null)
    {
        $builder = $this->db->table('master_area_provinces')
                            ->select('id as id, name as text')
                            ->orderBy('name', 'ASC');
        if ($keyword) {
             $builder->like('LOWER(name)', strtolower($keyword));
        }
        return $builder->get()->getResultArray();
        
    }

    public function searchRegencies($prov_id, $keyword = null)
    {
        $builder = $this->db->table('master_area_regencies')
                            ->select('id as id, name as text')
                            ->where('province_id', $prov_id)
                            ->orderBy('name', 'ASC');
        if ($keyword) {
             $builder->like('LOWER(name)', strtolower($keyword));
        }
        return $builder->get()->getResultArray();
    }

    public function searchDistricts($kab_id, $keyword = null)
    {
        $builder = $this->db->table('master_area_districts')
                            ->select('id as id, name as text')
                            ->where('regency_id', $kab_id)
                            ->orderBy('name', 'ASC');
        if ($keyword) {
             $builder->like('LOWER(name)', strtolower($keyword));
        }
        return $builder->get()->getResultArray();
    }

    public function searchVillages($kec_id, $keyword = null)
    {
        $builder = $this->db->table('master_area_villages')
                            ->select('id as id, name as text')
                            ->where('district_id', $kec_id)
                            ->orderBy('name', 'ASC');
        if ($keyword) {
             $builder->like('LOWER(name)', strtolower($keyword));
        }
        return $builder->get()->getResultArray();
    }
}