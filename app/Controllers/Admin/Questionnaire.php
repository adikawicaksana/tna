<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuestionModel;
use App\Models\QuestionnaireDetailModel;
use App\Models\QuestionnaireModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Questionnaire extends BaseController
{
	protected $model;

	public function __construct()
	{
		$this->model = new QuestionnaireModel();
	}

	public function index()
	{
		$data = $this->model
			->orderBy('questionnaire_status', 'DESC')
			->orderBy('created_at', 'DESC')
			->findAll();
		return view('admin/questionnaire/index', [
			'data' => $data,
			'type' => $this->model::listType(),
			'status' => $this->model::listStatus(),
			'title' => 'Daftar Kuesioner',
		]);
	}

	public function show($id)
	{
		$db = \Config\Database::connect();
		$sql = "SELECT *
			FROM questionnaire h
				INNER JOIN questionnaire_detail d ON (h.questionnaire_id = d.questionnaire_id)
				INNER JOIN question q ON (d.question_id = q.question_id)
			WHERE h.questionnaire_id = $id";
		$data = $db->query($sql)->getResultArray();

		if (empty($data)) {
			throw PageNotFoundException::forPageNotFound('Data tidak ditemukan');
		}

		return view('admin/questionnaire/show', [
			'data' => $data,
			'questionnaire_type' => $this->model::listType(),
			'questionnaire_status' => $this->model::listStatus(),
			'has_active' => $this->model::hasActive($data[0]['questionnaire_type']),
			'title' => 'Detail Kuesioner',
		]);
	}

	public function create()
	{
		return view('admin/questionnaire/form', [
			'type' => $this->model::listType(),
			'question' => QuestionModel::getDropdownList(),
			'title' => 'Tambah Kuesioner',
		]);
	}

	public function store()
	{
		$dbtrans = \Config\Database::connect();
		$dbtrans->transBegin();

		try {
			$post = $this->request->getPost();

			// Insert into Questionnaire Table
			$data = [
				'questionnaire_type' => $post['questionnaire_type'],
				'questionnaire_status' => QuestionnaireModel::hasActive($post['questionnaire_type']) ?
					$this->model::STAT_INACTIVE : $this->model::STAT_ACTIVE,
			];
			if (!$this->model->save($data)) {
				throw new \Exception('Gagal menyimpan kuesioner: ' . print_r($this->model->errors(), true));
			}

			// Insert into Detail Table
			$id = $this->model->getInsertID();
			$data = [];
			$detail = new QuestionnaireDetailModel();
			foreach ($post['question_id'] as $each) {
				if (empty($each)) continue;	// Skip if empty
				$data[] = [
					'questionnaire_id' => $id,
					'question_id' => $each,
				];
			}
			if (empty($data)) throw new \Exception('Pertanyaan tidak boleh kosong!');

			if (!$detail->insertBatch($data)) {
				throw new \Exception('Gagal menyimpan kuesioner: ' . print_r($detail->errors(), true));
			}

			$dbtrans->transCommit();
			return redirect()->to(route_to('questionnaire.index'))->with('success', 'Data berhasil disimpan');
		} catch (\Throwable $e) {
			$dbtrans->transRollback();
			// dd($e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ');
		}
	}

	public function update($id)
	{
		$data = $this->model->findOne($id);
		return view('admin/questionnaire/form', $data);
	}
}
