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

			<table class="table table-sm table-responsive table-bordered table-hover w-100">
				<tr>
					<th class="text-center">No</th>
					<th>Pertanyaan</th>
					<th>Deskripsi</th>
					<th>Tipe Jawaban</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php foreach ($data as $key => $each): ?>
					<tr>
						<td class="text-center"><?= $key + 1 ?></td>
						<td><?= $each['question'] ?></td>
						<td><?= !empty($each['question_description']) ? $each['question_description'] : '-' ?></td>
						<td><?= $answer_type[$each['answer_type']] ?></td>
						<td><?= $status[$each['question_status']] ?></td>
						<td class="d-flex gap-1">
							<a href="<?= route_to('question.show', $each['question_id']) ?>"
								class="btn btn-outline-info btn-sm p-2">
								<i class="fas fa-eye"></i>
							</a>
							<?php if (QuestionModel::isDeactivatable($each['question_id'])): ?>
								<form action="<?= route_to('question.deactivate', $each['question_id']) ?>" method="post"
									onsubmit="return confirm('Apakah Anda yakin akan menonaktifkan data ini?');">
									<?= csrf_field() ?>
									<button type="submit" class="btn btn-outline-danger btn-sm p-2">
										<i class="fas fa-ban"></i>
									</button>
								</form>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>