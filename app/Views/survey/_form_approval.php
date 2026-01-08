<?php

use App\Helpers\CommonHelper;
use App\Models\SurveyModel;

?>
<style>
	table#survey_detail tr td {
		vertical-align: top;
	}

	li.select2-selection__choice {
		white-space: normal;
	}
</style>
<div class="card">
	<div class="card-header">
		<h5>Setujui Assessment / Penilaian</h5>
	</div>
	<div class="card-body">
		<form id="form-approval" action="<?= url_to('survey.postApproval') ?>" method="post">
			<?= csrf_field() ?>
			<input type="hidden" name="survey_id" value="<?= $data->survey_id ?>">
			<div class="table-container">
				<!-- <div class="x-scroll fixed-column-table"> -->
					<table id="survey_detail" class="table table-bordered table-responsive" width="100%">
						<thead>
							<tr>
								<th>No</th>
								<th width="30%">Pertanyaan</th>
								<th max-width="30%">Disetujui</th>
								<th>Jawaban</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($detail as $key => $each): ?>
								<tr>
									<td><?= $key + 1 ?></td>
									<td><?= $each['question'] ?></td>
									<td>
										<?= CommonHelper::generateInputField(
											$each['answer_type'],
											"question[{$each['question_id']}]",
											$source[$each['question_id']] ?? [],
											$each['answer_text'] ?? '',
										) ?>
									</td>
									<td><?= nl2br($history[$each['question_id']]) ?></td>
								</tr>
							<?php endforeach; ?>

							<tr>
								<td><?= ++$key + 1 ?></td>
								<td>Rencana Pengembangan Kompetensi</td>
								<td style="max-width: 100px;">
									<select id="training_plan" name="training_plan[]" class="form-select select2 field-select" multiple></select>
								</td>
								<td>
									<?= nl2br($plan_history['nama_pelatihan']) ?>
								</td>
							</tr>

							<tr>
								<td><?= ++$key + 1 ?></td>
								<td>Tahun Rencana Pengembangan Kompetensi</td>
								<td>
									<select name="training_plan_year" class="form-select select2 field-select">
										<option value=""></option>
										<?php foreach ($years as $year => $each):
											$selected = (($plan[0]['plan_year'] ?? NULL) == $year) ? 'selected' : ''; ?>
											<option value="<?= $year ?>" <?= $selected ?>>
												<?= esc($each) ?>
											</option>
										<?php endforeach; ?>
									</select>
								</td>
								<td><?= nl2br($plan_history['plan_year']) ?></td>
							</tr>

							<tr>
								<td><?= ++$key + 1 ?></td>
								<td>Bulan Rencana Pengembangan Kompetensi</td>
								<td>
									<select name="training_plan_month" class="form-select select2 field-select">
										<option value=""></option>
										<?php foreach ($months as $month => $each):
											$selected = (($plan[0]['plan_month'] ?? NULL) == $month) ? 'selected' : ''; ?>
											<option value="<?= $month ?>" <?= $selected ?>>
												<?= esc($each) ?>
											</option>
										<?php endforeach; ?>
									</select>
								</td>
								<td><?= nl2br($plan_history['plan_month']) ?></td>
							</tr>
						</tbody>
					</table>
				<!-- </div> -->
			</div>

			<div class="d-flex justify-content-end align-items-start gap-2 mt-3" style="flex-wrap: wrap;">
				<input type="hidden" name="approval_status" id="approval_status">
				<textarea class='form-control field-input me-2' name="approval_remark" id="approval_remark"
					placeholder="Isikan alasan penolakan" rows="2" style="width: 300px;"></textarea>
				<div class="d-flex flex-column gap-2">
					<button type="button" class="btn btn-sm btn-warning btn-submit" data-approval_value="<?= SurveyModel::STAT_DECLINED ?>">
						<i class="fas fa-times me-1"></i> Tolak
					</button>
					<button type="button" class="btn btn-sm btn-primary btn-submit" data-approval_value="<?= SurveyModel::STAT_ACTIVE ?>">
						<i class="fas fa-check me-1"></i> Setujui
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	let declined = '<?= SurveyModel::STAT_DECLINED ?>';
	let trainingID = '<?= json_encode($training_id) ?>';

	$(document).ready(function() {
		getTrainingPlanDropdown();
	})

	function getTrainingPlanDropdown() {
		let trainingPlan = $('#training_plan');
		trainingPlan.html('');
		$.get({
			url: "<?= route_to('user.getCompetence') ?>",
			data: {
				_id_users: "<?= $data->respondent_id ?>"
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

	$('.btn-submit').click(function() {
		let approval_value = $(this).data('approval_value');
		if (approval_value == declined) {
			let approval_remark = $('#approval_remark').val();
			if (approval_remark === '') {
				alert('Harap isi alasan penolakan');
				$('#approval_remark').focus();
				return;
			}
		}

		$('#approval_status').val(approval_value);
		$('#form-approval').submit();
	})
</script>