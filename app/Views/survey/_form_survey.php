<?php

use App\Helpers\CommonHelper;
?>

<form action="<?= route_to('survey.store') ?>" method="post">
	<?= csrf_field() ?>
	<div class="row mb-3">
		<div class="col-sm-4">
			<label class="col-form-label" for="basic-default-<?= esc($fasyankes_nonfasyankes['selectName']) ?>"><?= esc($fasyankes_nonfasyankes['label']) ?></label>
		</div>
		<div class="col-sm-8">
			<select id="<?= esc($fasyankes_nonfasyankes['selectName']) ?>" name="<?= esc($fasyankes_nonfasyankes['selectName']) ?>" class="form-select select2">
			<?php foreach ($fasyankes_nonfasyankes['options'] as $key => $label): ?>
				<option value="<?= esc($key) ?>" 
					>
					<?= esc($label) ?>
				</option>
				<?php endforeach; ?>
			</select>
		</div>			
	</div>
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


<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
	$('#verification').change(function() {
		$('#btn-submit').prop('disabled', !this.checked);
	})
});
</script>
<?= $this->endSection() ?>