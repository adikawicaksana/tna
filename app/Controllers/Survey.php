<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\CommonHelper;
use App\Models\UserDetailModel;
use App\Models\QuestionModel;
use App\Models\QuestionnaireModel;
use App\Models\QuestionOptionModel;
use App\Models\RespondentDetailModel;
use App\Models\SurveyModel;
use App\Models\SurveyDetailModel;
use App\Models\UsersCompetenceModel;
use App\Models\UsersInstitutionsModel;
use Ramsey\Uuid\Uuid;
use Exception;

class Survey extends BaseController
{
	protected $model;
	protected $surveyDetailModel;
	protected $respondentDetailModel;
	protected $questionModel;
    protected $userDetailModel;
	protected $usersInstitutionsModel;

	public function __construct()
	{
        $this->userDetailModel = new UserDetailModel();
		$this->model = new SurveyModel();
		$this->surveyDetailModel = new SurveyDetailModel();
		$this->respondentDetailModel = new RespondentDetailModel();
		$this->questionModel = new QuestionModel();
		$this->usersInstitutionsModel = new UsersInstitutionsModel();
	}

	public function index()
	{
		if ($this->request->isAJAX()) {
			$status = SurveyModel::listStatus();
			$group_type = SurveyModel::listGroupType();

			$request = $this->request->getGet();
			$draw = (int) $request['draw'];
			$start = (int) $request['start'];
			$length = (int) $request['length'];
			$search = $request['search']['value'];

			$builder = \Config\Database::connect();
			$builder = $builder->table('survey s')
				->select('survey_id, s.created_at, group_type, institution_id, fasyankes_name, nonfasyankes_name,
					respondent_id, front_title, fullname, back_title, survey_status, approved_at');
			$builder->select(
					'CASE
						WHEN s.group_type = 1 THEN f.fasyankes_name
						WHEN s.group_type = 2 THEN nf.nonfasyankes_name
						ELSE NULL
					END AS institution_name',
					false
				);
			$builder->join('users_detail u', 's.respondent_id = u._id_users')
				->join('master_fasyankes f', 's.institution_id = f.id AND s.group_type = ' . SurveyModel::GROUP_FASYANKES, 'left')
				->join('master_nonfasyankes nf', 's.institution_id = nf.id AND s.group_type = ' . SurveyModel::GROUP_NONFASYANKES, 'left');

			// Filtering
			if (!empty($search)) {
				$builder->groupStart()
					->like('institution_name', $search)
					->orLike('fullname', $search)
					->groupEnd();
			}
			// Sorting
			$columns = ['created_at', 'group_type', 'institution_name', 'fullname', 'survey_status', 'approved_at']; // allow sorting
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
					'created_at' => CommonHelper::formatDate($each['created_at']),
					'group_type' => $group_type[$each['group_type']],
					'institution_name' => $each['institution_name'],
					'fullname' => $each['fullname'],
					'survey_status' => $status[$each['survey_status']],
					'approved_at' => CommonHelper::formatDate($each['approved_at']),
					'action' => '<a href="'. route_to("survey.show", $each['survey_id']) .'" class="btn btn-outline-info btn-sm p-2"><i class="fas fa-eye"></i></a>',
				];
			}

			return $this->response->setJSON([
				'draw' => intval($draw),
				'recordsTotal' => $totalRecords,
				'recordsFiltered' => $totalFiltered,
				'data' => $rows,
			]);
		}

