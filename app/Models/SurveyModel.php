<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model
{
	protected $table = 'survey';
	protected $primaryKey = 'survey_id';
	protected $allowedFields = [
		'questionnaire_id',
		'citizen_id',
		'responden',
		'institution',
		'survey_status',
		'approval_at'
	];
	protected $useTimestamps = true;
}
