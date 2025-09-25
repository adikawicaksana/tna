<?= $this->extend('layout/main') ?>
<?php
$oldOptions = $data;
$oldOptions = old('option_name') ?? [];
$oldDescriptions = old('option_description') ?? [];
?>

<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<div class="card-header">
			Form Pertanyaan
		</div>
		<div class="card-body">
			<?php if (session()->getFlashdata('error')): ?>
				<div class="alert alert-danger">
					<?= session()->getFlashdata('error') ?>
				</div>
			<?php endif; ?>

			<form action="<?= route_to('question.update') ?>" method="post">
				<?= csrf_field() ?>
				<input type="hidden" name="question_id" value="<?= $data[0]['question_id'] ?>">
				<div class="row mb-3">
					<label for="question" class="col-sm-2 col-form-label">Pertanyaan</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="question"
							value="<?= $data[0]['question'] ?>" required>
					</div>
				</div>
				<div class="row mb-3">
					<label for="question_description" class="col-sm-2 col-form-label">Deskripsi</label>
					<div class="col-sm-10">
						<textarea class="form-control" name="question_description"><?= esc($data[0]['question_description']) ?></textarea>
					</div>
				</div>
				<div class="row mb-3">
					<label for="answer_type" class="col-sm-2 col-form-label">Tipe Jawaban</label>
					<div class="col-sm-10">
						<select class="form-select" name="answer_type" id="answer_type" required>
							<?php foreach ($answer_type as $key => $each): ?>
								<option value="<?= $key ?>" <?= $data[0]['answer_type'] == $key ? 'selected' : '' ?>>
									<?= $each ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div id="form-multiple-choice" style="display: none;">
					<div class="row mb-3">
						<label for="answer_type" class="col-sm-2 col-form-label">Pilihan Jawaban</label>
						<div class="col-sm-10" style="padding: 0.375rem 0.75rem;">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" name="has_source" value="1"
									id="switch-resource" <?= !empty($data[0]['source_reference']) ? 'checked' : '' ?>>
								<label class="form-check-label">Menggunakan data yang tersedia</label>
							</div>
							<div id="field-resource" style="display: none;">
								<input type="text" class="form-control" name="source_reference"
									value="<?= $data[0]['source_reference'] ?>"
									placeholder="Masukkan resource data (menggunakan routing)">
							</div>

							<div id="field-option">
								<!-- Display old values -->
								<?php foreach ($data as $key => $each): ?>
									<div class="row mb-2">
										<div class="col-sm-5">
											<textarea type="text" class="form-control" name="option_name[]"
												placeholder="Pilihan Jawaban"><?= esc($each['option_name']) ?></textarea>
										</div>
										<div class="col-sm-6">
											<textarea type="text" class="form-control" name="option_description[]"
												placeholder="Deskripsi Jawaban"><?= esc($each['option_description']) ?></textarea>
										</div>
										<div class="col-sm-1">
											<?php if ($key == 0): ?>
												<button type="button" class="btn btn-sm btn-info btn-add-option">
													+
												</button>
											<?php endif; ?>
										</div>
									</div>
								<?php endforeach; ?>

								<div id="new-option"></div>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-sm btn-primary" id="btn-submit">Simpan</button>
			</form>
		</div>
	</div>
</div>

<div id="clone-option" style="display: none;">
	<div class="row mb-2">
		<div class="col-sm-5">
			<textarea type="text" class="form-control" name="option_name[]"
				placeholder="Pilihan Jawaban"></textarea>
		</div>
		<div class="col-sm-6">
			<textarea type="text" class="form-control" name="option_description[]"
				placeholder="Deskripsi Jawaban"></textarea>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
<script>
	let hasOption = '<?= json_encode($has_option) ?>';
	$(document).ready(function() {
		formMultipleChoice($('#answer_type'));
		resourceField($('#switch-resource'));
	})

	$('#answer_type').change(function() {
		formMultipleChoice($(this));
	})

	function formMultipleChoice(e) {
		if (hasOption.includes(e.val())) {
			$('#form-multiple-choice').show();
		} else {
			$('#form-multiple-choice').hide();
		}
	}

	$(document).on('change', '#switch-resource', function() {
		resourceField($(this));
	})

	function resourceField(e) {
		if (e.prop('checked')) {
			$('#field-resource').show();
			$('#field-option').hide();
		} else {
			$('#field-resource').hide();
			$('#field-option').show();
		}
	}

	$(document).on('click', '.btn-add-option', function() {
		let form = $('#clone-option').html();
		$('#new-option').append(form)
	})
</script>

<?= $this->endSection(); ?>