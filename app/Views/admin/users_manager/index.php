<?= $this->extend('layout/main') ?>

<?= $this->section('content'); ?>
<div class="container">
	<h3><?= $title ?></h3>
	<div class="card">
		<div class="card-header">
			<h5>Form Tambah Akses</h5>
		</div>
		<div class="card-body">
			<?php if (session()->getFlashdata('error')): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= session()->getFlashdata('error') ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php elseif (session()->getFlashdata('success')): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<?= session()->getFlashdata('success') ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<form id="add-access" method="POST" action="<?= url_to('usersManager.store') ?>">
				<div class="row mb-6">
					<label class="col-sm-2 col-form-label" for="basic-default-name">Pengguna</label>
					<div class="col-sm-10">
						<select name="user_id[]" id="user_id" class="form-control" multiple="multiple">
							<option value="">Pilih Pengguna</option>
						</select>
					</div>
				</div>
				<div class="row mb-6">
					<label class="col-sm-2 col-form-label" for="basic-default-name">Instansi</label>
					<div class="col-sm-10">
						<select name="institution_id[]" id="institution_id" class="form-control" multiple="multiple">
							<option value="">Pilih Instansi</option>
						</select>
					</div>
				</div>
				<div class="mb-6 text-end">
					<button type="submit" class="btn btn-sm btn-primary">Tambah</button>
				</div>
			</form>
		</div>
	</div>
	<br>
	<div class="card">
		<div class="card-header">
			<h5><?= $title ?></h5>
		</div>
		<div class="card-body">
			<table class="table table-sm table-bordered table-hover w-100 align-top" id="table-list">
				<thead>
					<tr>
						<th class="text-center" width="5%">No</th>
						<th>Pengguna</th>
						<th>Instansi</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<?= $this->section('scripts') ?>
<script>
	const base_url = "<?= base_url() ?>";
	$(document).ready(function() {
		initTable();
		initSelect2('#user_id', 'Pilih Pengguna', `${base_url}/listUser`);
		initSelect2('#institution_id', 'Pilih Instansi', `${base_url}/listInstitution`);

		$('#add-access').submit(function(e) {
			e.preventDefault();
			// Check if user or institution is empty
			let user_id = $('#user_id').val();
			let institution_id = $('#institution_id').val();
			if (user_id.length == 0 || institution_id.length == 0) {
				Swal.fire({icon: 'warning', title: 'Gagal', text: 'Pengguna dan Instansi tidak boleh kosong'});
				return false;
			}

			// Confirmation and submit form
			Swal.fire({
				icon: 'question',
				title: 'Yakin?',
				text: 'Apakah Anda yakin akan menambahkan akses?',
				showCancelButton: true,
				confirmButtonText: 'Ya',
				cancelButtonText: 'Tidak',
			}).then((result) => {
				if (result.isConfirmed) {
					let url = $(this).attr('action');
					let data = $(this).serialize();
					$.ajax({
						url: url,
						method: 'POST',
						data: data,
						dataType: 'json',
						success: function(response) {
							if (response.status) {
								initSelect2('#user_id', 'Pilih Pengguna', `${base_url}/listUser`);
								initSelect2('#institution_id', 'Pilih Instansi', `${base_url}/listInstitution`);
								initTable();
							} else {
								Swal.fire('Gagal!', response.message, 'error');
							}
						},
						error: function(xhr, status, error) {
							Swal.fire('Gagal!', 'Terjadi kesalahan: ' + error, 'error');
						}
					});
				}
			})

			return false;
		})
	});

	$(document).on('click', '.btn-delete', function() {
		const user_id = $(this).data('user_id');
		const institution_id = $(this).data('institution_id');

		// Confirmation and delete data
		Swal.fire({
			icon: 'question',
			title: 'Yakin?',
			text: 'Apakah Anda yakin akan menghapus akses ke instansi ini?',
			showCancelButton: true,
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak',
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: "<?= url_to('usersManager.delete') ?>",
					type: "POST",
					data: {
						user_id: user_id,
						institution_id: institution_id,
					},
					success: function(response) {
						if (response.success) {
							initTable();
						} else {
							Swal.fire('Gagal!', response.message, 'error');
						}
					}
				});
			}
		})
	});

	function initTable() {
		if ($.fn.DataTable.isDataTable('#table-list')) {
			$('#table-list').DataTable().clear().destroy();
		}

		$('#table-list').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: "<?= url_to('usersManager.getManager') ?>",
				type: "GET",
			},
			columns: [{
					data: "no",
					name: "no",
					orderable: false,
					searchable: false
				},
				{
					data: "fullname"
				},
				{
					data: "institution_name"
				},
				{
					data: "user_id",
					render: function(data, type, row) {
						return renderAction(row.user_id, row.institution_id);
					},
					orderable: false,
					searchable: false
				}

			],
			columnDefs: [{
				targets: [0, 3],
				className: 'text-center',
			}],
		});
	}

	function renderAction(userId, institutionId) {
		return `<button class="btn btn-outline-info btn-sm btn-delete p-2"
			data-user_id="${userId}" data-institution_id="${institutionId}"><i class="fas fa-times"></i></button>`;
	}

	function initSelect2(selector, placeholder, url) {
		$(selector).select2({
			placeholder: placeholder,
			allowClear: true,
			width: '100%',
			ajax: {
				url: url,
				dataType: 'json',
				delay: 250,
				data: params => ({
					term: params.term,
				}),
				processResults: response => {
					const data = response.data.map(item => ({
						id: item.id,
						text: item.name
					}));

					return {
						results: data
					}
				},
				cache: true,
			},
			minimumInputLength: 2,
		});
	}
</script>
<?= $this->endSection(); ?>
<?= $this->endSection(); ?>