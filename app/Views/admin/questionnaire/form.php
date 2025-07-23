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
		<h1>Tambah Kuesioner</h1>
		<div class="card w-75">
			<div class="card-header">
				Form Kuesioner
			</div>
			<div class="card-body">
				<?php if (session()->getFlashdata('error')): ?>
					<div class="alert alert-danger">
						<?= session()->getFlashdata('error') ?>
					</div>
				<?php endif; ?>

				<form action="<?= route_to('questionnaire.store') ?>" method="post">
					<?= csrf_field() ?>
					<div class="row mb-3">
						<label for="question" class="col-sm-2 col-form-label">Tipe</label>
						<div class="col-sm-3">
							<select class="form-select" name="questionnaire_type" id="questionnaire_type" required>
								<?php foreach ($type as $key => $each): ?>
									<option value="<?= $key ?>"><?= $each ?></option>
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
											<option value="<?= $key ?>"><?= $each ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-sm-1">
									<button type="button" class="btn btn-sm btn-info btn-add">+</button>
								</div>
							</div>
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
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
				</select>
			</div>
			<div class="col-sm-1">
				<button type="button" class="btn btn-sm btn-warning btn-remove">-</button>
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

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</body>

</html>