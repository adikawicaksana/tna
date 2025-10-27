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
		->where('EXTRACT(YEAR FROM created_at) =', (int) $year, false)
        ->findAll();

		return $result;
	}

	public function getTrainingSummaryByYear($year, $institutionId)
    {
        try {
            $builder = $this->db->table('survey s');
            $builder->select('
                stp.training_id,
                mt.nama_pelatihan as training_title,
                stp.plan_year,
                COUNT(stp.training_id) AS total_request
            ');
            $builder->join('survey_training_plan as stp', 'stp.survey_id = s.survey_id', 'left');
            $builder->join('master_training as mt', 'mt.id = stp.training_id', 'left');
            $builder->where("EXTRACT(YEAR FROM s.created_at) =", $year, false);
            $builder->where('s.institution_id', $institutionId);
            $builder->groupBy('stp.training_id, stp.plan_year, mt.nama_pelatihan');
            $builder->orderBy('stp.plan_year', 'ASC');

            $query = $builder->get();
            return $query->getResultArray();

        } catch (Exception $e) {
            log_message('error', '[SurveyModel] Query failed: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => 'Gagal mengambil data pelatihan: ' . $e->getMessage()
            ];
        }
    }
}
