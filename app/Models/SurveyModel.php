<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model
{
	protected $table = 'survey';
	protected $primaryKey = 'survey_id';
	protected $allowedFields = [
		'survey_id',
		'questionnaire_id',
		'responden',
		'survey_status',
		'approval_at'
	];
	protected $useTimestamps = true;

	const STAT_CANCELLED = 0;
	const STAT_OPEN = 1;
	const STAT_ACTIVE = 2;
	const STAT_DECLINED = 3;

	public static function listStatus()
	{
		return [
			self::STAT_CANCELLED => 'Dibatalkan',
			self::STAT_OPEN => 'Belum Disetujui',
			self::STAT_ACTIVE => 'Aktif',
			self::STAT_DECLINED => 'Ditolak',
		];
	}
}
