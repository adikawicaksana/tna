<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionOptionModel extends Model
{
	protected $table = 'question_option';
	protected $primaryKey = 'question_id';
	protected $allowedFields = ['question_id', 'option_name', 'option_description'];
}
