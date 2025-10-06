<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use CodeIgniter\Model;

class SurveyTrainingPlanModel extends Model
{
	protected $table = 'survey_training_plan';
	protected $primaryKey = 'plan_id';
	protected $allowedFields = ['plan_id', 'survey_id', 'user_id', 'training_id', 'plan_year', 'plan_month', 'plan_status', 'created_at'];
	protected $useAutoIncrement = false;
	protected $useTimestamps = false;

	const STAT_INACTIVE = 0;
	const STAT_ACTIVE = 1;

	public function getData($survey_id)
	{
		$builder = \Config\Database::connect();
		$data = $builder->table('survey_training_plan p')
			->select('p.*, nama_pelatihan')
			->join('master_training t', 'p.training_id = t.id')
			->where('p.survey_id', $survey_id)
			->orderBy('p.created_at', 'DESC')
			->get()
			->getResultArray();

		$result = [];
		$temp_training = $temp_year = $temp_month = '';
		$months = CommonHelper::months();
		foreach ($data as $key => $each) {
			// Handle approved answer
			if ($each['plan_status'] == self::STAT_ACTIVE) {
				if (!isset($result['approved'])) {
					$result['approved'] = [
						'nama_pelatihan' => "- {$each['nama_pelatihan']}",
						'plan_year' => $each['plan_year'],
						'plan_month' => $months[$each['plan_month']],
					];
				} else {
					$result['approved']['nama_pelatihan'] .= "\n- {$each['nama_pelatihan']}";
				}
			}

			// Handle history
			if ($key == 0 || $each['created_at'] != $data[$key - 1]['created_at']) {
				$temp_training .= "\n<b>{$each['created_at']}</b> \n- {$each['nama_pelatihan']}";
			} else {
				$temp_training .= "\n- {$each['nama_pelatihan']}\n";
			}

			if ($key == 0 || $each['created_at'] != $data[$key - 1]['created_at']) {
				$temp_year .= "\n<b>{$each['created_at']}</b> \n{$each['plan_year']}\n";
			}

			if ($key == 0 || $each['created_at'] != $data[$key - 1]['created_at']) {
				$temp_month .= "\n<b>{$each['created_at']}</b> \n{$months[$each['plan_month']]}\n";
			}
		}

		$result['history'] = [
			'nama_pelatihan' => trim($temp_training),
			'plan_year' => trim($temp_year),
			'plan_month' => trim($temp_month),
		];

		return $result;
	}
}
