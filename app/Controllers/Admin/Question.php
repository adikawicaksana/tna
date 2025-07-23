<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuestionModel;
use App\Models\QuestionOptionModel;

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
		]);
	}

	public function show($id)
	{
		return view('admin/question/show', ['id' => $id]);
	}

	public function create()
	{
		return view('admin/question/form', [
			'answer_type' => $this->model::listAnswerType(),
			'has_option' => $this->model::hasOption(),
		]);
	}

	public function store()
	{
		$dbtrans = \Config\Database::connect();
		$dbtrans->transBegin();
		try {
			$post = $this->request->getPost();
			// Insert into Question Table
			$data = [
				'question' => $post['question'],
				'question_description' => $post['question_description'],
				'answer_type' => $post['answer_type'],
				'question_status' => $this->model::STAT_ACTIVE,
			];
			$this->model->save($data);
			$id = $this->model->getInsertID();

			// Insert into Option Table
			if ($post['answer_type'] == QuestionModel::TYPE_MULTIPLE_CHOICE) {
				$data = [];
				$option = new QuestionOptionModel();
				$description = $post['option_description[]'];
				foreach ($post['option_name[]'] as $key => $each) {
					$data[] = [
						'question_id' => $id,
						'option_name' => $each,
						'option_description' => $description[$key],
					];
				}
				$option->insertBatch($data);
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
}
