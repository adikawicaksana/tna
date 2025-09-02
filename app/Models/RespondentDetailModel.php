<?php

namespace App\Models;

use CodeIgniter\Model;

class RespondentDetailModel extends Model
{
	protected $table = 'respondent_detail';
	protected $primaryKey = 'detail_id';
	protected $allowedFields = [
		'detail_id',
		'survey_id',
		'competence_id',
	];
	protected $useAutoIncrement = false;
}
