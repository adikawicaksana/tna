<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SurveyModel;

class Survey extends BaseController
{
	protected $model;

	public function __construct()
	{
		$this->model = new SurveyModel();
	}

	public function index()
	{
		$data = $this->model
			->findAll();
		return view('survey/index', [
			'data' => $data,
		]);
	}

	public function show($id)
	{
		return view('survey/show', ['id' => $id]);
	}

	public function create()
	{
		return view('survey/form', []);
	}

	public function store() {}

	public function update($id)
	{
		$data = $this->model->findOne($id);
		return view('survey/form', $data);
	}
}
