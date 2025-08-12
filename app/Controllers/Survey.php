<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\QuestionModel;
use App\Models\QuestionnaireModel;
use App\Models\QuestionOptionModel;
use App\Models\SurveyModel;
use App\Models\UsersFasyankesModel;
use App\Models\UsersNonFasyankesModel;
use App\Models\UserModel;
use Exception;

class Survey extends BaseController
{
	protected $model;
	protected $userModel;
    protected $userData = null;
	protected $usersFasyankesModel;
    protected $usersNonFasyankesModel;

	public function __construct()
	{
		$this->model = new SurveyModel();
		$this->userModel = new UserModel();
		$this->usersFasyankesModel = new UsersFasyankesModel();
        $this->usersNonFasyankesModel = new UsersNonFasyankesModel();
	}

	protected function getUserData()
    {
        if ($this->userData === null) {
            $email = session()->get('email');
            if (!$email) {
                return null;
            }

            $this->userData = $this->userModel
                ->select('users.*, users_detail.*, master_area_provinces.name as users_provinsi, master_area_regencies.name as users_kabkota, master_area_districts.name as users_kecamatan, master_area_villages.name as users_kelurahan')
                ->join('users_detail', 'users.email = users_detail.email', 'left')
                ->join('master_area_provinces', 'master_area_provinces.id = users_detail.users_provinces', 'left')
                ->join('master_area_regencies', 'master_area_regencies.id = users_detail.users_regencies', 'left')
                ->join('master_area_districts', 'master_area_districts.id = users_detail.users_districts', 'left')
                ->join('master_area_villages', 'master_area_villages.id = users_detail.users_villages', 'left')
                ->where('users.email', $email)
                ->first();
        }

        return $this->userData;
    }

	public function index()
	{ 
		$data = $this->model
			->findAll();
			
		return view('survey/index', [
			'userData' => $this->getUserData(),
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

        $session = session();
		$options = ['' => '-- Pilih --'];

		if ($type == 2 || $type == 4) {
			if ($type == 2) {
				$labelName = 'Pilih Fasyankes';
				$selectName = 'fasyankes';
				$model = $this->usersFasyankesModel;
				$joinTable = 'master_fasyankes';
				$joinCondition = 'master_fasyankes.fasyankes_code = users_fasyankes.fasyankes_code';
				$formatOption = fn($item) => strtoupper($item['fasyankes_type']) . ' ' . $item['fasyankes_name'];
			} else {
				$labelName = 'Pilih Non Fasyankes';
				$selectName = 'non-fasyankes';
				$model = $this->usersNonFasyankesModel;
				$joinTable = 'master_nonfasyankes';
				$joinCondition = 'master_nonfasyankes.id = users_nonfasyankes.nonfasyankes_id';
				$formatOption = fn($item) => $item['nonfasyankes_name'];
			}

			$records = $model
				->join($joinTable, $joinCondition, 'left')
				->where('email', $session->get('email'))
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
			'userData' => $this->getUserData(),
			'question' => $question,
			'option' => $option,
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
