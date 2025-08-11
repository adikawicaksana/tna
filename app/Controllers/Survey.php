<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\QuestionModel;
use App\Models\QuestionnaireModel;
use App\Models\QuestionOptionModel;
use App\Models\SurveyModel;
use Exception;

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
			'questionnaire_type' => QuestionnaireModel::listType(),
			'title' => 'Daftar Survei',
		]);
	}

	public function show($id)
	{
		return view('survey/show', ['id' => $id]);
	}

	public function create($type)
	{
		$question = QuestionnaireModel::getData([
			'questionnaire_type' => $type,
			'questionnaire_status' => QuestionnaireModel::STAT_ACTIVE,
		]);

		// Get id and answer options
		$option = [];
		$ids = [];
		foreach ($question as $each) {
			$has_option = in_array($each['answer_type'], QuestionModel::hasOption());
			if (!$has_option) continue;

			// Check if data has existing reference
			$source_reference = $each['source_reference'];
			if (empty($source_reference)) {
				$ids[] = $each['question_id'];
			} else {
				// Extract class, method, and parameter menggunakan regex
				preg_match('/(\w+)::(\w+)\((\d+)\)/', $source_reference, $matches);
				if ($matches) {
					$class = str_replace(' ', '', 'App\Models\ ' . $matches[1]);
					$method = $matches[2];
					$param = $matches[3];

					if (class_exists($class) && method_exists($class, $method)) {
						$option[$each['question_id']] = $class::$method($param);
					} else {
						new \Exception('Invalid source reference');
					}
				} else {
					new \Exception('Invalid source reference');
				}
			}
		}
		// Fetch option data
		if (!empty($ids)) {
			$temp2 = QuestionOptionModel::getData($ids);
			foreach ($temp2 as $each) {
				$questionId = $each['question_id'];
				$option[$questionId][] = $each;
			}
		}

		return view('survey/form', [
			'question' => $question,
			'option' => $option,
			'title' => 'Formulir Survei',
		]);
	}

	public function store() {}

	public function update($id)
	{
		$data = $this->model->findOne($id);
		return view('survey/form', $data);
	}
}
