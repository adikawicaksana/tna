<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\CommonHelper;
use App\Models\UserDetailModel;
use App\Models\QuestionModel;
use App\Models\QuestionnaireModel;
use App\Models\QuestionOptionModel;
use App\Models\SurveyModel;
use App\Models\UsersFasyankesModel;
use App\Models\UsersNonFasyankesModel;
use Exception;

class Survey extends BaseController
{
	protected $model;
    protected $userDetailModel;
	protected $usersFasyankesModel;
    protected $usersNonFasyankesModel;

	public function __construct()
	{
        $this->userDetailModel = new UserDetailModel();
		$this->model = new SurveyModel();
		$this->usersFasyankesModel = new UsersFasyankesModel();
        $this->usersNonFasyankesModel = new UsersNonFasyankesModel();
	}

	public function index()
	{
		$data = $this->model
			->findAll();

		return view('survey/index', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
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
		$source = [];
		$ids = [];
		foreach ($question as $each) {
			$has_option = in_array($each['answer_type'], QuestionModel::hasOption());
			if (!$has_option) continue;

			// Check if data has existing reference
			$source_reference = $each['source_reference'];
			if (empty($source_reference)) {
				$ids[] = $each['question_id'];
			} else if (CommonHelper::isRouteExists($source_reference)) {
				$url = url_to($source_reference);
				$response = file_get_contents($url);
				foreach (json_decode($response) as $res) {
					$source[$each['question_id']][] = [
						'question_id' => $res->id,
						'option_name' => $res->text,
					];
				}
			}
		}
		// Fetch option data
		if (!empty($ids)) {
			$temp2 = QuestionOptionModel::getData($ids);
			foreach ($temp2 as $each) {
				$questionId = $each['question_id'];
				$source[$questionId][] = $each;
			}
		}

        $session = session();
		$options = ['' => '-- Pilih --'];

		if ($type == 2 || $type == 4) {
			if ($type == 2) {
				$labelName = 'Pilih Fasyankes';
				$selectName = 'fasyankes';
				$model = $this->usersFasyankesModel;
				$joinTable = 'master_fasyankes';
				$joinCondition = 'master_fasyankes.id = users_fasyankes._id_master_fasyankes';
				$formatOption = fn($item) => strtoupper($item['fasyankes_type']) . ' ' . $item['fasyankes_name'];
			} else {
				$labelName = 'Pilih Non Fasyankes';
				$selectName = 'non-fasyankes';
				$model = $this->usersNonFasyankesModel;
				$joinTable = 'master_nonfasyankes';
				$joinCondition = 'master_nonfasyankes.id = users_nonfasyankes._id_master_nonfasyankes';
				$formatOption = fn($item) => $item['nonfasyankes_name'];
			}

			$records = $model
				->join($joinTable, $joinCondition, 'left')
				->where('_id_users', $session->get('_id_users'))
				->where('status', 'true')
				->findAll();

			foreach ($records as $record) {
				$options[$record['id']] = $formatOption($record);
			}
		} else {
			$labelName = '';
			$selectName = '';
		}

		$fasyankes_nonfasyankes = [
			'label' => $labelName,
			'selectName' => $selectName,
			'options' => $options,
		];


		return view('survey/form', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'question' => $question,
			'source' => $source,
			'title' => 'Formulir Survei',
			'fasyankes_nonfasyankes' => $fasyankes_nonfasyankes
		]);
	}

	public function store() {}

	public function update($id)
	{
		$data = $this->model->findOne($id);
		return view('survey/form', $data);
	}
}
