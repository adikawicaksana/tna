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
use App\Models\UserModel;
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
			$request = $this->request->getGet();
			$draw = (int) $request['draw'];
			$start = (int) $request['start'];
			$length = (int) $request['length'];
			$search = $request['search']['value'];

			$builder = \Config\Database::connect();
			$builder = $builder->table('survey s')
				->select('survey_id, s.created_at, institution_id, i.category AS institution_category,
					respondent_id, front_title, fullname, back_title, survey_status, approved_at');
			$builder->select("CONCAT(i.type, ' ', i.name) AS institution_name", false)
				->join('users_detail u', 's.respondent_id = u._id_users')
				->join('master_institutions i', 's.institution_id = i.id');

			// Filter by user access
			$user_id = session()->get('_id_users');
			if (session()->get('user_role') == UserModel::ROLE_USER) {
				$user = (new UserModel())->find($user_id);
				$p_institusi = json_decode($user['p_institusi']) ?? [];
				$p_kabkota = json_decode($user['p_kabkota']) ?? [];
				$p_provinsi = json_decode($user['p_provinsi']) ?? [];
				$p_access = array_merge($p_institusi, $p_kabkota, $p_provinsi);

				if (!empty($p_access)) {
					$builder->groupStart()
						->whereIn('s.institution_id', $p_access)
						->orWhere('respondent_id', $user_id)
						->groupEnd();
				} else {
					$builder->where('respondent_id', $user_id);
				}
			}

			// Filtering
			if (!empty($search)) {
				$builder->groupStart()
					->like('institution_name', $search)
					->orLike('fullname', $search)
					->groupEnd();
			}
			// Sorting
			$columns = ['created_at', 'institution_category', 'institution_name', 'fullname', 'survey_status', 'approved_at']; // allow sorting
			if (isset($request['order'][0])) {
				$columnIndex = $request['order'][0]['column'];
				$columnName = $request['columns'][$columnIndex]['data'];
				$columnSortOrder = $request['order'][0]['dir'];

				if (in_array($columnName, $columns)) {
					$builder->orderBy("$columnName", "$columnSortOrder");
				}
			}
			// echo $builder->getCompiledSelect();die;
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
					'institution_category' => $each['institution_category'],
					'institution_name' => ucwords($each['institution_name']),
					'fullname' => $each['fullname'],
					'survey_status' => $status[$each['survey_status']],
					'approved_at' => !empty($each['approved_at']) ? CommonHelper::formatDate($each['approved_at']) : '-',
					'action' => '<a href="' . route_to("survey.show", $each['survey_id']) . '" class="btn btn-outline-info btn-sm p-2"><i class="fas fa-eye"></i></a>',
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
			'questionnaire_type' => QuestionnaireModel::listType('individu'),
			'title' => 'Daftar Assessment / Penilaian',
		]);
	}

	public function show($id)
	{
		$builder = \Config\Database::connect();
		// Fetch survey header
		$data = $builder->table('survey s')
			->select('s.*, questionnaire_type, i.category AS institution_group, i.type AS institution_type, i.name AS institution_name, u.front_title, u.fullname, u.back_title')
			->join('users_detail u', 's.respondent_id = u._id_users')
			->join('master_institutions i', 's.institution_id = i.id')
			->join('questionnaire q', 's.questionnaire_id = q.questionnaire_id')
			->where(['survey_id' => $id])
			->get()
			->getRow();
		$approval_history = json_decode($data->approval_remark, true);
		if (!empty($approval_history)) {
			$user = ($this->userDetailModel->getUserDetail($approval_history['user_id']));
			$approval_history['user_name'] = $user['front_title'] . ' ' . $user['fullname'];
			$approval_history['user_name'] .= (!empty($user['back_title'])) ? ", {$user['back_title']}" : '';
		}
		// Fetch competence
		$competence = $this->respondentDetailModel->getRespondentCompetence($id);
		// Fetch survey detail
		$detail = $this->surveyDetailModel->getDetail($id);
		$answer = [];
		foreach ($detail as $key => $each) {
			$temp = json_decode($each['answer']);
			$answer[$key] = (array) $temp;
		}

		return view('survey/show', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data,
			'approval_history' => $approval_history,
			'detail' => $detail,
			'answer' => $answer,
			'competence' => $competence,
			'is_institution' => in_array($data->questionnaire_type, [QuestionnaireModel::TYPE_FASYANKES, QuestionnaireModel::TYPE_INSTITUTE]),
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
			'institution' => $institution,
			'type' => $type,
			'months' => CommonHelper::months(),
			'years' => CommonHelper::years(date('Y')),
			'model' => [],
			'url' => 'survey.store',
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
			$datetime = date('Y-m-d H:i:s');
			$is_institution = in_array($post['type'], [QuestionnaireModel::TYPE_FASYANKES, QuestionnaireModel::TYPE_INSTITUTE]);

			// Insert into Survey Table
			$data = [
				'survey_id' => $id,
				'questionnaire_id' => $post['questionnaire_id'],
				'institution_id' => $post['institution_id'],
				// 'group_type' => (isset($post['fasyankes'])) ? SurveyModel::GROUP_FASYANKES : SurveyModel::GROUP_NONFASYANKES,
				'survey_status' => SurveyModel::STAT_ACTIVE,
				'respondent_id' => $user_id,
				'jenjang_pendidikan' => $user['jenjang_pendidikan'],
				'jurusan_profesi' => $user['jurusan_profesi'],
				'created_at' => date('Y-m-d H:i:s'),
				'approved_by' => $is_institution ? $user_id : NULL,
				'approval_remark' => $is_institution ? 'Disetujui oleh sistem' : NULL,
				'approved_at' => $is_institution ? date('Y-m-d H:i:s') : NULL,
			];
			if (!$this->model->insert($data)) {
				throw new \Exception('Gagal menyimpan assessment / penilaian: ' . json_encode($this->model->db->error()));
			}

			// Insert into Survey Detail Table
			$data = [];
			foreach ($post['question'] as $key => $value) {
				$value = is_array($value) ? implode('; ', $value) : $value;
				$answer = [$datetime => $value ?? ''];
				$data[] = [
					'detail_id' => Uuid::uuid7()->toString(),
					'survey_id' => $id,
					'question_id' => $key,
					'answer' => json_encode($answer),
				];
			}
			if (!$this->surveyDetailModel->insertBatch($data)) {
				// echo $this->surveyDetailModel->db->getLastQuery();die;
				throw new \Exception('Gagal menyimpan detail assessment / penilaian: ' . json_encode($this->surveyDetailModel->db->error()));
			}

			// Insert into Respondent Detail Table
			if (!$is_institution) {
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
			}

			$dbtrans->transCommit();
			return redirect()->to(route_to('survey.index'))->with('success', 'Data berhasil disimpan');
		} catch (\Throwable $e) {
			$dbtrans->transRollback();
			return redirect()->back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function edit($id)
	{
		if (!$this->model->isEditable($id)) {
			return redirect()->back()->with('error', 'Data tidak dapat diubah.');
		}

		$model = $this->model->find($id);
		$question = $this->surveyDetailModel->getDetail($id);

		// Get id and answer options
		$source = [];
		$ids = [];
		$answer = [];
		foreach ($question as $each) {
			// Fetch answer
			$temp = json_decode($each['answer'], true);
			$answer[$each['question_id']] = $temp[max(array_keys($temp))];
			// Fetch option list
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
		$type = $question[0]['questionnaire_type'];
		if (in_array($type, [QuestionnaireModel::TYPE_FASYANKES, QuestionnaireModel::TYPE_INDIVIDUAL_FASYANKES])) {
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
			'title' => 'Ubah Hasil Assessment / Penilaian',
			'model' => $model,
			'question' => $question,
			'source' => $source,
			'answer' => $answer,
			'institution' => $institution,
			'type' => $type,
			'url' => 'survey.update',
		]);
	}

	public function update()
	{
		$post = $this->request->getPost();
		$survey_id = $post['survey_id'];
		$user_id = session()->get('_id_users');
		$datetime = date('Y-m-d H:i:s');

		if ($this->request->getMethod() !== 'POST') {
			return redirect()->back()->with('error', 'Method tidak diizinkan');
		}
		if (!$this->model->isEditable($survey_id)) {
			return redirect()->back()->with('error', 'Data tidak dapat diubah.');
		}

		$dbtrans = \Config\Database::connect();
		$dbtrans->transBegin();
		try {
			// Insert into Survey Detail Table
			$survey_detail = $this->surveyDetailModel->where(['survey_id' => $survey_id])->findAll();
			foreach ($survey_detail as $d) {
				$temp = json_decode($d['answer'], true);
				$temp[$datetime] = $post['question'][$d['question_id']];
				if (!$this->surveyDetailModel->update($d['detail_id'], ['answer' => json_encode($temp)])) {
					throw new \Exception('Gagal menyimpan detail assessment / penilaian: ' . json_encode($this->surveyDetailModel->db->error()));
				}
			}

			// Remove old data and insert new data into Respondent Detail Table
			$data = [];
			$this->respondentDetailModel->where(['survey_id' => $survey_id])->delete();
			foreach ((new UsersCompetenceModel())->getCompetence($user_id) as $each) {
				$data[] = [
					'detail_id' => Uuid::uuid7()->toString(),
					'survey_id' => $survey_id,
					'competence_id' => $each['id'],
				];
			}
			if (!$this->respondentDetailModel->insertBatch($data)) {
				throw new \Exception('Gagal menyimpan detail responden: ' . json_encode($this->respondentDetailModel->db->error()));
			}

			// Update survey status
			if (!$this->model->update($survey_id, ['survey_status' => SurveyModel::STAT_OPEN])) {
				throw new \Exception('Gagal memperbarui status assessment / penilaian: ' . json_encode($this->model->db->error()));
			}

			$dbtrans->transCommit();
			return redirect()->to(route_to('survey.index'))->with('success', 'Data berhasil disimpan');
		} catch (\Throwable $e) {
			$dbtrans->transRollback();
			return redirect()->back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function approval($id)
	{
		if (!$this->model->isApprovable($id)) {
			return redirect()->back()->with('error', 'Data tidak dapat disetujui.');
		}

		$builder = \Config\Database::connect();
		// Fetch survey header
		$data = $builder->table('survey s')
			->select('s.*, questionnaire_type, i.category AS institution_group, i.type AS institution_type, i.name AS institution_name, u.front_title, u.fullname, u.back_title')
			->join('users_detail u', 's.respondent_id = u._id_users')
			->join('master_institutions i', 's.institution_id = i.id')
			->join('questionnaire q', 's.questionnaire_id = q.questionnaire_id')
			->where(['survey_id' => $id])
			->get()
			->getRow();
		$approval_history = json_decode($data->approval_remark, true);
		$user = ($this->userDetailModel->getUserDetail($approval_history['user_id']));
		$approval_history['user_name'] = $user['front_title'] . ' ' . $user['fullname'];
		$approval_history['user_name'] .= (!empty($user['back_title'])) ? ", {$user['back_title']}" : '';
		// Fetch competence
		$competence = $this->respondentDetailModel->getRespondentCompetence($id);
		// Fetch survey detail
		$detail = $this->surveyDetailModel->getDetail($id);
		$answer = [];
		$latest_answer = [];
		foreach ($detail as $key => $each) {
			$temp = json_decode($each['answer'], true);
			$answer[$key] = $temp;
			$latest_answer[$each['question_id']] = $temp[max(array_keys($temp))];
		}

		// Get id and answer options
		$source = [];
		$ids = [];
		foreach ($detail as $each) {
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

		return view('survey/approval', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data,
			'approval_history' => $approval_history,
			'detail' => $detail,
			'answer' => $answer,
			'latest_answer' => $latest_answer,
			'source' => $source,
			'competence' => $competence,
			'title' => 'Formulir Persetujuan',
		]);
	}

	public function postApproval()
	{
		$post = $this->request->getPost();
		$survey_id = $post['survey_id'];
		$datetime = date('Y-m-d H:i:s');

		if ($this->request->getMethod() !== 'POST') {
			return redirect()->back()->with('error', 'Method tidak diizinkan');
		}
		if (!$this->model->isApprovable($survey_id)) {
			return redirect()->back()->with('error', 'Tidak dapat mengubah status persetujuan');
		}
		if (($post['approval_status'] == SurveyModel::STAT_DECLINED) && (empty($post['approval_remark']))) {
			return redirect()->back()->with('error', 'Catatan tidak boleh kosong');
		}

		$dbtrans = \Config\Database::connect();
		$dbtrans->transBegin();
		try {
			// Update Survey data
			$data = [];
			$data['survey_status'] = $post['approval_status'];
			$data['approval_remark'] = json_encode([
				'datetime' => $datetime,
				'user_id' => session()->get('_id_users'),
				'remark' => $post['approval_remark'],
			]);

			// If assessment is approved, save the approval record and approved answer
			if ($post['approval_status'] == SurveyModel::STAT_ACTIVE) {
				$data['approved_by'] = session()->get('_id_users');
				$data['approved_at'] = $datetime;

				// Save survey detail (approved answer)
				foreach ($post['question'] as $question_id => $value) {
					$builder = $this->surveyDetailModel->builder();
					$surveyDetailModel = $builder->where(['survey_id' => $survey_id, 'question_id' => $question_id])
						->set(['approved_answer' => $value])
						->update();

					if (!$surveyDetailModel) {
						throw new \Exception('Gagal menyimpan detail persetujuan: ' . json_encode($this->model->db->error()));
					}
				}
			}

			// Save record
			if (!$this->model->update($survey_id, $data)) {
				throw new \Exception('Gagal menyimpan persetujuan: ' . json_encode($this->model->db->error()));
			}

			$dbtrans->transCommit();
			return redirect()->to(route_to('survey.show', $survey_id))->with('success', 'Data berhasil disimpan');
		} catch (\Throwable $e) {
			$dbtrans->transRollback();
			return redirect()->back()->withInput()->with('error', $e->getMessage());
		}
	}
}
