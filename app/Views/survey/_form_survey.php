<?php

use App\Helpers\CommonHelper;
use App\Models\QuestionnaireModel;
?>

<form action="<?= url_to($url) ?>" method="post">
	<?= csrf_field() ?>
	<input type="hidden" name="survey_id" value="<?= $model['survey_id'] ?? NULL ?>">
	<input type="hidden" name="questionnaire_id" value="<?= $question[0]['questionnaire_id'] ?>">
	<input type="hidden" name="type" value="<?= $type ?>">
	<?php if (in_array($type, [QuestionnaireModel::TYPE_INDIVIDUAL_FASYANKES, QuestionnaireModel::TYPE_INDIVIDUAL_INSTITUTE])): ?>
		<div class="row mb-3">
			<div class="d-flex justify-content-between align-items-center mb-2">
				Uraian Tugas & Pelatihan
				<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalUraianTugas">
					<i class="icon-base ti tabler-plus icon-sm me-1_5"></i> Tambah Uraian Tugas
				</button>
			</div>
			<div class="card-datatable table-responsive pt-0">
				<table id="tableUraianTugas" class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th width="35%">Uraian Tugas</th>
							<th>Pengembangan Kompetensi</th>
						</tr>
					</thead>
				</table>
			</div>
		</div><br><br>
	<?php endif; ?>

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
			<label class="col-form-label">Tahun Rencana Pengembangan Kompetensi<span class="text-danger">*</span></label>
		</div>
		<div class="col-sm-8">
			<select name="training_plan_year" class="form-select select2 field-select">
				<option value=""></option>
				<?php foreach ($years as $key => $each):
					$selected = (($model['training_plan_month'] ?? NULL) == $key) ? 'selected' : ''; ?>
					<option value="<?= esc($key) ?>" <?= $selected ?>>
						<?= esc($each) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-4">
			<label class="col-form-label">Bulan Rencana Pengembangan Kompetensi<span class="text-danger">*</span></label>
		</div>
		<div class="col-sm-8">
			<select name="training_plan_month" class="form-select select2 field-select">
				<option value=""></option>
				<?php foreach ($months as $key => $each):
					$selected = (($model['training_plan_month'] ?? NULL) == $key) ? 'selected' : ''; ?>
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

<!-- Modal Tambah Uraian Tugas -->
<div class="modal fade" id="modalUraianTugas" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<form id="formUraianTugas">
				<div class="modal-header">
					<h5 class="modal-title">Tambah Data Uraian Tugas</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Uraian Tugas</label>
						<textarea name="user_uraiantugas" id="user_uraiantugas" class="form-control"></textarea>
					</div>
					<div class="mb-3">
						<label class="form-label">Pengembangan Kompetensi (sesuai dengan SIAKPEL)</label>
						<select name="user_pelatihan[]" id="user_pelatihan" class="form-control" multiple="multiple">

						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?= $this->section('scripts') ?>
