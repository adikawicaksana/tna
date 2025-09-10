<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyDetailModel extends Model
{
	protected $table = 'survey_detail';
	protected $primaryKey = 'detail_id';
	protected $allowedFields = ['detail_id', 'survey_id', 'question_id', 'answer'];
	protected $useAutoIncrement = false;
	protected $useTimestamps = false;

	public function getDetail($survey_id)
	{
		$builder = \Config\Database::connect();
		$builder = $builder->table('survey_detail t')
			->select('t.*, q.question')
			->join('question q', 't.question_id = q.question_id')
			->where('t.survey_id', $survey_id)
			->get()
			->getResultArray();
		return $builder;
		// echo $builder->getCompiledSelect();die;
	}
}
