<?php

use App\Helpers\CommonHelper;
use App\Models\SurveyModel;

?>
<div class="card">
	<div class="card-header">
		<h5>Setujui Assessment / Penilaian</h5>
	</div>
	<div class="card-body">
		<form id="form-approval" action="<?= url_to('survey.postApproval') ?>" method="post">
			<?= csrf_field() ?>
			<input type="hidden" name="survey_id" value="<?= $data->survey_id ?>">
			<div class="table-container">
				<div class="x-scroll fixed-column-table">
					<table class="table table-bordered table-responsive" width="100%">
						<thead>
							<tr>
								<th class="sticky-col first-col">No</th>
								<th class="sticky-col second-col">Pertanyaan</th>
								<th class="sticky-col third-col limit-width">Disetujui</th>
								<th>Jawaban</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($detail as $key => $each):
								$temp = $answer[$key];
								krsort($temp); ?>
								<tr>
									<td class="sticky-col first-col"><?= $key + 1 ?></td>
									<td class="sticky-col second-col"><?= $each['question'] ?></td>
									<td class="sticky-col third-col limit-width">
										<?= CommonHelper::generateInputField(
											$each['answer_type'],
											"question[{$each['question_id']}]",
											$source[$each['question_id']] ?? [],
											$latest_answer[$each['question_id']] ?? '',
										) ?>
									</td>
									<?php foreach ($temp as $datetime => $value): ?>
										<td>
											<b><?= CommonHelper::formatDate($datetime, 2) . '</b><br>' . $value ?>
										</td>
									<?php endforeach; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
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