		return view('survey/index', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'questionnaire_type' => QuestionnaireModel::listType(),
			'title' => 'Daftar Assessment / Penilaian',
		]);
	}

	public function show($id)
	{
		$builder = \Config\Database::connect();
		$data = $builder->table('survey s')
			->select('s.*, fasyankes_type, fasyankes_name, nonfasyankes_name, u.front_title, u.fullname, u.back_title')
			->join('users_detail u', 's.respondent_id = u._id_users')
			->join('master_fasyankes f', 's.institution_id = f.id AND s.group_type = ' . SurveyModel::GROUP_FASYANKES, 'left')
			->join('master_nonfasyankes nf', 's.institution_id = nf.id AND s.group_type = ' . SurveyModel::GROUP_NONFASYANKES, 'left')
			->where(['survey_id' => $id])
			->get()
			->getRow();
		$approval_history = json_decode($data->approval_remark, true);

		return view('survey/show', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data,
			'approval_history' => $approval_history,
			'title' => 'Detail Assessment',
		]);
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

		$options = ['' => '-- Pilih --'];
		if ($type == QuestionnaireModel::TYPE_FASYANKES || $type == QuestionnaireModel::TYPE_INDIVIDUAL_FASYANKES) {
			$labelName = 'Pilih Fasyankes';
			$records = $this->usersInstitutionsModel->getInstitutionsByUser(session()->get('_id_users'));
		} else {
			$labelName = 'Pilih Non Fasyankes';
			$records = $this->usersInstitutionsModel->getInstitutionsByUser(session()->get('_id_users'), 'nonfasyankes');
		}

		foreach ($records as $record) {
			$options[$record['id']] = strtoupper($record['type']) . ' ' . $record['name'];
		}

		$institution = [
			'label' => $labelName,
			'selectName' => 'institution_id',
			'options' => $options,
		];

		return view('survey/form', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'question' => $question,
			'source' => $source,
			'title' => 'Formulir Assessment / Penilaian',
			'institution' => $institution
		]);
	}

	public function store()
	{
		$dbtrans = \Config\Database::connect();
		$dbtrans->transBegin();
		try {
			$post = $this->request->getPost();
			$id = Uuid::uuid7()->toString();

			$user_id = session()->get('_id_users');
			$user = $this->userDetailModel->getUserDetail();

			// Insert into Survey Table
			$data = [
				'survey_id' => $id,
				'questionnaire_id' => $post['questionnaire_id'],
				'institution_id' => (isset($post['fasyankes'])) ? $post['fasyankes'] : $post['nonfasyankes'],
				'group_type' => (isset($post['fasyankes'])) ? SurveyModel::GROUP_FASYANKES : SurveyModel::GROUP_NONFASYANKES,
				'survey_status' => SurveyModel::STAT_ACTIVE,
				'respondent_id' => $user_id,
				'jenjang_pendidikan' => $user['jenjang_pendidikan'],
				'jurusan_profesi' => $user['jurusan_profesi'],
				'created_at' => date('Y-m-d H:i:s'),
				'approved_by' => in_array($post['type'], [QuestionnaireModel::TYPE_FASYANKES, QuestionnaireModel::TYPE_INSTITUTE]) ? 0 : NULL,
				'approval_remark' => 'Disetujui oleh sistem',
				'approved_at' => in_array($post['type'], [QuestionnaireModel::TYPE_FASYANKES, QuestionnaireModel::TYPE_INSTITUTE]) ? date('Y-m-d H:i:s') : NULL,
			];
			if (!$this->model->insert($data)) {
				throw new \Exception('Gagal menyimpan survei: ' . json_encode($this->model->db->error()));
			}

			// Insert into Survey Detail Table
			$data = [];
			foreach ($post as $key => $value) {
				if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $key)) {
					$data[] = [
						'detail_id' => Uuid::uuid7()->toString(),
						'survey_id' => $id,
						'question_id' => $key,
						'answer' => $value ?? '',
					];
				}
			}
			if (!$this->surveyDetailModel->insertBatch($data)) {
				// echo $this->surveyDetailModel->db->getLastQuery();die;
				throw new \Exception('Gagal menyimpan detail survei: ' . json_encode($this->surveyDetailModel->db->error()));
			}

			// Insert into Respondent Detail Table
			$data = [];
			foreach ((new UsersCompetenceModel())->getCompetence($user_id) as $each) {
				$data[] = [
					'detail_id' => Uuid::uuid7()->toString(),
					'survey_id' => $id,
					'competence_id' => $each['id'],
				];
			}
			if (!$this->respondentDetailModel->insertBatch($data)) {
				throw new \Exception('Gagal menyimpan detail responden: ' . json_encode($this->respondentDetailModel->db->error()));
			}

			$dbtrans->transCommit();
			return redirect()->to(route_to('survey.index'))->with('success', 'Data berhasil disimpan');
		} catch (\Throwable $e) {
			$dbtrans->transRollback();
			return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data<br>' . $e->getMessage());
		}
	}

	public function edit($id)
	{
		$model = $this->model->findOne($id);
		if (!$model->isEditable($id)) {
			return redirect()->back()->with('error', 'Data tidak dapat diubah.');
		}

		return view('survey/form', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'title' => 'Ubah Hasil Assessment / Penilaian',
		]);
	}

	public function update()
	{
		if ($this->request->getMethod() !== 'POST') {
			return redirect()->back()->with('error', 'Method tidak diizinkan');
		}

		$post = $this->request->getPost();
		$data = $this->model->findOne($post['survey_id']);
		dd($data);
		if (!$this->model->isEditable($data['id'])) {
			return redirect()->back()->with('error', 'Data tidak dapat diubah.');
		}


	}
}
