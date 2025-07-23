<?php

namespace App\Models;

use App\Controllers\Admin\Question;
use CodeIgniter\Model;

class QuestionModel extends Model
{
	protected $table = 'question';
	protected $primaryKey = 'question_id';
	protected $allowedFields = ['question', 'question_description', 'answer_type', 'question_status'];
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
			->orderBy('question', 'ASC')
			->findAll();
		return array_column($data, 'question', 'question_id');
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
