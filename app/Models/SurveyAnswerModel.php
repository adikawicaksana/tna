<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyAnswerModel extends Model
{
	protected $table = 'survey_answer';
	protected $primaryKey = 'answer_id';
	protected $allowedFields = ['detail_id', 'answer_value', 'approved_value'];
}
