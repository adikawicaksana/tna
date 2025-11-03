<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\CommonHelper;
use App\Models\InstitutionsModel;
use App\Models\SurveyModel;
use App\Models\UserDetailModel;
use App\Models\UsersManagerModel;
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
		$data = $this->_getTrainingNeedsSummary();

		// Fetch institution list
		$institution = [];
		$m_institutions = (new UsersManagerModel())->searchByIDusers(session()->get('_id_users'), 'institusi');
		if (array_column($m_institutions, '_id_institutions')) {
			$p_institusi = array_column($m_institutions, '_id_institutions');
			$institution = \Config\Database::connect()
				->table('master_institutions')
				->whereIn('id', $p_institusi)
				->whereIn('type', ['puskesmas', 'rumahsakit'])
				->get()->getResultArray();
		}

		$title = 'Rekapitulasi Kebutuhan Pelatihan di Fasyankes ';
		return view('report/training_needs_summary', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data['data'] ?? [],
			'detail' => $data['detail'] ?? [],
			'competence' => $data['competence'] ?? [],
			'title' => $title,
			'years' => CommonHelper::years('2025'),
			'institution' => $institution,
		]);
	}

	public function xlsTrainingNeedsSummary()
	{
		$result = $this->_getTrainingNeedsSummary();
		extract($result);
		$title = 'REKAPITULASI KEBUTUHAN PELATIHAN DI FASYANKES ';
		$title .= !empty($_GET['institution_id']) ? strtoupper($data[0]['institution_name']) : '';

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$lastRow = $sheet->getHighestRow();

		// Set title
		$sheet->setCellValue('A' . $lastRow, $title);
		$sheet->getStyle('A1:L1')->getFont()->setBold(true);
		$temp = 'Institusi: ';
		$temp .= !empty($_GET['institution_id']) ? $data[0]['insitution_name'] : '-';
		$sheet->setCellValue('A' . ++$lastRow, $temp);
		$temp = 'Tahun Usulan: ';
		$temp .= !empty($_GET['plan_year']) ? $data[0]['plan_year'] : '-';
		$sheet->setCellValue('A' . ++$lastRow, $temp);

		// Set header
		++$lastRow;
		$header = [
			'Instansi',
			'Nama',
			'NIP',
			'Pendidikan Terakhir',
			'Jabatan',
			'Bidang / Seksi / Subbag',
			'SKP / Uraian Tugas',
			'Kompetensi (Pelatihan / Peningkatan Kompetensi) yang Sudah Diikuti',
			'Kompetensi (Pelatihan / Peningkatan Kompetensi) yang Belum Diikuti',
			'Analisa Kesenjangan Kompetensi',
			'Rencana Pengembangan Kompetensi yang Dibutuhkan',
			'Tahun Usulan'
		];
		$sheet->fromArray($header, null, 'A' . ++$lastRow);
		$sheet->getStyle('A5:L5')->getFont()->setBold(true);

		// Set data rows
		foreach ($data as $each) {
			$row = [
				ucwords(strtolower($each['institution_type'] . ' ' . $each['institution_name'])),
				$each['fullname'],
				$each['nip'],
				$each['jenjang_pendidikan'],
				$each['jurusan_profesi'],
				$detail[$each['survey_id']]['work_unit'],
				"- " . str_replace("<br>", "\n", trim($competence[$each['survey_id']]['job_description'])),
				"- " . str_replace("<br>", "\n", trim($competence[$each['survey_id']]['training_complete'])),
				"- " . str_replace("<br>", "\n", trim($competence[$each['survey_id']]['training_incomplete'])),
				$detail[$each['survey_id']]['gap_competency'],
				$each['nama_pelatihan'],
				$each['plan_year'],
			];
			$sheet->fromArray($row, null, 'A' . ++$lastRow);
		}

		$sheet->getStyle('G:I')->getAlignment()->setWrapText(true);
		$writer = new Xlsx($spreadsheet);
		$fileName = 'Rekapitulasi Kebutuhan Pelatihan di Fasyankes ' . time() . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit();
	}

	public function _getTrainingNeedsSummary()
	{
		$plan_year = (!isset($_GET['plan_year'])) ? date('Y') + 1 : $_GET['plan_year'];

		// Fetch survey data
		$builder = \Config\Database::connect();
		$builder = $builder->table('survey s')
			->select('s.survey_id, ud.fullname, ud.front_title, ud.back_title, ud.nip, s.jenjang_pendidikan, s.jurusan_profesi,
				tp.plan_year, t.nama_pelatihan, i.type AS institution_type, i.name AS institution_name', 'question_name')
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
		if (!empty($plan_year)) {
			$builder->where(['plan_year' => $plan_year]);
		}
		$builder->orderBy('institution_name', 'ASC')
			->orderBy('fullname', 'ASC');

		$data = $builder->get()->getResultArray();
		$survey_id = array_column($data, 'survey_id');

		$detail = $competence = [];
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
		// $title .= !empty($_GET['institution_id']) ? $data[0]['institution_name'] : '';

		// Fetch institution list
		$institution = [];
		$m_institutions = (new UsersManagerModel())->searchByIDusers(session()->get('_id_users'), 'institusi');
		if (array_column($m_institutions, '_id_institutions')) {
			$p_institusi = array_column($m_institutions, '_id_institutions');
			$institution = \Config\Database::connect()
				->table('master_institutions')
				->whereIn('id', $p_institusi)
				->whereIn('type', ['puskesmas', 'rumahsakit'])
				->get()->getResultArray();
		}

		return view('report/training_needs_summary2', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data,
			'title' => $title,
			'years' => CommonHelper::years('2025'),
			'institution' => $institution,
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
				ucwords(strtolower($each['institution_type'] . ' ' . $each['institution_name'])),
				$each['nama_pelatihan'],
				$each['fullname'],
				$each['plan_year'],
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
		$plan_year = (!isset($_GET['plan_year'])) ? date('Y') + 1 : $_GET['plan_year'];

		// Fetch survey data
		$builder = \Config\Database::connect();
		$builder = $builder->table('survey_training_plan tp')
			->select('i.type AS institution_type, i.name AS institution_name, t.nama_pelatihan, ud.fullname, plan_year')
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
		if (!empty($plan_year)) {
			$builder->where('plan_year', $plan_year);
		}

		return $builder->orderBy('institution_name', 'nama_pelatihan', 'plan_year')
			->get()->getResultArray();
	}

	public function trainingNeedsSummaryByRegency()
	{
		$data = $this->_getTrainingNeedsSummaryByRegency();
		$title = 'Rekapitulasi Kebutuhan Pelatihan di Kabupaten/Kota';

		// // Fetch institution list
		// $institution = [];
		// $m_institutions = (new UsersManagerModel())->searchByIDusers(session()->get('_id_users'), 'kabkota');
		// if (array_column($m_institutions, '_id_institutions')) {
		// 	$p_institusi = array_column($m_institutions, '_id_institutions');
		// 	$institution = \Config\Database::connect()
		// 		->table('master_institutions')
		// 		->whereIn('id', $p_institusi)
		// 		->whereIn('type', ['puskesmas', 'rumahsakit'])
		// 		->get()->getResultArray();
		// }
		// dd($institution);

		return view('report/training_needs_summary_by_regency', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data['data'] ?? [],
			'detail' => $data['detail'] ?? [],
			'competence' => $data['competence'] ?? [],
			'title' => $title,
			'years' => CommonHelper::years('2025'),
		]);
	}

	public function xlsTrainingNeedsSummaryByRegency()
	{
		$result = $this->_getTrainingNeedsSummaryByRegency();
		extract($result);
		$title = 'REKAPITULASI KEBUTUHAN PELATIHAN DI KABUPATEN/KOTA';

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$lastRow = $sheet->getHighestRow();

		// Set title
		$sheet->setCellValue('A' . $lastRow, $title);
		$sheet->getStyle('A1:L1')->getFont()->setBold(true);
		$temp = 'Institusi: ';
		$temp .= !empty($_GET['institution_id']) ? $data[0]['insitution_name'] : '-';
		$sheet->setCellValue('A' . ++$lastRow, $temp);
		$temp = 'Tahun Usulan: ';
		$temp .= !empty($_GET['plan_year']) ? $data[0]['plan_year'] : '-';
		$sheet->setCellValue('A' . ++$lastRow, $temp);

		// Set header
		++$lastRow;
		$header = [
			'Instansi',
			'Nama',
			'NIP',
			'Pendidikan Terakhir',
			'Jabatan',
			'Bidang / Seksi / Subbag',
			'SKP / Uraian Tugas',
			'Kompetensi (Pelatihan / Peningkatan Kompetensi) yang Sudah Diikuti',
			'Kompetensi (Pelatihan / Peningkatan Kompetensi) yang Belum Diikuti',
			'Analisa Kesenjangan Kompetensi',
			'Rencana Pengembangan Kompetensi yang Dibutuhkan',
			'Tahun Usulan'
		];
		$sheet->fromArray($header, null, 'A' . ++$lastRow);
		$sheet->getStyle('A5:L5')->getFont()->setBold(true);

		// Set data rows
		foreach ($data as $each) {
			$row = [
				ucwords(strtolower($each['institution_type'] . ' ' . $each['institution_name'])),
				$each['fullname'],
				trim($each['nip']),
				trim($each['jenjang_pendidikan']),
				trim($each['jurusan_profesi']),
				$detail[$each['survey_id']]['work_unit'],
				"- " . str_replace("<br>", "\n", trim($competence[$each['survey_id']]['job_description'])),
				"- " . str_replace("<br>", "\n", trim($competence[$each['survey_id']]['training_complete'])),
				"- " . str_replace("<br>", "\n", trim($competence[$each['survey_id']]['training_incomplete'])),
				$detail[$each['survey_id']]['gap_competency'],
				$each['nama_pelatihan'],
				$each['plan_year'],
			];
			$sheet->fromArray($row, null, 'A' . ++$lastRow);
		}

		// Set width and wrap text
		foreach (range('A', 'F') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}
		foreach (range('G', 'I') as $col) {
			$sheet->getColumnDimension($col)->setWidth(50);
		}
		$sheet->getStyle('G:I')->getAlignment()->setWrapText(true);
		// Set merge title
		$highestColumn = $sheet->getHighestColumn();
		$sheet->mergeCells("A1:{$highestColumn}1");
		$sheet->mergeCells("A2:{$highestColumn}2");
		$sheet->mergeCells("A3:{$highestColumn}3");

		$writer = new Xlsx($spreadsheet);
		$fileName = 'Rekapitulasi Kebutuhan Pelatihan di Kabupaten Kota ' . time() . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit();
	}

	private function _getTrainingNeedsSummaryByRegency()
	{
		$plan_year = (!isset($_GET['plan_year']) || empty($_GET['plan_year'])) ? date('Y') + 1 : $_GET['plan_year'];

		// Fetch survey data
		$builder = \Config\Database::connect();
		$builder = $builder->table('survey s')
			->select('s.survey_id, ud.fullname, ud.front_title, ud.back_title, ud.nip, s.jenjang_pendidikan, s.jurusan_profesi,
				tp.plan_year, t.nama_pelatihan, i.type AS institution_type, i.name AS institution_name', 'question_name')
			->join('survey_training_plan tp', 's.survey_id = tp.survey_id')
			->join('users_detail ud', 's.respondent_id = ud._id_users')
			->join('master_institutions i', 's.institution_id = i.id')
			->join('master_training t', 'tp.training_id = t.id')
			->where([
				'survey_status' => SurveyModel::STAT_ACTIVE,
				'plan_status' => 1,
			]);
		if (!empty($_GET['institution_id'])) {
			$builder->where(['institution_id' => $_GET['institution_id']])
				->orWhere(['parent' => $_GET['institution_id']]);
		}
		if (!empty($plan_year)) {
			$builder->where(['plan_year' => $plan_year]);
		}
		$builder->orderBy('institution_name', 'ASC')
			->orderBy('fullname', 'ASC');

		$data = $builder->get()->getResultArray();
		$survey_id = array_column($data, 'survey_id');

		$detail = $competence = [];
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
}
