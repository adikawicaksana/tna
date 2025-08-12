<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\QuestionModel;
use App\Models\QuestionnaireDetailModel;
use App\Models\QuestionnaireModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Questionnaire extends BaseController
{
    protected $userData = null;
	protected $model;

	public function __construct()
	{
		$this->userModel = new UserModel();
		$this->model = new QuestionnaireModel();
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
			->orderBy('questionnaire_status', 'DESC')
			->orderBy('created_at', 'DESC')
			->findAll();
		return view('admin/questionnaire/index', [
			'userData'=> $this->getUserData(),
			'data' => $data,
			'type' => $this->model::listType(),
			'status' => $this->model::listStatus(),
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
			'userData'=> $this->getUserData(),
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
			'userData'=> $this->getUserData(),
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

			// Insert into Questionnaire Table
			$data = [
				'questionnaire_type' => $post['questionnaire_type'],
				'questionnaire_status' => QuestionnaireModel::hasActive($post['questionnaire_type']) ?
					$this->model::STAT_INACTIVE : $this->model::STAT_ACTIVE,
			];
			if (!$this->model->save($data)) {
				throw new \Exception('Gagal menyimpan kuesioner: ' . print_r($this->model->errors(), true));
			}

			// Insert into Detail Table
			$id = $this->model->getInsertID();
			$data = [];
			$detail = new QuestionnaireDetailModel();
			foreach ($post['question_id'] as $each) {
				if (empty($each)) continue;	// Skip if empty
				$data[] = [
					'questionnaire_id' => $id,
					'question_id' => $each,
				];
			}
			if (empty($data)) throw new \Exception('Pertanyaan tidak boleh kosong!');

			if (!$detail->insertBatch($data)) {
				throw new \Exception('Gagal menyimpan kuesioner: ' . print_r($detail->errors(), true));
			}

			$dbtrans->transCommit();
			return redirect()->to(route_to('questionnaire.index'))->with('success', 'Data berhasil disimpan');
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
