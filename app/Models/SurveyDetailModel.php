<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyDetailModel extends Model
{
	protected $table = 'survey_detail';
	protected $primaryKey = 'detail_id';
	protected $allowedFields = ['detail_id', 'survey_id', 'question_id', 'answer_text', 'option_id', 'created_at', 'is_approved'];
	protected $useAutoIncrement = false;
	protected $useTimestamps = false;

	public function getDetail($survey_id)
	{
		$builder = \Config\Database::connect();
		$builder = $builder->table('survey_detail t')
			->select('t.*, q.*, qr.*')
			->join('question q', 't.question_id = q.question_id')
			->join('survey h', 't.survey_id = h.survey_id')
			->join('questionnaire qr', 'h.questionnaire_id = qr.questionnaire_id')
			->where('t.survey_id', $survey_id)
			->get()
			->getResultArray();
		return $builder;
		// echo $builder->getCompiledSelect();die;
	}

	public function getData($survey_id)
	{
		$builder = \Config\Database::connect();
		$result = $builder->table('survey_detail d')
			->select('q.question,
				MAX(
					CASE WHEN d.is_approved = 1 THEN COALESCE(o.option_name, d.answer_text) END
				) AS approved_answer,
				STRING_AGG(
					CASE WHEN d.is_approved = 0
						THEN \'<b>\' || d.created_at || \'</b><br> \' || COALESCE(o.option_name, d.answer_text)
						ELSE NULL END,
					\' <br><br> \'
					ORDER BY d.created_at DESC
				) AS history')
			->join('question q', 'q.question_id = d.question_id')
			->join('question_option o', 'o.option_id = d.option_id', 'left')
			->where('d.survey_id', $survey_id)
			->groupBy('q.question')
			->get()
			->getResultArray();

		return $result;
	}

	public function getLatestAnswer($survey_id)
	{
		$builder = \Config\Database::connect();

		// Fetch max created_at
		$created_at = $builder->table('survey_detail')
			->select('created_at')
			->where(['survey_id' => $survey_id, 'is_approved' => 0])
			->orderBy('created_at', 'DESC')
			->limit(1)
			->get()
			->getRow('created_at');

		// Fetch data
		$result = $builder->table('survey_detail t')
			->select('t.*, q.*, qr.questionnaire_type, qr.questionnaire_id')
			->join('question q', 't.question_id = q.question_id')
			->join('survey h', 't.survey_id = h.survey_id')
			->join('questionnaire qr', 'h.questionnaire_id = qr.questionnaire_id')
			->where(['t.survey_id' => $survey_id, 't.is_approved' => 0, 't.created_at' => $created_at])
			->get()
			->getResultArray();

		return $result;
	}
}
