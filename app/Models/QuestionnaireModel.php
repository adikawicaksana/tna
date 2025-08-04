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
	const TYPE_INDIVIDUAL = 2;
	const TYPE_NON_FASYANKES = 3;

	const STAT_INACTIVE = 0;
	const STAT_ACTIVE = 1;

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
			self::TYPE_INDIVIDUAL => 'Individu',
			self::TYPE_NON_FASYANKES => 'Non-Fasyankes',
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
