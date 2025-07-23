<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionnaireDetailModel extends Model
{
	protected $table = 'questionnaire_detail';
	protected $primaryKey = 'detail_id';
	protected $allowedFields = ['questionnaire_id', 'question_id'];
}
