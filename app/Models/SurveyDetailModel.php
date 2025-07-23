<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyDetailModel extends Model
{
	protected $table = 'survey_detail';
	protected $primaryKey = 'detail_id';
	protected $allowedFields = ['survey_id', 'question_id'];
}
