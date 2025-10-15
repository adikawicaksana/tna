<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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

		$builder = \Config\Database::connect();
		$builder = $builder->table('survey s')
			->select('ud.fullname, ud.front_title, ud.back_title, ud.nip, s.jenjang_pendidikan, s.jurusan_profesi,
				tp.plan_year, t.nama_pelatihan, i.name AS institution_name')
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
		// dd($builder->getCompiledSelect());
		// dd($data);

		$title = 'Rekapitulasi Kebutuhan Pelatihan di Fasyankes ';
		$title .= !empty($get['institution_name']) ? $data[0]['institution_name'] : '';
		return view('report/training_needs_summary', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data,
			'title' => $title,
		]);
	}
}

