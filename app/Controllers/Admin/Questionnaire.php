<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuestionModel;
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
		]);
	}

	public function store() {}

	public function update($id)
	{
		$data = $this->model->findOne($id);
		return view('admin/questionnaire/form', $data);
	}
}
