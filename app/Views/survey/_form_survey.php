<?php

use App\Helpers\CommonHelper;
?>

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

<script>
	$('#verification').change(function() {
		$('#btn-submit').prop('disabled', !this.checked);
	})
</script>