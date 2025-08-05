<?= $this->extend('layout/main') ?>
<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<div class="card-header">
			<h5><?= $title ?></h5>
			<?php foreach ($questionnaire_type as $key => $each): ?>
				<a href="<?= url_to('survey.create', $key) ?>" class="btn btn-sm btn-primary">
					<i class="fas fa-plus"></i> &nbsp; <?= $each ?>
				</a>
			<?php endforeach; ?>
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

			<table class="table table-responsive table-bordered table-hover w-100">
				<tr>
					<th class="text-center">No</th>
					<th>Tanggal</th>
					<th>Instansi</th>
					<th>NIP</th>
					<th>Nama</th>
					<th>Action</th>
				</tr>
				<?php foreach ($data as $key => $each): ?>
					<tr>
						<td class="text-center"><?= $key + 1 ?></td>
						<td><?= $each['created_at'] ?></td>
						<td></td>
						<td><?= $each['citizen_id'] ?></td>
						<td><?= $each['responden'] ?></td>
						<td></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>