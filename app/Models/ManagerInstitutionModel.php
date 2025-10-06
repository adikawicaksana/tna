<?php
namespace App\Models;

use CodeIgniter\Model;

class ManagerInstitutionModel extends Model
{
    protected $table      = 'manager_institutions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id','_id_users','_id_institutions'];
    protected $useTimestamps = true;

}