<script>
	$(document).ready(function() {
		let tableJobdesc;
		initJobdescTable();
		getTrainingPlanDropdown();

		function initJobdescTable() {
			tableJobdesc = $('#tableUraianTugas').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: '/profile/listjobdesc-competence',
					type: 'GET'
				},
				columns: [{
						data: 'no',
						width: '50px',
						className: 'text-center'
					},
					{
						data: 'job_description'
					},
					{
						data: 'kompetensi',
						render: renderKompetensi
					},
				]
			})
		}

		function renderKompetensi(data) {
			return `<ul class="mb-0">
            ${data.map(item => `
                <li class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="me-2">${item.nama_pelatihan}</span>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn rounded-pill ${item.status == '1' ? 'btn-success' : 'btn-danger'} toggle-status"
                                data-id="${item.id}" data-status="${item.status}">
                                ${item.status == '1' ? 'Sudah' : 'Belum'}
                            </button>
                            <button type="button" class="btn rounded-pill btn-danger delete-competence ms-1" data-id="${item.id}">
                                <i class="icon-base ti tabler-trash icon-sm"></i>
                            </button>
                        </div>
                    </div>
                </li>`).join('')}
        </ul>`;
		}

		$('#tableUraianTugas').on('click', '.toggle-status, .delete-competence', function(e) {
			e.stopPropagation();
			let $btn = $(this);
			let id = $btn.data('id');

			if ($btn.hasClass('toggle-status')) {
				Swal.fire({
						text: 'Apakah Anda yakin ingin mengubah status kompetensi ini?',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Ya'
					})
					.then(result => {
						if (result.isConfirmed) {
							let newStatus = $btn.data('status') == '1' ? '0' : '1';
							$.post('/profile/update-status-competence', {
								id,
								status: newStatus
							}, function(res) {
								if (res.success) {
									tableJobdesc.ajax.reload(null, false);
									getTrainingPlanDropdown();
								} else {
									alert('Gagal update status');
								}
							}, 'json').fail(() => alert('Terjadi kesalahan server'));
						}
					})
			}

			if ($btn.hasClass('delete-competence')) {
				Swal.fire({
						text: 'Apakah Anda yakin ingin menghapus kompetensi ini?',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Ya'
					})
					.then(result => {
						if (result.isConfirmed) {
							$.post('/profile/delete-competence', {
								id
							}, function(res) {
								if (res.success) {
									tableJobdesc.ajax.reload(null, false);
									getTrainingPlanDropdown();
								} else {
									showSwal('error', 'Gagal', res.message);
								}
							}, 'json').fail(() => showSwal('error', 'Gagal', 'Terjadi kesalahan server'));
						}
					});
			}
		});

		$('#user_pelatihan').select2({
			dropdownParent: $('#modalUraianTugas'),
			placeholder: "Cari dan pilih pelatihan",
			multiple: true,
			minimumInputLength: 2,
			ajax: {
				url: '/api/pelatihan_siakpel',
				type: 'GET',
				dataType: 'json',
				delay: 250,
				data: params => ({
					q: params.term,
					maxData: 20,
				}),
				processResults: data => ({
					results: data
				}),
				cache: true
			},
			templateSelection: data => {
				if (!data.id) return data.text;
				const color = data.id.includes('&&1') ? '#28a745' : data.id.includes('&&0') ? '#dc3545' : null;
				return color ?
					$(`<span style="background-color:${color};color:white;padding:2px 5px;border-radius:3px;">${data.text}</span>`) :
					data.text;
			}
		});

		$('#user_pelatihan').on('select2:select', e => {
			const {
				id,
				text
			} = e.params.data;
			const $select = $(e.target);

			Swal.fire({
				text: `Apakah sudah melaksanakan "${text}" ?`,
				icon: 'question',
				showCancelButton: true,
				confirmButtonText: 'Sudah',
				cancelButtonText: 'Belum',
				buttonsStyling: false,
				customClass: {
					confirmButton: 'btn btn-success ms-1',
					cancelButton: 'btn btn-danger ms-1'
				}
			}).then(result => {
				const newValue = result.isConfirmed ? id + '&&1' : result.dismiss === Swal.DismissReason.cancel ? id + '&&0' : id;
				let selectedOptions = ($select.val() || []).filter(v => !v.startsWith(id));
				selectedOptions.push(newValue);

				if (!$select.find(`option[value='${newValue}']`).length) {
					$select.append(new Option(text, newValue, true, true));
				}

				$select.val(selectedOptions).trigger('change');
			});
		});

		$('#formUraianTugas').on('submit', function(e) {
			e.preventDefault();

			let userUraian = $('#user_uraiantugas').val();
			let userPelatihan = $('#user_pelatihan').val();

			if (!userUraian) return showSwal('warning', 'Peringatan', 'Uraian tugas wajib diisi!');

			$.post({
				url: "<?= base_url('profile/jobdesc-competence') ?>",
				data: {
					user_uraiantugas: userUraian,
					user_pelatihan: userPelatihan
				},
				dataType: 'json',
				success: function(response) {
					if (response.success) {
						showSwal('success', 'Berhasil', response.message);
						tableJobdesc.ajax.reload(null, false);
						$('#modalUraianTugas').modal('hide');
						getTrainingPlanDropdown();
					} else {
						showSwal('warning', 'Gagal', response.message);
					}
				},
				error: function(xhr) {
					showSwal('error', 'Terjadi Kesalahan', 'Silakan coba lagi');
					console.error(xhr.responseText);
				}
			});
		});

		function showSwal(icon, title, text) {
			Swal.fire({
				icon,
				title,
				text
			});
		}

		function getTrainingPlanDropdown() {
			let trainingPlan = $('#training_plan');
			trainingPlan.html('');
			$.get({
				url: "<?= route_to('user.getIncompleteCompetence') ?>",
				data: {
					_id_users: "<?= session()->get('_id_users') ?>"
				},
				dataType: 'json',
				success: function(response) {
					let option = `<option value=''></option>`;
					response.forEach(each => {
						option += `<option value="${each.training_id}">${each.nama_pelatihan}</option>`;
					});
					trainingPlan.html(option);
				},
				error: function(xhr) {
					showSwal('error', 'Terjadi Kesalahan', 'Silakan coba lagi');
					console.error(xhr.responseText);
				}
			})
		}

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