<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionOptionModel extends Model
{
	protected $table = 'question_option';
	protected $primaryKey = 'option_id';
	protected $allowedFields = ['question_id', 'option_name', 'option_description'];

	protected $validationRules = [
		'question_id' => 'required',
		'option_name' => 'required',
	];

	public static function getData($question_id)
	{
		$result = (new QuestionOptionModel())
			->whereIn('question_id', $question_id)
			->findAll();
		return $result;
	}
}
