<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuestionModel;
use App\Models\QuestionOptionModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;

class Question extends BaseController
{
	protected $model;

	public function __construct()
	{
		$this->model = new QuestionModel();
	}

	public function index()
	{
		// $db = \Config\Database::connect();
		// echo $db->getVersion();
		// die;
		$data = $this->model->findAll();
		return view('admin/question/index', [
			'data' => $data,
			'answer_type' => $this->model::listAnswerType(),
			'status' => $this->model::listStatus(),
			'title' => 'Daftar Pertanyaan',
		]);
	}

	public function show($id)
	{
		$db = \Config\Database::connect();
		$sql = "SELECT *
			FROM question q
			LEFT JOIN question_option o ON (q.question_id = o.question_id)
			WHERE q.question_id = $id";
		$query = $db->query($sql);
		$data = $query->getResultArray();

		if (empty($data)) {
			throw PageNotFoundException::forPageNotFound('Data tidak ditemukan');
		}

		return view('admin/question/show', [
			'data' => $data,
			'answer_type' => QuestionModel::listAnswerType(),
			'title' => 'Detail Pertanyaan',
		]);
	}

	public function create()
	{
		return view('admin/question/form', [
			'answer_type' => $this->model::listAnswerType(),
			'has_option' => $this->model::hasOption(),
			'title' => 'Tambah Pertanyaan',
		]);
	}

	public function store()
	{
		$dbtrans = \Config\Database::connect();
		$dbtrans->transBegin();
		try {
			$post = $this->request->getPost();
			// Insert into Question Table
			$has_option = in_array($post['answer_type'], QuestionModel::hasOption());
			$data = [
				'question' => $post['question'],
				'question_description' => $post['question_description'],
				'answer_type' => $post['answer_type'],
				'question_status' => $this->model::STAT_ACTIVE,
				'source_reference' => ($has_option && !empty($post['source_reference'])) ?
					$post['source_reference'] : '',
			];
			if (!$this->model->save($data)) {
				throw new \Exception('Gagal menyimpan pertanyaan: ' . json_encode($this->model->errors()));
			}

			// Insert into Option Table
			$id = $this->model->getInsertID();
			if ($has_option & empty($post['source_reference'])) {
				$data = [];
				$option = new QuestionOptionModel();
				$description = $post['option_description'];
				foreach ($post['option_name'] as $key => $each) {
					$data[] = [
						'question_id' => $id,
						'option_name' => trim($each),
						'option_description' => $description[$key],
					];
				}
				if (empty($data)) throw new \Exception('Pilihan jawaban tidak boleh kosong!');

				if (!$option->insertBatch($data)) {
					throw new \Exception('Gagal menyimpan pertanyaan: ' . json_encode($option->errors()));
				}
			}

			$dbtrans->transCommit();
			return redirect()->to(route_to('question.index'))->with('success', 'Data berhasil disimpan');
		} catch (\Throwable $e) {
			$dbtrans->transRollback();
			// dd($e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data');
		}
	}

	public function update($id)
	{
		$data = $this->model->findOne($id);
		return view('admin/question/form', $data);
	}

	public function deactivate($id)
	{
		if ($this->request->getMethod() !== 'POST') {
			return redirect()->back()->with('error', 'Method tidak diizinkan');
		}

		if (!QuestionModel::isDeactivatable($id)) {
			return redirect()->back()->with('error', 'Data tidak dapat dinonaktifkan.');
		}

		if (!$this->model->update($id, ['question_status' => QuestionModel::STAT_INACTIVE])) {
			return redirect()->back()
				->with('error', 'Gagal menonaktifkan data <br>' . json_encode($this->model->errors()));
		}
		return redirect()->back()->with('success', 'Data berhasil dinonaktifkan');
	}
}
