<?php

use App\Helpers\CommonHelper;
?>

<form action="<?= route_to('survey.store') ?>" method="post">
	<?= csrf_field() ?>
	<input type="hidden" name="questionnaire_id" value="<?= $question[0]['questionnaire_id'] ?>">
	<div class="row mb-3">
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
	<div class="row mb-3">
		<div class="col-sm-4">
			<label class="col-form-label" for="basic-default-<?= esc($fasyankes_nonfasyankes['selectName']) ?>"><?= esc($fasyankes_nonfasyankes['label']) ?></label>
		</div>
		<div class="col-sm-8">
			<select id="<?= esc($fasyankes_nonfasyankes['selectName']) ?>" name="<?= esc($fasyankes_nonfasyankes['selectName']) ?>" class="form-select select2 field-select">
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
				<small class="ms-5 text-muted">
					<?= !empty($each['question_description']) ? '<br>' . $each['question_description'] : '' ?>
				</small>
			</div>
			<div class="col-sm-8">
				<?= CommonHelper::generateInputField(
					$each['answer_type'],
					$each['question_id'],
					$source[$each['question_id']] ?? []
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
	let tableJobdesc;
	initJobdescTable();

	function initJobdescTable() {
        tableJobdesc = $('#tableUraianTugas').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
			url: '/profile/listjobdesc-competence',
			type: 'GET'
			},
			columns: [
				{ data: 'no', width: '50px', className: 'text-center' },
				{ data: 'job_description' },
				{ data: 'kompetensi', render: renderKompetensi },
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
			Swal.fire({ text: 'Apakah Anda yakin ingin mengubah status kompetensi ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya' })
				.then(result => {
				if (result.isConfirmed) {
					let newStatus = $btn.data('status') == '1' ? '0' : '1';
					$.post('/profile/update-status-competence', { id, status: newStatus }, function(res) {
						if (res.success) tableJobdesc.ajax.reload(null, false);
						else alert('Gagal update status');
					}, 'json').fail(() => alert('Terjadi kesalahan server'));
				}
			})
        }

        if ($btn.hasClass('delete-competence')) {
          	Swal.fire({ text: 'Apakah Anda yakin ingin menghapus kompetensi ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya' })
				.then(result => {
				if (result.isConfirmed) {
						$.post('/profile/delete-competence', { id }, function(res) {
						if (res.success) tableJobdesc.ajax.reload(null, false);
						else showSwal('error', 'Gagal', res.message);
					}, 'json').fail(() => showSwal('error', 'Gagal', 'Terjadi kesalahan server'));
				}
			});
        }
    });

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