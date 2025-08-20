<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterTrainingModel extends Model
{
    protected $table = 'master_training';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_pelatihan'];
}