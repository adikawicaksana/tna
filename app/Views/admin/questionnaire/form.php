<?= $this->extend('layout/main') ?>
<?php
$oldQuestion = old('question_id') ?? [];
?>

<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card w-75">
		<div class="card-header">
			<h5><?= $title ?></h5>
		</div>
		<div class="card-body">
			<?php if (session()->getFlashdata('error')): ?>
				<div class="alert alert-danger">
					<?= session()->getFlashdata('error') ?>
				</div>
			<?php endif; ?>

			<div class="alert alert-warning d-flex align-items-center" role="alert">
				<span class="alert-icon rounded">
					<!-- <i class="icon-base ti tabler-bell icon-md"></i> -->
					<i class="fas fa-bell"></i>
				</span>
				Hanya bisa mengaktifkan satu kuesioner pada masing-masing tipe. <br>
				Nonaktifkan yang lain agar pembuatan baru dapat otomatis aktif atau aktifkan secara manual <br>
				setelah menonaktifkan yang lain.
			</div>
			<form action="<?= route_to('questionnaire.store') ?>" method="post">
				<?= csrf_field() ?>
				<div class="row mb-3">
					<label for="question" class="col-sm-2 col-form-label">Tipe</label>
					<div class="col-sm-3">
						<select class="form-select" name="questionnaire_type" id="questionnaire_type" required>
							<?php foreach ($type as $key => $each): ?>
								<option value="<?= $key ?>" <?= old('questionnaire_type') == $key ? 'selected' : '' ?>>
									<?= $each ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="row mb-3">
					<label for="question" class="col-sm-2 col-form-label">Pertanyaan</label>
					<div class="col-sm-10">
						<div class="row mb-2">
							<div class="col-sm-11">
								<select class="form-select question_id" name="question_id[]">
									<option value="">Pilih Pertanyaan</option>
									<?php foreach ($question as $key => $each): ?>
										<option value="<?= $key ?>" <?= $key == ($oldQuestion[0] ?? '') ? 'selected' : '' ?>>
											<?= $each ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn btn-sm btn-info btn-add pt-3 pb-3">
									<i class="fas fa-plus"></i>
								</button>
							</div>
						</div>

						<!-- Display old input values if submission fails  -->
						<?php foreach ($oldQuestion as $key => $old):
							if ($key == 0 || empty($old)) continue; ?>
							<div class="row mb-2">
								<div class="col-sm-11">
									<select class="form-select question_id" name="question_id[]">
										<option value="">Pilih Pertanyaan</option>
										<?php foreach ($question as $key_question => $question_value): ?>
											<option value="<?= $key_question ?>" <?= $old == $key_question ? 'selected' : '' ?>>
												<?= $question_value ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-sm-1">
									<button type="button" class="btn btn-sm btn-warning btn-remove pt-3 pb-3">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
						<?php endforeach; ?>

						<div id="new-question"></div>
					</div>
				</div>
				<button type="submit" class="btn btn-sm btn-primary" id="btn-submit">Simpan</button>
			</form>
		</div>
	</div>
</div>

<div id="clone-question" style="display: none;">
	<div class="row mb-2">
		<div class="col-sm-11">
			<select class="form-select question_id" name="question_id[]">
				<option value="">Pilih Pertanyaan</option>
				<?php foreach ($question as $key => $each): ?>
					<option value="<?= $key ?>"><?= $each ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-sm-1">
			<button type="button" class="btn btn-sm btn-warning btn-remove pt-3 pb-3">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
</div>

<script>
	$(document).on('click', '.btn-add', function() {
		let e = $('#clone-question').html();
		$('#new-question').append(e);
	})

	$(document).on('click', '.btn-remove', function() {
		$(this).closest('.row').remove();
	})

	$(document).on('change', '.question_id', function() {
		let values = [];
		let duplicate = false;

		$('.question_id').each(function() {
			let val = $(this).val();
			if (val && values.includes(val)) {
				duplicate = true;
				return false;
			}
			values.push(val);
		})

		if (duplicate) {
			alert('Pertanyaan tidak boleh sama!');
			$(this).val('');
		}
	})
</script>

<?= $this->endSection() ?>