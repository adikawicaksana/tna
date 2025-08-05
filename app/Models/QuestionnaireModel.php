<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionnaireModel extends Model
{
	protected $table = 'questionnaire';
	protected $primaryKey = 'questionnaire_id';
	protected $allowedFields = ['questionnaire_type', 'questionnaire_status'];
	protected $useTimestamps = true;

	const TYPE_FASYANKES = 1;
	const TYPE_INDIVIDUAL_FASYANKES = 2;
	const TYPE_INSTITUTE = 3;
	const TYPE_INDIVIDUAL_INSTITUTE = 4;

	const STAT_INACTIVE = 0;
	const STAT_ACTIVE = 1;

	public static function getData($condition = [])
	{
		// Fetch question list
		$db = \Config\Database::connect();
		$builder = $db->table('questionnaire h');
		$builder->select('*')
			->join('questionnaire_detail d', 'h.questionnaire_id = d.questionnaire_id', 'inner')
			->join('question q', 'd.question_id = q.question_id', 'inner');
		// ->join('question_option o', 'q.question_id = o.question_id', 'left');
		if (!empty($condition)) $builder->where($condition);

		return $builder->get()->getResultArray();
	}

	public static function hasActive($type)
	{
		$model = new QuestionnaireModel();
		$result = $model->where('questionnaire_type', $type)
			->where('questionnaire_status', self::STAT_ACTIVE)
			->countAllResults();

		return $result > 0;
	}

	public static function listType()
	{
		return [
			self::TYPE_FASYANKES => 'Fasyankes',
			self::TYPE_INDIVIDUAL_FASYANKES => 'Individu Fasyankes',
			self::TYPE_INSTITUTE => 'Instansi',
			self::TYPE_INDIVIDUAL_INSTITUTE => 'Individu Instansi',
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
