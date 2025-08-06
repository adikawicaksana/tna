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
			<?php if (!$has_active): ?>
				<form action="<?= url_to('questionnaire.activate', $data[0]['questionnaire_id']) ?>" method="post" style="display: inline;">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Yakin ingin mengaktifkan data?')">
						<span class="me-2"><i class="fas fa-check"></i></span> Aktifkan
					</button>
				</form>
			<?php else: ?>
				<form action="<?= url_to('questionnaire.deactivate', $data[0]['questionnaire_id']) ?>" method="post" style="display: inline;">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menonaktifkan data?')">
						<span class="me-2"><i class="fas fa-ban"></i></span> Nonaktifkan
					</button>
				</form>
			<?php endif; ?>
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

			<table class="table table-sm table-responsive table-bordered table-hover w-100 align-top">
				<tr>
					<th width="20%">Tanggal</th>
					<td><?= CommonHelper::formatDate($data[0]['created_at']) ?></td>
				</tr>
				<tr>
					<th>Tipe</th>
					<td><?= $questionnaire_type[$data[0]['questionnaire_type']] ?></td>
				</tr>
				<tr>
					<th>Status</th>
					<td><?= $questionnaire_status[$data[0]['questionnaire_status']] ?></td>
				</tr>
				<tr>
					<th>Daftar Pertanyaan</th>
					<td class="p-1">
						<ul>
							<?php foreach ($data as $key => $each): ?>
								<li>
									<?= $each['question'] ?> <br>
									<?= esc($each['question_description']) ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>