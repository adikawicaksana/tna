<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsersManagerModel;
use App\Models\UserDetailModel;
use Exception;
use Ramsey\Uuid\Uuid;

class UsersManager extends BaseController
{
	protected $userDetailModel;
	protected $model;

	public function __construct()
	{
		$this->userDetailModel = new UserDetailModel();
		$this->model = new UsersManagerModel();
	}

	public function index()
	{
		return view('admin/users_manager/index', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'title' => 'Manajemen Pengguna',
		]);
	}

	public function show($id)
	{
		return view('admin/users_manager/show', [
			'userDetail' => $this->userDetailModel->getUserDetail(),
			'title' => 'Detail Manajemen Pengguna',
			'id' => $id,
		]);
	}

	public function store()
	{
		if (empty($_POST['institution_id'])) {
			return redirect()->to(route_to('usersManager.show', $_POST['id']))->with('error', 'Gagal menambah akses. Instansi tidak boleh kosong.');
		}

		$dbtrans = \Config\Database::connect();
		$dbtrans->transBegin();
		try {
			// Fetch all access
			$exist = $this->model->builder()
				->select('_id_institutions')
				->where(['_id_users' => $_POST['id']])
				->get()->getResultArray();
			$exist = array_column($exist, '_id_institutions');

			$data = [];
			foreach ($_POST['institution_id'] as $each) {
				if (in_array($each, $exist)) continue;	// Skip existing data

				$data[] = [
					'id' => Uuid::uuid7()->toString(),
					'_id_users' => $_POST['id'],
					'_id_institutions' => $each,
					'created_at' => date('Y:m:d H:i:s'),
				];
			}

			if (!empty($data)) {
				if (!$this->model->insertBatch($data)) {
					throw new \Exception('Gagal menyimpan pertanyaan: ' . json_encode($this->model->errors()));
				}
			} else {
				throw new \Exception('Tidak ada data baru ditambahkan');
			}

			$dbtrans->transCommit();
			return redirect()->to(route_to('usersManager.show', $_POST['id']))->with('success', 'Data berhasil disimpan');
		} catch (\Throwable $e) {
			$dbtrans->transRollback();
			return redirect()->to(route_to('usersManager.show', $_POST['id']))->with('error', $e->getMessage());
		}
	}

	public function delete() {}

	public function getManager()
	{
		// if ($this->request->isAJAX()) {
		$request = $this->request->getGet();
		$draw = (int) $request['draw'];
		$start = (int) $request['start'];
		$length = (int) $request['length'];
		$search = $request['search']['value'];

		$builder = \Config\Database::connect();
		$builder = $builder->table('users_manager m')
			->select("m._id_users AS user_id, fullname, CONCAT(i.type, ' ', i.name) AS institution_name")
			->join('users_detail d', 'm._id_users = d._id_users')
			->join('master_institutions i', 'm._id_institutions = i.id');
		// Filtering
		if (!empty($search)) {
			$builder->groupStart()
				->orWhere("fullname ILIKE '%$search%'")
				->orWhere("i.name ILIKE '%$search%'")
				->groupEnd();
		}
		if (!empty($_GET['user_id'])) {
			$builder->where('m._id_users', $_GET['user_id']);
		}
		// Sorting
		$columns = ['fullname', 'institution_name']; // allow sorting
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
				'user_id' => $each['user_id'],
				'fullname' => $each['fullname'],
				'institution_name' => $each['institution_name'],
				'action' => '<a href="' . route_to("usersManager.show", $each['user_id']) . '" class="btn btn-outline-info btn-sm p-2"><i class="fas fa-eye"></i></a>',
			];
		}

		return $this->response->setJSON([
			'draw' => intval($draw),
			'recordsTotal' => $totalRecords,
			'recordsFiltered' => $totalFiltered,
			'data' => $rows,
		]);
		// }
	}
}
