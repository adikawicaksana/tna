<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\CommonHelper;
use App\Models\SurveyModel;
use App\Models\UserDetailModel;

class Report extends BaseController
{
	protected $userDetailModel;

	public function __construct()
	{
		$this->userDetailModel = new UserDetailModel();
	}

	public function trainingNeedsSummary()
	{
		$get = $this->request->getGet();
		$data = [];

		// Fetch survey data
		$builder = \Config\Database::connect();
		$builder = $builder->table('survey s')
			->select('s.survey_id, ud.fullname, ud.front_title, ud.back_title, ud.nip, s.jenjang_pendidikan, s.jurusan_profesi,
				tp.plan_year, t.nama_pelatihan, i.name AS institution_name', 'question_name')
			->join('survey_training_plan tp', 's.survey_id = tp.survey_id')
			->join('users_detail ud', 's.respondent_id = ud._id_users')
			->join('master_institutions i', 's.institution_id = i.id')
			->join('master_training t', 'tp.training_id = t.id')
			->where([
				'i.category' => 'fasyankes',
				'survey_status' => SurveyModel::STAT_ACTIVE,
				'plan_status' => 1,
			]);
		if (!empty($get['institution_id'])) {
			$builder->where(['institution_id' => $get['institution_id']]);
		}
		if (!empty($get['plan_year'])) {
			$builder->where(['plan_year' => $get['plan_year']]);
		}
		$builder->orderBy('institution_name', 'ASC')
			->orderBy('fullname', 'ASC');

		$data = $builder->get()->getResultArray();
		$survey_id = array_column($data, 'survey_id');

		if (!empty($survey_id)) {
			// Fetch survey detail
			$detail = [];
			$report_code = ['work_unit', 'gap_competency'];
			$builder = \Config\Database::connect();
			$builder = $builder->table('survey_detail d')
				->select('survey_id, report_code, answer_text')
				->join('question q', 'd.question_id = q.question_id')
				->whereIn('survey_id', $survey_id)
				->whereIn('report_code', $report_code)
				->where([
					'd.is_approved' => 1,
				]);
			foreach ($builder->get()->getResultArray() as $each) {
				$detail[$each['survey_id']][$each['report_code']] = $each['answer_text'];
			}

			// Fetch competence data
			$competence = [];
			$temp_jobdesc = '';
			$builder = \Config\Database::connect();
			$builder = $builder->table('respondent_detail rd')
				->select('rd.*, nama_pelatihan')
				->join('master_training t', 'rd.training_id = t.id')
				->whereIn('survey_id', $survey_id)
				->orderBy('survey_id');
			foreach ($temp = $builder->get()->getResultArray() as $key => $each) {
				if (isset($competence['survey_id'])) {
					$competence[$each['survey_id']]['job_description'] .= "\n - {$each['job_description']}";
					echo 'ada ' . $each['survey_id'];
					echo '<pre>'.print_r($competence, true);
				} else {
					$competence[$each['survey_id']] = [
						'job_description' => "\n - {$each['job_description']}",
					];
					echo 'gak ' . $each['survey_id'];
					echo '<pre>'.print_r($competence, true);
				}


			}
				dd($temp);
		}



		// dd($builder->getCompiledSelect());
		// dd($data);

		$title = 'Rekapitulasi Kebutuhan Pelatihan di Fasyankes ';
		$title .= !empty($get['institution_name']) ? $data[0]['institution_name'] : '';
		return view('report/training_needs_summary', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data,
			'detail' => $detail,
			'title' => $title,
			'years' => CommonHelper::years('2025'),
		]);
	}
}

