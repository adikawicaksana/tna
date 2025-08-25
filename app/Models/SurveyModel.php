<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model
{
	protected $table = 'survey';
	protected $primaryKey = 'survey_id';
	protected $allowedFields = [
		'questionnaire_id',
		'citizen_id',
		'responden',
		'institution',
		'survey_status',
		'approval_at'
	];
	protected $useTimestamps = true;

	const STAT_CANCELLED = 0;
	const STAT_ACTIVE = 1;

	public static function listStatus()
	{
		return [
			self::STAT_CANCELLED => 'Dibatalkan',
			self::STAT_ACTIVE => 'Aktif',
		];
	}
}
