<?php

namespace App\Controllers;

use App\Models\MasterTrainingModel;
use App\Models\UserDetailModel;

class MasterTraining extends BaseController
{
	protected $userDetailModel;
	protected $model;

	public function __construct()
	{
		$this->userDetailModel = new UserDetailModel();
		$this->model = new MasterTrainingModel();
	}

	public function index()
	{
		if ($this->request->isAJAX()) {
			$request = $this->request->getGet();
			$draw = (int) $request['draw'];
			$start = (int) $request['start'];
			$length = (int) $request['length'];
			$search = $request['search']['value'];

			$builder = $this->model->builder();
			$builder = $builder->select('id, kategori_pelatihan, jenis_pelatihan, nama_pelatihan, instansi_pengusul, status_aktif');
			// Filtering
			if (!empty($search)) {
				$builder->groupStart()
					->orWhere("kategori_pelatihan ILIKE '%$search%'")
					->orWhere("jenis_pelatihan ILIKE '%$search%'")
					->orWhere("nama_pelatihan ILIKE '%$search%'")
					->orWhere("instansi_pengusul ILIKE '%$search%'")
					->groupEnd();
			}
			// Sorting
			$columns = ['kategori_pelatihan', 'jenis_pelatihan', 'nama_pelatihan', 'instansi_pengusul', 'status_aktif']; // allow sorting
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
					'kategori_pelatihan' => $each['kategori_pelatihan'],
					'jenis_pelatihan' => $each['jenis_pelatihan'],
					'nama_pelatihan' => $each['nama_pelatihan'],
					'instansi_pengusul' => $each['instansi_pengusul'],
					'action' => '<a href="'. url_to("master-training.show", $each['id']) .'" class="btn btn-outline-info btn-sm p-2"><i class="fas fa-eye"></i></a>',
				];
			}

			return $this->response->setJSON([
				'draw' => intval($draw),
				'recordsTotal' => $totalRecords,
				'recordsFiltered' => $totalFiltered,
				'data' => $rows,
			]);
		}

		return view('master_training/index', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'title' => 'Daftar Pelatihan',
		]);
	}
}