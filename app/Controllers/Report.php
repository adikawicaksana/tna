<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\CommonHelper;
use App\Models\SurveyModel;
use App\Models\UserDetailModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
		$data = $this->_getTrainingNeedsSummary();

		$title = 'Rekapitulasi Kebutuhan Pelatihan di Fasyankes ';
		$title .= !empty($get['institution_name']) ? $data[0]['institution_name'] : '';
		return view('report/training_needs_summary', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data['data'],
			'detail' => $data['detail'],
			'competence' => $data['competence'],
			'title' => $title,
			'years' => CommonHelper::years('2025'),
		]);
	}

	public function _getTrainingNeedsSummary()
	{
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
		if (!empty($_GET['institution_id'])) {
			$builder->where(['institution_id' => $_GET['institution_id']]);
		}
		if (!empty($_GET['plan_year'])) {
			$builder->where(['plan_year' => $_GET['plan_year']]);
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
			$builder = \Config\Database::connect();
			$builder = $builder->table('respondent_detail rd')
				->select("survey_id, STRING_AGG(DISTINCT job_description, '<br>- ') AS job_description,
					STRING_AGG(DISTINCT CASE WHEN status = 0 THEN t.nama_pelatihan END, '<br>- ') AS training_incomplete,
					STRING_AGG(DISTINCT CASE WHEN status = 1 THEN t.nama_pelatihan END, '<br>- ') AS training_complete")
				->join('master_training t', 'rd.training_id = t.id')
				->whereIn('survey_id', $survey_id)
				->groupBy('survey_id')
				->get()->getResultArray();
			$competence = array_column($builder, null, 'survey_id');
		}

		// dd($builder->getCompiledSelect());
		// dd($data);
		return [
			'data' => $data,
			'detail' => $detail,
			'competence' => $competence,
		];
	}

	public function trainingNeedsSummary2()
	{
		$data = $this->_getTrainingNeedsSummary2();
		$title = 'Rekapitulasi Pelatihan atau Peningkatan Kompetensi yang Dibutuhkan Pegawai Fasyankes ';
		$title .= !empty($_GET['institution_id']) ? $data[0]['institution_name'] : '';
		return view('report/training_needs_summary2', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data,
			'title' => $title,
			'years' => CommonHelper::years('2025'),
		]);
	}

	public function xlsTrainingNeedsSummary2()
	{
		$data = $this->_getTrainingNeedsSummary2();
		$title = 'REKAPITULASI PELATIHAN ATAU PENINGKATAN KOMPETENSI YANG DIBUTUHKAN PEGAWAI FASYANKES ';
		$title .= !empty($_GET['institution_id']) ? strtoupper($data[0]['institution_name']) : '';

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$lastRow = $sheet->getHighestRow();

		// Set title
		$sheet->setCellValue('A' . $lastRow, $title);
		$sheet->getStyle('A1:D1')->getFont()->setBold(true);
		$temp = 'Institusi: ';
		$temp .= !empty($_GET['institution_id']) ? $data[0]['insitution_name'] : '-';
		$sheet->setCellValue('A' . ++$lastRow, $temp);
		$temp = 'Tahun Usulan: ';
		$temp .= !empty($_GET['plan_year']) ? $data[0]['plan_year'] : '-';
		$sheet->setCellValue('A' . ++$lastRow, $temp);

		// Set header
		++$lastRow;
		$header = ['Instansi', 'Nama Pelatihan', 'Pegawai yang Membutuhkan', 'Tahun Usulan'];
		$sheet->fromArray($header, null, 'A' . ++$lastRow);
		$sheet->getStyle('A5:D5')->getFont()->setBold(true);

		// Set data rows
		foreach ($data as $each) {
			$row = [
				$each['institution_name'], $each['nama_pelatihan'], $each['fullname'], $each['plan_year'],
			];
			$sheet->fromArray($row, null, 'A' . ++$lastRow);
		}

		$writer = new Xlsx($spreadsheet);
		$fileName = 'Rekapitulasi Pelatihan yang Dibutuhkan Pegawai ' . time() . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit();
	}

	private function _getTrainingNeedsSummary2()
	{
		// Fetch survey data
		$builder = \Config\Database::connect();
		$builder = $builder->table('survey_training_plan tp')
			->select('i.name AS institution_name, t.nama_pelatihan, ud.fullname, plan_year')
			->join('survey s', 'tp.survey_id = s.survey_id')
			->join('master_institutions i', 's.institution_id = i.id')
			->join('users_detail ud', 'tp.user_id = ud._id_users')
			->join('master_training t', 'tp.training_id = t.id')
			->where([
				'plan_status' => 1,
			]);

		if (!empty($_GET['institution_id'])) {
			$builder->where('institution_id', $_GET['institution_id']);
		}
		if (!empty($_GET['plan_year'])) {
			$builder->where('plan_year', $_GET['plan_year']);
		}

		return $builder->orderBy('institution_name', 'nama_pelatihan', 'plan_year')
			->get()->getResultArray();
	}
}
