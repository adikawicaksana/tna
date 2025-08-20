<?= $this->extend('layout/main') ?>

<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<div class="card-header">
			<h5><?= $title ?></h5>
			<a href="<?= url_to('question.create') ?>" class="btn btn-sm btn-primary">Tambah Baru</a>
		</div>
		<div class="card-body">
			<?php

			use App\Models\QuestionModel;

			if (session()->getFlashdata('error')): ?>
				<div class="alert alert-danger">
					<?= session()->getFlashdata('error') ?>
				</div>
			<?php elseif (session()->getFlashdata('success')): ?>
				<div class="alert alert-success">
					<?= session()->getFlashdata('success') ?>
				</div>
			<?php endif; ?>

			<table id="dataTable" class="table table-sm table-responsive table-bordered table-hover w-100">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Pertanyaan</th>
						<th>Deskripsi</th>
						<th>Tipe Jawaban</th>
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
			ajax: {
				url: "<?= current_url() ?>",
				type: "GET"
			},
			columns: [
				{ data: "no", name: "no", orderable: false, searchable: false },
				{ data: "question", name: "question" },
				{ data: "question_description", name: "question_description" },
				{ data: "answer_type", name: "answer_type", orderable:false, searchable: false },
				{ data: "question_status", name: "question_status", searchable: false },
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