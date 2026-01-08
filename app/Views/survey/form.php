<?php
	use App\Models\QuestionnaireModel;
?>
<?= $this->extend('layout/main') ?>
<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<?php /*
		<div class="card-header d-flex">
			<?= $title ?>
			<div class="ms-auto">
				<a href="<?= url_to('master-training.index') ?>"
					class="btn btn-sm btn-primary float-right" target="_blank">Pelatihan Terakreditasi Ditmutu</a>
			</div>
		</div>
		*/ ?>
		<div class="card-body">
			<?php
			if (session()->getFlashdata('error')): ?>
				<div class="alert alert-danger">
					<?= session()->getFlashdata('error') ?>
				</div>
			<?php endif; ?>

			<?php if (empty($question)): ?>
				<div class="alert alert-danger d-flex align-items-center" role="alert">
					<span class="alert-icon rounded">
						<i class="fas fa-warning"></i>
					</span>
					Tidak ada assessment / penilain yang sedang aktif. Mohon hubungi pihak Murnajati.
				</div>
			<?php else: ?>
				<?php if (in_array($type, QuestionnaireModel::listIndividual())): ?>
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

				Pertanyaan dengan tanda (<span class="text-danger">*</span>) wajib diisi

				<?= (empty($model)) ? view('survey/_form_create') : view('survey/_form_update') ?>
			<?php endif; ?>
		</div>
	</div>
</div>

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
						<select name="user_pelatihan[]" id="user_pelatihan" class="form-control" multiple="multiple"></select>
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
									// getTrainingPlanDropdown();
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
									// getTrainingPlanDropdown();
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
						// getTrainingPlanDropdown();
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
	});
</script>
<?= $this->endSection() ?>

<?= $this->endSection(); ?>