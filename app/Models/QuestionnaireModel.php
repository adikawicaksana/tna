<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionnaireModel extends Model
{
	protected $table = 'questionnaire';
	protected $primaryKey = 'questionnaire_id';
	protected $allowedFields = ['questionnaire_id', 'questionnaire_type', 'questionnaire_status'];
	protected $useTimestamps = true;

	const TYPE_INSTITUTION = 1;
	const TYPE_INDIVIDUAL = 2;

	const STAT_INACTIVE = 0;
	const STAT_ACTIVE = 1;

	public static function listType()
	{
		return [
			self::TYPE_INSTITUTION => 'Institusi',
			self::TYPE_INDIVIDUAL => 'Individu',
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
