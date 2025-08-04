<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuestionModel;
use App\Models\QuestionnaireDetailModel;
use App\Models\QuestionnaireModel;

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
		return view('admin/questionnaire/show', ['id' => $id]);
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
			foreach ($post['question_id'] as $key => $each) {
				if (empty($key)) continue;	// Skip if empty
				$data[] = [
					'questionnaire_id' => $id,
					'question_id' => $key,
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
