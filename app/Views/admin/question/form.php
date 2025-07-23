<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TNA - Murnajati</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
	<div class="container">
		<h1>Tambah Pertanyaan</h1>
		<div class="card w-75">
			<div class="card-header">
				Form Pertanyaan
			</div>
			<div class="card-body">
				<?php if (session()->getFlashdata('error')): ?>
					<div class="alert alert-danger">
						<?= session()->getFlashdata('error') ?>
					</div>
				<?php endif; ?>

				<form action="<?= base_url('admin/question/store') ?>" method="post">
					<?= csrf_field() ?>
					<div class="row mb-3">
						<label for="question" class="col-sm-2 col-form-label">Pertanyaan</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="question" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="question_description" class="col-sm-2 col-form-label">Deskripsi</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="question_description"></textarea>
						</div>
					</div>
					<div class="row mb-3">
						<label for="answer_type" class="col-sm-2 col-form-label">Tipe Jawaban</label>
						<div class="col-sm-10">
							<select class="form-select" name="answer_type" id="answer_type" required>
								<?php foreach ($answer_type as $key => $each): ?>
									<option value="<?= $key ?>"><?= $each ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div id="form-multiple-choice" style="display: none;">
						<div class="row mb-3">
							<label for="answer_type" class="col-sm-2 col-form-label">Pilihan Jawaban</label>
							<div class="col-sm-10" style="padding: 0.375rem 0.75rem;">
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" role="switch"
										id="switch-resource">
									<label class="form-check-label">Menggunakan data yang tersedia</label>
								</div>

								<div id="field-resource" style="display: none;">
									<input type="text" class="form-control" name="option_data"
										placeholder="Masukkan resource data (menggunakan routing)">
								</div>

								<div id="field-option">
									<div class="row mb-2">
										<div class="col-sm-5">
											<textarea type="text" class="form-control" name="option_name[]"
												placeholder="Pilihan Jawaban"></textarea>
										</div>
										<div class="col-sm-6">
											<textarea type="text" class="form-control" name="option_description[]"
												placeholder="Deskripsi Jawaban"></textarea>
										</div>
										<div class="col-sm-1">
											<button type="button" class="btn btn-sm btn-info btn-add-option">+</button>
										</div>
									</div>
									<div id="new-option"></div>
								</div>
							</div>
						</div>
					</div>

					<!-- <div class="row mb-3">
						<div class="col-sm-10 offset-sm-2">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="verification" id="verification">
								<label class="form-check-label">
									Saya menyatakan bahwa data yang saya input adalah benar
								</label>
							</div>
						</div>
					</div> -->
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
		// $('#verification').change(function() {
		// 	$('#btn-submit').prop('disabled', !this.checked);
		// })

		let hasOption = '<?= json_encode($has_option) ?>';
		$('#answer_type').change(function() {
			if (hasOption.includes($(this).val())) {
				$('#form-multiple-choice').show();
			} else {
				$('#form-multiple-choice').hide();
			}
		})

		$(document).on('change', '#switch-resource', function() {
			if ($(this).prop('checked')) {
				$('#field-resource').show();
				$('#field-option').hide();
			} else {
				$('#field-resource').hide();
				$('#field-option').show();
			}
		})

		$(document).on('click', '.btn-add-option', function() {
			let form = $('#clone-option').html();
			console.log(form)
			$('#new-option').append(form)
		})
	</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</body>

</html>