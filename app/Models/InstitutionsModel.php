<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class InstitutionsModel extends Model
{
    protected $table            = 'master_institutions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id', 'code', 'category', 'type', 'name', 'address','_id_villages', '_id_districts', '_id_regencies', '_id_provinces','latitude', 'longitude','model','parent'];
    protected $useTimestamps    = true;
    protected $returnType       = 'array';

  
    public function search(string $keyword, ?string $category = null, int $page = 1, int $limit = 8): array
    {
        try {
            $builder     = $this->builder();
            $safeKeyword = $this->db->escapeLikeString(strtolower($keyword));
            $offset      = ($page - 1) * $limit;
            $builder->select('
                    master_institutions.*,
                    master_area_districts.name AS district_name,
                    master_area_regencies.name AS regencies_name,
                    master_area_provinces.name AS provinces_name
                ');

            if ($category === 'fasyankes') {
                $builder->where('category', 'fasyankes')
                        ->like('master_institutions.code', $safeKeyword, 'both');
            } else {
                if ($category === 'fasyankesname' || !empty($category)) {
                    $builder->where('category', $category === 'fasyankesname' ? 'fasyankes' : strtolower($category));
                }

                $keywords = explode(' ', strtolower($safeKeyword));

                $builder->groupStart();
                foreach ($keywords as $word) {
                    $wordNoSpace = str_replace(' ', '', $word);

                    $builder->groupStart()
                        ->like('LOWER(master_institutions.name)', $word, 'both')
                        ->orLike('LOWER(master_institutions.type)', $wordNoSpace, 'both')
                        ->orLike('LOWER(master_institutions.address)', $word, 'both')
                        ->orLike('LOWER(master_area_districts.name)', $word, 'both')
                        ->orLike('LOWER(master_area_regencies.name)', $word, 'both')
                        ->orLike('LOWER(master_area_provinces.name)', $word, 'both')
                    ->groupEnd();
                }
                $builder->groupEnd();
            }


            $builder->join('master_area_districts','master_area_districts.id = master_institutions._id_districts','left' )
                    ->join('master_area_regencies','master_area_regencies.id = master_institutions._id_regencies','left' )
                    ->join('master_area_provinces','master_area_provinces.id = master_institutions._id_provinces','left' );

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

    public function detail($id)
    {
        try {
            return $this->select('
                    master_institutions.*,
                    master_area_districts.name AS district_name,
                    master_area_regencies.name AS regencies_name,
                    master_area_provinces.name AS provinces_name
                ')
                ->join('master_area_districts','master_area_districts.id = master_institutions._id_districts','left' )
                ->join('master_area_regencies','master_area_regencies.id = master_institutions._id_regencies','left' )
                ->join('master_area_provinces','master_area_provinces.id = master_institutions._id_provinces','left' )
                ->where('master_institutions.id', $id)
                ->first();  

        } catch (Exception $e) {
            log_message('error', '[InstitutionsModel::detail] ' . $e->getMessage());
            return null;
        }
    }

    public function detailByCode($code)
    {
        try {
            return $this->select('
                    master_institutions.*,
                    master_area_districts.name AS district_name,
                    master_area_regencies.name AS regencies_name,
                    master_area_provinces.name AS provinces_name
                ')
                ->join('master_area_districts','master_area_districts.id = master_institutions._id_districts','left' )
                ->join('master_area_regencies','master_area_regencies.id = master_institutions._id_regencies','left' )
                ->join('master_area_provinces','master_area_provinces.id = master_institutions._id_provinces','left' )
                ->where('master_institutions.code', $code)
                ->first();  

        } catch (Exception $e) {
            log_message('error', '[InstitutionsModel::detail] ' . $e->getMessage());
            return null;
        }
    }

    public function searchByParent($parent, $type=null)
    {
        try {
            $builder= $this->select('
                    master_institutions.*,
                    master_area_districts.name AS district_name,
                    master_area_regencies.name AS regencies_name,
                    master_area_provinces.name AS provinces_name
                ')
                ->join('master_area_districts','master_area_districts.id = master_institutions._id_districts','left' )
                ->join('master_area_regencies','master_area_regencies.id = master_institutions._id_regencies','left' )
                ->join('master_area_provinces','master_area_provinces.id = master_institutions._id_provinces','left' )
                ->where('master_institutions.parent', $parent);

                if($type) $builder->where('master_institutions.type',$type);
                
                 $result = $builder->findAll();

            return $result;

        } catch (Exception $e) {
            log_message('error', '[InstitutionsModel::detail] ' . $e->getMessage());
            return null;
        }
    }
}
