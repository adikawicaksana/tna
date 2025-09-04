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
		'institution_id',
		'institution_type',
		'survey_status',
		'respondent_id',
		'jenjang_pendidikan',
		'jurusan_profesi',
		'created_at',
		'approved_by',
		'approval_remark',
		'approved_at'
	];

	protected $useAutoIncrement = false;

	const STAT_CANCELLED = 0;
	const STAT_OPEN = 1;
	const STAT_ACTIVE = 2;
	const STAT_DECLINED = 3;

	const GROUP_FASYANKES = 1;
	const GROUP_NONFASYANKES = 2;

	public static function listStatus()
	{
		return [
			self::STAT_CANCELLED => 'Dibatalkan',
			self::STAT_OPEN => 'Belum Disetujui',
			self::STAT_ACTIVE => 'Aktif',
			self::STAT_DECLINED => 'Ditolak',
		];
	}

	public static function listGroupType()
	{
		return [
			self::GROUP_FASYANKES => 'Fasyankes',
			self::GROUP_NONFASYANKES => 'Non Fasyankes',
		];
	}

	public static function getGroupTypes()
	{
		return [
			self::GROUP_FASYANKES => [
				QuestionnaireModel::TYPE_FASYANKES,
				QuestionnaireModel::TYPE_INDIVIDUAL_FASYANKES,
			],
			self::GROUP_NONFASYANKES => [
				QuestionnaireModel::TYPE_INSTITUTE,
				QuestionnaireModel::TYPE_INDIVIDUAL_INSTITUTE,
			],
		];
	}

	public static function isEditable($id)
	{
		$model = (new self())->findOne($id);
		$result = in_array($model->survey_status, [self::STAT_OPEN, self::STAT_DECLINED]);

		return $result;
	}
}
