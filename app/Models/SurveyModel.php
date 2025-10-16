<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use CodeIgniter\Model;

class SurveyModel extends Model
{
	protected $table = 'survey';
	protected $primaryKey = 'survey_id';
	protected $allowedFields = [
		'survey_id',
		'questionnaire_id',
		'institution_id',
		'response_type',
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

	const RESPONDENT_TYPE_INDIVIDUAL = 1;
	const RESPONDENT_TYPE_INSTITUTION = 2;

	public static function listStatus()
	{
		return [
			self::STAT_CANCELLED => 'Dibatalkan',
			self::STAT_OPEN => 'Belum Disetujui',
			self::STAT_ACTIVE => 'Aktif',
			self::STAT_DECLINED => 'Ditolak',
		];
	}

	public static function listRespondentType()
	{
		return [
			self::RESPONDENT_TYPE_INDIVIDUAL => 'Individu',
			self::RESPONDENT_TYPE_INSTITUTION => 'Instansi',
		];
	}

	public static function isEditable($id)
	{
		$model = (new self())->find($id);
		$result = in_array($model['survey_status'], [self::STAT_OPEN, self::STAT_DECLINED]);
		$result &= (session()->get('_id_users') == $model['respondent_id']);
		$result &= (CommonHelper::hasAccess('Survey', 'update', false));

		return $result;
	}

	public static function isApprovable($id)
	{
		$model = (new self())->find($id);
		$result = ($model['survey_status'] == self::STAT_OPEN);
		$result &= (CommonHelper::hasAccess('Survey', 'approval', true));

		return $result;
	}

	public static function surveyByInstitusi($id_institusi, $year)
	{

		$result = (new self())
        ->where('institution_id', $id_institusi)
        ->where("EXTRACT(YEAR FROM created_at) =", $year, false)
        ->findAll();

		return $result;
	}
}
