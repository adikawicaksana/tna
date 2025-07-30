<?= $this->extend('layout/main') ?>
<?php

use App\Models\QuestionModel;
?>
<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<div class="card-header">
			<h5><?= $title ?></h5>
			<?php if ($data[0]['question_status'] == QuestionModel::STAT_ACTIVE): ?>
				<a href="<?= url_to('question.deactivate', $data[0]['question_id']) ?>" class="btn btn-sm btn-outline-danger">
					<span class="me-2"><i class="fas fa-ban"></i></span> Nonaktifkan
				</a>
			<?php endif; ?>
		</div>
		<div class="card-body">
			<table class="table table-sm table-responsive table-bordered table-hover w-100 align-top">
				<tr>
					<th width="20%">Pertanyaan</th>
					<td><?= $data[0]['question'] ?></td>
				</tr>
				<tr>
					<th>Deskripsi</th>
					<td><?= $data[0]['question_description'] ?></td>
				</tr>
				<tr>
					<th>Status</th>
					<td><?= QuestionModel::listStatus()[$data[0]['question_status']] ?></td>
				</tr>
				<tr>
					<th>Tipe Jawaban</th>
					<td>
						<?= $answer_type[$data[0]['answer_type']] ?>

						<?= !empty($data[0]['source_reference']) ? "<br>{$data[0]['source_reference']}" : '' ?>
						<?php foreach ($data as $key => $each): ?>
							<br>
							<b><?= chr(65 + $key) ?>. <?= $each['option_name'] ?></b>
							<small class="ms-5 text-muted">
								<?= !empty($each['option_description']) ? '<br>' . $each['option_description'] : '' ?>
							</small>
						<?php endforeach; ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>