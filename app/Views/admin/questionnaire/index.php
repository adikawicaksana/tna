<?= $this->extend('layout/main') ?>
<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<div class="card-header">
			<h5><?= $title ?></h5>
			<a href="<?= url_to('questionnaire.create') ?>" class="btn btn-sm btn-primary">Tambah Baru</a>
		</div>
		<div class="card-body">
			<?php if (session()->getFlashdata('error')): ?>
				<div class="alert alert-danger">
					<?= session()->getFlashdata('error') ?>
				</div>
			<?php elseif (session()->getFlashdata('success')): ?>
				<div class="alert alert-success">
					<?= session()->getFlashdata('success') ?>
				</div>
			<?php endif; ?>

			<table id="dataTable" class="table table-responsive table-bordered table-hover w-100">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Tanggal</th>
						<th>Tipe</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('#dataTable').DataTable({
			processing: true,
			serverSide: true,
			searching: false,
			ajax: {
				url: "<?= current_url() ?>",
				type: "GET"
			},
			columns: [
				{ data: "no", name: "no", orderable: false, searchable: false },
				{ data: "created_at", name: "created_at" },
				{ data: "questionnaire_type", name: "questionnaire_type" },
				{ data: "questionnaire_status", name: "questionnaire_status", searchable: false },
				{ data: "action", name: "action", orderable: false, searchable: false }
			],
			columnDefs: [{
				targets: [0],
				className: 'text-center',
			}],
		});
	});
</script>
<?= $this->endSection(); ?>