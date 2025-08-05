<?php

use App\Helpers\CommonHelper;
?>

<?= $this->extend('layout/main') ?>
<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<div class="card-header">
			<?= $title ?>
		</div>
		<div class="card-body">
			<?php
			if (session()->getFlashdata('error')): ?>
				<div class="alert alert-danger">
					<?= session()->getFlashdata('error') ?>
				</div>
			<?php endif; ?>

			<form action="<?= route_to('survey.store') ?>" method="post">
				<?= csrf_field() ?>
				<?php foreach ($question as $each): ?>
					<div class="row mb-3">
						<div class="col-sm-4">
							<label for="question" class="col-form-label">
								<?= $each['question'] ?>
							</label>

						</div>
						<div class="col-sm-8">
							<?= CommonHelper::generateInputField(
								$each['answer_type'],
								$each['question_id'],
								$option[$each['question_id']] ?? []
							) ?>
						</div>
					</div>
				<?php endforeach; ?>

				<div class="row mb-3">
					<div class="col-sm-8 offset-sm-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="verification" id="verification">
							<label class="form-check-label">
								Saya menyatakan bahwa data yang saya input adalah benar
							</label>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-sm btn-primary" id="btn-submit" disabled>Simpan</button>
			</form>
		</div>
	</div>
</div>

<script>
	$('#verification').change(function() {
		$('#btn-submit').prop('disabled', !this.checked);
	})
</script>

<?= $this->endSection(); ?>