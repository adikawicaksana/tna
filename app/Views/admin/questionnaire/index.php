<?php

use App\Helpers\CommonHelper;
?>

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

			<table class="table table-responsive table-bordered table-hover w-100">
				<tr>
					<th class="text-center">No</th>
					<th>Tanggal</th>
					<th>Tipe</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php foreach ($data as $key => $each): ?>
					<tr>
						<td class="text-center"><?= $key + 1 ?></td>
						<td><?= CommonHelper::formatDate($each['created_at']) ?></td>
						<td><?= $type[$each['questionnaire_type']] ?></td>
						<td><?= $status[$each['questionnaire_status']] ?></td>
						<td>
							<a href="<?= route_to('questionnaire.show', $each['questionnaire_id']) ?>"
								class="btn btn-outline-info btn-sm p-2">
								<i class="fas fa-eye"></i>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>