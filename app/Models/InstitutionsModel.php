<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class InstitutionsModel extends Model
{
    protected $table            = 'master_institutions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id', 'code', 'category', 'type', 'name', 'address','_id_villages', '_id_districts', '_id_regencies', '_id_provinces','latitude', 'longitude'];
    protected $useTimestamps    = true;
    protected $returnType       = 'array';

  
    public function search(string $keyword, ?string $category = null, int $page = 1, int $limit = 8): array
    {
        try {
            $builder     = $this->builder();
            $safeKeyword = $this->db->escapeLikeString(strtolower($keyword));
            $offset      = ($page - 1) * $limit;

            if ($category === 'fasyankes') {
                $builder->where('category', 'fasyankes')->like('code', $safeKeyword, 'both');
            } elseif (!empty($category)) {
                $builder->where('category', strtolower($category))->like('LOWER(name)', $safeKeyword, 'both');
            } else {
                $builder->like('LOWER(name)', $safeKeyword, 'both', false);
            }

            $countBuilder = clone $builder;
            $total        = $countBuilder->countAllResults(false);

            $data = $builder->limit($limit, $offset)->get()->getResultArray();
            return [
                'total'     => $total,
                'page'      => $page,
                'per_page'  => $limit,
                'last_page' => (int) ceil($total / $limit),
                'data'      => $data,
            ];
        } catch (Exception $e) {
            log_message('error', '[InstitutionsModel::search] ' . $e->getMessage());
            return [
                'total'     => 0,
                'page'      => $page,
                'per_page'  => $limit,
                'last_page' => 0,
                'data'      => [],
            ];
        }
    }
}
