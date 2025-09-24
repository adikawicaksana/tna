<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserDetailModel;
use App\Models\QuestionModel;
use App\Models\QuestionOptionModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;

class Question extends BaseController
{
	protected $userDetailModel;
	protected $model;

	public function __construct()
	{
		$this->userDetailModel = new UserDetailModel();
		$this->model = new QuestionModel();
	}

	public function index()
	{
		$answer_type = $this->model::listAnswerType();
		$status = $this->model::listStatus();

		if ($this->request->isAJAX()) {
			$request = $this->request->getGet();
			$draw = (int) $request['draw'];
			$start = (int) $request['start'];
			$length = (int) $request['length'];
			$search = $request['search']['value'];

			$builder = $this->model->builder();
			$builder = $builder->select('question_id, question, question_description, answer_type, question_status');
			// Filtering
			if (!empty($search)) {
				$builder->groupStart()
					->like('question', $search)
					->orLike('question_description', $search)
					->groupEnd();
			}
			// Sorting
			$columns = ['question', 'question_description', 'question_status']; // allow sorting
			if (isset($request['order'][0])) {
				$columnIndex = $request['order'][0]['column'];
				$columnName = $request['columns'][$columnIndex]['data'];
				$columnSortOrder = $request['order'][0]['dir'];

				if (in_array($columnName, $columns)) {
					$builder->orderBy("$columnName", "$columnSortOrder");
				}
			}
			// Count total
			$builderClone = clone $builder;
			$totalRecords = $this->model->countAll();
			$totalFiltered = $builder->countAllResults(false);
			// Pagination
			$builderClone->limit($length, $start);
			$data = $builderClone->get()->getResultArray();
			// Set data
			$rows = [];
			foreach ($data as $index => $each) {
				$rows[] = [
					'no' => $start + $index + 1,
					'question' => $each['question'],
					'question_description' => !empty($each['question_description']) ? $each['question_description'] : '-',
					'answer_type' => $answer_type[$each['answer_type']],
					'question_status' => $status[$each['question_status']],
					'action' => view('admin/question/_action_buttons', ['id' => $each['question_id']])
				];
			}

			return $this->response->setJSON([
				'draw' => intval($draw),
				'recordsTotal' => $totalRecords,
				'recordsFiltered' => $totalFiltered,
				'data' => $rows,
			]);
		}

		return view('admin/question/index', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'title' => 'Daftar Pertanyaan',
		]);
	}

	public function show($id)
	{
		$db = \Config\Database::connect();
		$sql = "SELECT q.*, o.option_name, o.option_description
			FROM question q
			LEFT JOIN question_option o ON (q.question_id = o.question_id)
			WHERE q.question_id = '$id'";
		$query = $db->query($sql);
		$data = $query->getResultArray();

		if (empty($data)) {
			throw PageNotFoundException::forPageNotFound('Data tidak ditemukan');
		}

		return view('admin/question/show', [
			'data' => $data,
			'answer_type' => QuestionModel::listAnswerType(),
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'title' => 'Detail Pertanyaan',
		]);
	}

	public function create()
	{
		return view('admin/question/form', [
			'answer_type' => $this->model::listAnswerType(),
			'has_option' => $this->model::hasOption(),
			'userDetail' => $this->userDetailModel->getUserDetail(),
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
				'question' => trim($post['question']),
				'question_description' => trim($post['question_description']),
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
						'option_description' => trim($description[$key]),
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

	public function edit($id)
	{
		if (!QuestionModel::isDeactivatable($id)) {
			return redirect()->back()->with('error', 'Data tidak dapat diubah.');
		}

		$db = \Config\Database::connect();
		$sql = "SELECT q.*, o.option_name, o.option_description
			FROM question q
			LEFT JOIN question_option o ON (q.question_id = o.question_id)
			WHERE q.question_id = '$id'";
		$query = $db->query($sql);
		$data = $query->getResultArray();

		if (empty($data)) {
			throw PageNotFoundException::forPageNotFound('Data tidak ditemukan');
		}
		// dd($data);

		return view('admin/question/form_edit', [
			'data' => $data,
			'answer_type' => $this->model::listAnswerType(),
			'has_option' => $this->model::hasOption(),
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'title' => 'Tambah Pertanyaan',
		]);
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
