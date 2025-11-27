<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\CommonHelper;
use App\Models\UserDetailModel;
use App\Models\QuestionModel;
use App\Models\QuestionnaireDetailModel;
use App\Models\QuestionnaireModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Ramsey\Uuid\Uuid;

class Questionnaire extends BaseController
{
	protected $userDetailModel;
	protected $model;

	public function __construct()
	{
		$this->userDetailModel = new UserDetailModel();
		$this->model = new QuestionnaireModel();
	}

	public function index()
	{
		$type = $this->model::listType();
		$status = $this->model::listStatus();

		if ($this->request->isAJAX()) {
			$request = $this->request->getGet();
			$draw = (int) $request['draw'];
			$start = (int) $request['start'];
			$length = (int) $request['length'];

			$builder = $this->model->builder();
			$builder = $builder->select('questionnaire_id, created_at, questionnaire_type, questionnaire_status');
			// Sorting
			$columns = ['created_at', 'questionnaire_type', 'questionnaire_status']; // allow sorting
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
					'questionnaire_type' => $type[$each['questionnaire_type']],
					'questionnaire_status' => $status[$each['questionnaire_status']],
					'action' => '<a href="' . url_to("questionnaire.show", $each['questionnaire_id']) . '" class="btn btn-outline-info btn-sm p-2"><i class="fas fa-eye"></i></a>',
				];
			}

			return $this->response->setJSON([
				'draw' => intval($draw),
				'recordsTotal' => $totalRecords,
				'recordsFiltered' => $totalFiltered,
				'data' => $rows,
			]);
		}

		return view('admin/questionnaire/index', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'title' => 'Daftar Kuesioner',
		]);
	}

	public function show($id)
	{
		$db = \Config\Database::connect();
		$data = $db->table('questionnaire h')
			->join('questionnaire_detail d', 'h.questionnaire_id = d.questionnaire_id')
			->join('question q', 'd.question_id = q.question_id')
			->where('h.questionnaire_id', $id)
			->get()
			->getResultArray();

		if (empty($data)) {
			new PageNotFoundException('Data tidak ditemukan');
		}

		return view('admin/questionnaire/show', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'data' => $data,
			'questionnaire_type' => $this->model::listType(),
			'questionnaire_status' => $this->model::listStatus(),
			'has_active' => $this->model::hasActive($data[0]['questionnaire_type']),
			'title' => 'Detail Kuesioner',
		]);
	}

	public function create()
	{
		return view('admin/questionnaire/form', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'type' => $this->model::listType(),
			'question' => QuestionModel::getDropdownList(),
			'title' => 'Tambah Kuesioner',
		]);
	}

	public function store()
	{
		$dbtrans = \Config\Database::connect();
		$dbtrans->transBegin();

		try {
			$post = $this->request->getPost();
			$questionnaire_id = Uuid::uuid7()->toString();

			// Insert into Questionnaire Table
			$data = [
				'questionnaire_id' => $questionnaire_id,
				'questionnaire_type' => (int) $post['questionnaire_type'],
				'questionnaire_status' => QuestionnaireModel::hasActive($post['questionnaire_type']) ?
					$this->model::STAT_INACTIVE : $this->model::STAT_ACTIVE,
			];
			if (!$this->model->insert($data)) {
				throw new \Exception('Gagal menyimpan kuesioner: ' . print_r($this->model->db->error(), true));
			}

			// Insert into Detail Table
			$data = [];
			$detail = new QuestionnaireDetailModel();
			foreach ($post['question_id'] as $each) {
				if (empty($each)) continue;	// Skip if empty
				$data[] = [
					'questionnaire_id' => $questionnaire_id,
					'question_id' => $each,
				];
			}
			if (empty($data)) throw new \Exception('Pertanyaan tidak boleh kosong!');

			if (!$detail->insertBatch($data)) {
				throw new \Exception('Gagal menyimpan kuesioner: ' . print_r($detail->db->error(), true));
			}

			$dbtrans->transCommit();
			return redirect()->to(url_to('questionnaire.index'))->with('success', 'Data berhasil disimpan');
		} catch (\Throwable $e) {
			$dbtrans->transRollback();
			// dd($e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ');
		}
	}

	public function activate($id)
	{
		if ($this->request->getMethod() !== 'POST') {
			return redirect()->back()->with('error', 'Method tidak diizinkan');
		}

		$model = $this->findModel($id);
		if (!$this->model->isActivable($model)) {
			return redirect()->back()->with('error', 'Data tidak dapat diaktifkan.');
		}

		if (!$this->model->update($id, ['questionnaire_status' => QuestionModel::STAT_ACTIVE])) {
			return redirect()->back()
				->with('error', 'Gagal mengaktifkan data <br>' . json_encode($this->model->errors()));
		}
		return redirect()->back()->with('success', 'Data berhasil diaktifkan');
	}

	public function deactivate($id)
	{
		if ($this->request->getMethod() !== 'POST') {
			return redirect()->back()->with('error', 'Method tidak diizinkan');
		}

		$model = $this->findModel($id);
		if (!$this->model->isDeactivatable($model)) {
			return redirect()->back()->with('error', 'Data tidak dapat dinonaktifkan.');
		}

		if (!$this->model->update($id, ['questionnaire_status' => QuestionModel::STAT_INACTIVE])) {
			return redirect()->back()
				->with('error', 'Gagal menonaktifkan data <br>' . json_encode($this->model->errors()));
		}
		return redirect()->back()->with('success', 'Data berhasil dinonaktifkan');
	}

	public function findModel($id)
	{
		$model = $this->model->find($id);
		if (!$model) {
			new PageNotFoundException('Data tidak ditemukan');
		}

		return $model;
	}
}
