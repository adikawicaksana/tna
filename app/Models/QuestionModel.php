<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
	protected $table = 'question';
	protected $primaryKey = 'question_id';
	protected $allowedFields = [
		'question',
		'question_description',
		'source_reference',
		'answer_type',
		'question_status'
	];
	protected $useTimestamps = true;
	protected $useAutoIncrement = true;

	const TYPE_SHORT = 1;
	const TYPE_TEXT = 2;
	const TYPE_MULTIPLE_CHOICE = 3;		// Receive 1 answer
	const TYPE_MULTI_SELECT = 4;		// Receive more than 1 answers
	const TYPE_DROPDOWN = 5;

	const STAT_INACTIVE = 0;
	const STAT_ACTIVE = 1;

	protected $validationRules = [
		'question' => 'required',
		'answer_type' => 'required',
		'question_status' => 'required',
	];

	public static function getDropdownList()
	{
		$model = new QuestionModel();
		$data = $model->select('question_id, question')
			->where(['question_status' => QuestionModel::STAT_ACTIVE])
			->orderBy('question', 'ASC')
			->findAll();
		return array_column($data, 'question', 'question_id');
	}

	public static function isDeactivatable($id)
	{
		$model = new QuestionModel();
		$model = $model->find($id);
		$result = ($model['question_status'] == self::STAT_ACTIVE);

		// Check if any questionnaire is active
		$count = model(QuestionnaireDetailModel::class)
			->join('questionnaire AS q', 'q.questionnaire_id = questionnaire_detail.questionnaire_id')
			->where('question_id', $id)
			->where('questionnaire_status', QuestionnaireModel::STAT_ACTIVE)
			->countAllResults();
		$result &= $count <= 0;

		return $result;
	}

	public static function listAnswerType()
	{
		return [
			self::TYPE_SHORT => 'Jawaban Singkat',
			self::TYPE_TEXT => 'Paragraf',
			self::TYPE_MULTIPLE_CHOICE => 'Pilihan Ganda (1 Jawaban)',
			self::TYPE_MULTI_SELECT => 'Pilihan Ganda (Banyak Jawaban)',
			self::TYPE_DROPDOWN => 'Dropdown',
		];
	}

	public static function hasOption()
	{
		return [
			self::TYPE_MULTIPLE_CHOICE,
			self::TYPE_MULTI_SELECT,
			self::TYPE_DROPDOWN,
		];
	}

	public static function listStatus()
	{
		return [
			self::STAT_INACTIVE => 'Tidak Aktif',
			self::STAT_ACTIVE => 'Aktif',
		];
	}
}
