<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UsersManagerModel extends Model
{
    protected $table      = 'users_manager';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id','_id_users','_id_institutions'];
    protected $useTimestamps = true;

    /**
     * Function SearchByIDusers.
     *
     * @param string $_id_users ID user, $filterType = 'all'
     * Semua institusi (tanpa filter)
     * $m_institutions = (new UsersManagerModel())->searchByIDusers($session->get('_id_users'));
     * 
     * 
     * @param string $_id_users, $filterType
     * Hanya kabkota
     * $m_institutions = (new UsersManagerModel())->searchByIDusers($session->get('_id_users'), 'kabkota');
     * 
     * Hanya provinsi
     * $m_institutions = (new UsersManagerModel())->searchByIDusers($session->get('_id_users'), 'provinsi');
     * 
     * Semua selain kabkota & provinsi (institusi)
     * $m_institutions = (new UsersManagerModel())->searchByIDusers($session->get('_id_users'), 'institusi');
     * 
     * Gabungan kabkota + provinsi
     * $m_institutions = (new UsersManagerModel())->searchByIDusers($session->get('_id_users'), ['kabkota', 'provinsi']);
     * 
     */   


    public function searchByIDusers($_id_users, $filterType = 'all')
    {
        try {
            $builder = $this->select('users_manager.*, master_institutions.*')
                ->join(
                    'master_institutions',
                    'master_institutions.id = users_manager._id_institutions',
                    'left'
                )
                ->where('users_manager._id_users', $_id_users);

            if ($filterType !== 'all') {
                if (is_array($filterType)) {
                    $builder->whereIn('master_institutions.type', $filterType);
                } elseif (is_string($filterType)) {
                    switch (strtolower($filterType)) {
                        case 'kabkota':
                        case 'provinsi':
                            $builder->where('master_institutions.type', $filterType);
                            break;
                        case 'institusi':
                            $builder->whereNotIn('master_institutions.type', ['kabkota', 'provinsi']);
                            break;
                        default:
                            break;
                    }
                }
            }

            $result = $builder->findAll();

            if (!is_array($result) || empty($result)) {
                return [];
            }

            return $result;
        } catch (\Exception $e) {
            log_message('error', '[UsersManagerModel::searchByIDusers] ' . $e->getMessage());
            return [];
        }

           
    }


}
