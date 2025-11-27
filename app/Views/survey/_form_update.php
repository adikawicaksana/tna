<?php

use App\Helpers\CommonHelper;
?>

<form action="<?= url_to($url) ?>" method="post">
	<?= csrf_field() ?>
	<input type="hidden" name="survey_id" value="<?= $model['survey_id'] ?? NULL ?>">
	<input type="hidden" name="questionnaire_id" value="<?= $question[0]['questionnaire_id'] ?>">
	<input type="hidden" name="type" value="<?= $type ?>">

	<div class="row mb-3">
		<div class="col-sm-4">
			<label class="col-form-label" for="basic-default-<?= esc($institution['selectName']) ?>"><?= esc($institution['label']) ?><span class="text-danger">*</span></label>
		</div>
		<div class="col-sm-8">
			<select id="<?= esc($institution['selectName']) ?>" name="<?= esc($institution['selectName']) ?>" class="form-select select2 field-select" <?= (isset($model['institution_id'])) ? 'disabled' : '' ?>>
				<?php foreach ($institution['options'] as $key => $label):
					$selected = (($model['institution_id'] ?? NULL) == $key) ? 'selected' : ''; ?>
					<option value="<?= esc($key) ?>" <?= $selected ?>>
						<?= esc($label) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<?php foreach ($question as $each): ?>
		<div class="row mb-3">
			<div class="col-sm-4">
				<label for="question" class="col-form-label text-wrap">
					<?= $each['question'] ?> <span class="text-danger">*</span>
				</label>
				<small class="ms-5 text-muted">
					<?= !empty($each['question_description']) ? '<br>' . $each['question_description'] : '' ?>
				</small>
			</div>
			<div class="col-sm-8">
				<?= CommonHelper::generateInputField(
					$each['answer_type'],
					"question[{$each['question_id']}]",
					$source[$each['question_id']] ?? [],
					$answer[$each['question_id']] ?? '',
				) ?>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="row mb-3">
		<div class="col-sm-4">
			<label class="col-form-label">Rencana Pengembangan Kompetensi<span class="text-danger">*</span></label>
		</div>
		<div class="col-sm-8">
			<select id="training_plan" name="training_plan[]" class="form-select select2 field-select" multiple></select>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-4">
			<label class="col-form-label">
				Tahun<span class="text-danger">*</span>
				<small class="ms-5 text-muted"><br>Rencana Pengembangan Kompetensi</small>
			</label>
		</div>
		<div class="col-sm-8">
			<select name="training_plan_year" class="form-select select2 field-select">
				<option value=""></option>
				<?php foreach ($years as $key => $each):
					$selected = (($training_plan[0]['plan_year'] ?? NULL) == $key) ? 'selected' : ''; ?>
					<option value="<?= esc($key) ?>" <?= $selected ?>>
						<?= esc($each) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-4">
			<label class="col-form-label">
				Bulan<span class="text-danger">*</span>
				<small class="ms-5 text-muted"><br>Rencana Pengembangan Kompetensi</small>
			</label>
		</div>
		<div class="col-sm-8">
			<select name="training_plan_month" class="form-select select2 field-select">
				<option value=""></option>
				<?php foreach ($months as $key => $each):
					$selected = (($training_plan[0]['plan_month'] ?? NULL) == $key) ? 'selected' : ''; ?>
					<option value="<?= esc($key) ?>" <?= $selected ?>>
						<?= esc($each) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-8 offset-sm-4">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="verification" id="verification" disabled>
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
	let trainingID = '<?= json_encode($training_id) ?>';

	function getTrainingPlanDropdown() {
		let trainingPlan = $('#training_plan');
		trainingPlan.html('');
		$.get({
			url: "<?= url_to('user.getIncompleteCompetence') ?>",
			data: {
				_id_users: "<?= session()->get('_id_users') ?>"
			},
			dataType: 'json',
			success: function(response) {
				let option = `<option value=''></option>`;
				response.forEach(each => {
					let selected = trainingID.includes(each.training_id) ? 'selected' : '';
					option += `<option value="${each.training_id}" ${selected}>${each.nama_pelatihan}</option>`;
				});
				trainingPlan.html(option);
			},
			error: function(xhr) {
				showSwal('error', 'Terjadi Kesalahan', 'Silakan coba lagi');
				console.error(xhr.responseText);
			}
		})
	}
</script>
<?= $this->endSection() ?>