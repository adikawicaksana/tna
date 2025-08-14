<?php

use App\Helpers\CommonHelper;
?>

<form action="<?= route_to('survey.store') ?>" method="post">
	<?= csrf_field() ?>
	<div class="row mb-3">
	<div class="card-datatable table-responsive pt-0">
        <table class="table datatables-uraian-tugas">
          <thead>
            <tr>
              <th>No</th>
              <th>Uraian Tugas</th>
              <th>Pelatihan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Edukasi pasien/keluarga, promosi kesehatan</td>
              <td>Pelatihan Komunikasi efektif.</td>
              <td><button type="button" class="btn btn-sm rounded-pill btn-success waves-effect waves-light">Sudah</button></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Melaksanakan skrining risiko infeksi pada pasien dan lingkungan kerja sesuai prosedur PPI di FKTP.</td>
              <td>Pelatihan Pencegahan dan Pengendalian Infeksi (PPI) bagi Tenaga Kesehatan di Fasilitas Kesehatan Tingkat Pertama (FKTP)</td>
              <td><button type="button" class="btn btn-sm rounded-pill btn-success waves-effect waves-light">Sudah</button></td>
            </tr>
            <tr>
              <td>3</td>
              <td>Melaksanakan pelayanan ANC terstandar pada ibu hamil sesuai pedoman Kemenkes, termasuk pemeriksaan fisik, laboratorium dasar, dan penilaian faktor risiko.</td>
              <td>Pelatihan Pelayanan Antenatal Care, Persalinan, Nifas Dan Skrining Hipotiroid Kongenital (ANC SHK) Bagi Bidan di FKTP</td>
              <td><button type="button" class="btn btn-sm rounded-pill btn-danger waves-effect waves-light">Belum</button></td>
            </tr>
            <tr>
              <td>4</td>
              <td>Memberikan konseling pra dan pasca tes untuk mendukung informed consent dan pemahaman pasien.</td>
              <td>Pelatihan Pencegahan Penularan HIV, Sifilis dan Hepatitis B dari Ibu Ke Anak (Menuju Triple Eliminasi)</td>
              <td><button type="button" class="btn btn-sm rounded-pill btn-danger waves-effect waves-light">Belum</button></td>
            </tr>
            <tr>
              <td>5</td>
              <td>Melaksanakan konseling menyusui pada ibu hamil, ibu nifas, dan ibu menyusui dengan teknik komunikasi efektif sesuai pedoman Kemenkes.</td>
              <td>Pelatihan Konseling Menyusui (KON-ASI)</td>
              <td><button type="button" class="btn btn-sm rounded-pill btn-success waves-effect waves-light">Sudah</button></td>
            </tr>
          </tbody>
        </table>
      </div>
      </div><br><br>
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
				<label for="question" class="col-form-label text-wrap">
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
$(document).ready(function () {
	$('#verification').change(function() {
		$('#btn-submit').prop('disabled', !this.checked);
	})

	$(document).on('change', '.field-input, .field-select, input[type="radio"]', checkInputs);

	function checkInputs() {
		let allFilled = true;

		// Check input field
		$('.field-input').each(function() {
			if ($(this).val() === "") {
				allFilled = false;
				return false;
			}
		});

		// Check select field
		$('.field-select').each(function() {
			if ($(this).val() === "") {
				allFilled = false;
				return false;
			}
		});

		// Check radio button
		$('.form-group input[type="radio"]:checked').each(function() {
			if ($(this).val() === "") {
				allFilled = false;
				return false;
			}
		});

		// Check textarea
		$('.field-textarea').each(function() {
			if ($(this).val().trim() === "") {
				allFilled = false;
				return false;
			}
		})

		// Activate verification checkbox
		$('#verification').prop('disabled', !allFilled);
	}
})
</script>
<?= $this->endSection() ?>