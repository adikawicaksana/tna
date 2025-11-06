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

			<form id="add-institution" method="POST" action="<?= route_to('usersManager.store') ?>">
				<input type="hidden" name="id" value="<?= $id ?>">
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
		initSelect2();

		$('#add-institution').submit(function(e) {
			e.preventDefault();
			// Check if institution is empty
			let institution_id = $('#institution_id').val();
			if (institution_id.length == 0) {
				Swal.fire({icon: 'warning', title: 'Gagal', text: 'Instansi tidak boleh kosong'});
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
					this.submit();
				}
			})

			return false;
		})
	});

	function initTable() {
		$('#table-list').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: "<?= route_to('usersManager.getManager') ?>",
				type: "GET",
				data: {
					user_id: '<?= $id ?>',
				},
			},
			columns: [{
					data: "no",
					name: "no",
					orderable: false,
					searchable: false
				},
				{
					data: "institution_name"
				},
				{
					data: "user_id",
					render: function(data, type, row) {
						return renderAction(data);
					},
					orderable: false,
					searchable: false
				}

			],
			columnDefs: [{
				targets: [0, 2],
				className: 'text-center',
			}],
		});
	}

	function renderAction(userId) {
		return `<a href="#"
			class="btn btn-outline-info btn-sm p-2"><i class="fas fa-times"></i></a>`;
	}

	function initSelect2() {
		$('#institution_id').select2({
			placeholder: 'Pilih Instansi',
			allowClear: true,
			width: '100%',
			ajax: {
				url: `${base_url}/listInstitution`,
				dataType: 'json',
				delay: 250,
				data: params => ({
					term: params.term,
					type: 'kabkota',
				}),
				processResults: response => {
					const institutions = response.data.map(item => ({
						id: item.id,
						text: item.name
					}));

					return {
						results: institutions
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