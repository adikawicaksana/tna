<?= $this->extend('layout/main') ?>
<?php

use App\Helpers\CommonHelper;
use App\Models\QuestionModel;
use App\Models\QuestionnaireModel;
use App\Models\SurveyModel;

?>
<?= $this->section('content'); ?>
<style>
	.table-container {
		position: relative;
		max-width: 100%;
		overflow-x: auto;
	}

	.fixed-column-table {
		border-collapse: collapse;
		width: max-content;
		min-width: 100%;
	}

	.sticky-col {
		position: sticky;
		left: 0;
		background-color: white !important;
		z-index: 2;
	}

	.first-col {
		left: 0;
		z-index: 10;
		width: 60px;
	}

	.second-col {
		left: 60px;
		z-index: 11;
		width: 300px;
	}

	.third-col {
		left: 360px;
		z-index: 12;
		width: 400px;
	}
</style>

<div class="container">
	<h1><?= $title ?></h1>
	<?php if (session()->getFlashdata('error')): ?>
		<div class="alert alert-danger">
			<?= session()->getFlashdata('error') ?>
		</div>
	<?php elseif (session()->getFlashdata('success')): ?>
		<div class="alert alert-success">
			<?= session()->getFlashdata('success') ?>
		</div>
	<?php endif; ?>

	<div class="d-flex mb-2" style="padding-left: 0 !important;">
		<?php if (SurveyModel::isEditable($data->survey_id)): ?>
			<a href="<?= url_to('survey.edit', $data->survey_id) ?>" class="btn btn-sm btn-primary me-2">
				<i class="fas fa-pen"></i> &nbsp; Edit
			</a>
		<?php endif; ?>
		<?php if (SurveyModel::isApprovable($data->survey_id)): ?>
			<a href="<?= url_to('survey.approval', $data->survey_id) ?>" class="btn btn-sm btn-primary">
				<i class="fas fa-check"></i> &nbsp; Setujui
			</a>
		<?php endif; ?>
	</div>
	<div class="nav-align-top nav-tabs-shadow">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<button
					type="button"
					class="nav-link active"
					role="tab"
					data-bs-toggle="tab"
					data-bs-target="#navs-top-home"
					aria-controls="navs-top-home"
					aria-selected="true">
					Assessment
				</button>
			</li>

			<?php if (in_array($data->questionnaire_type, QuestionnaireModel::listIndividual())): ?>
				<li class="nav-item">
					<button
						type="button"
						class="nav-link"
						role="tab"
						data-bs-toggle="tab"
						data-bs-target="#navs-top-profile"
						aria-controls="navs-top-profile"
						aria-selected="false">
						Kompetensi Pegawai
					</button>
				</li>
			<?php endif; ?>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
				<table class="table table-sm table-responsive table-bordered table-hover w-100 align-top">
					<tr>
						<th width="20%">Tanggal</th>
						<td><?= CommonHelper::formatDate($data->created_at) ?></td>
					</tr>
					<tr>
						<th>Tipe Assessment</th>
						<td><?= QuestionnaireModel::listType()[$data->questionnaire_type] ?></td>
					</tr>
					<tr>
						<th>Grup</th>
						<td><?= $data->institution_group ?></td>
					</tr>
					<tr>
						<th>Instansi</th>
						<td>
							<?= ucwords($data->institution_type) . ' ' . $data->institution_name ?>
						</td>
					</tr>
					<tr>
						<th>Nama</th>
						<td>
							<?= $data->front_title . ' ' . $data->fullname ?><?= (!empty($data->back_title)) ? ', ' . $data->back_title : '' ?>
						</td>
					</tr>
					<tr>
						<th>Status</th>
						<td><?= SurveyModel::listStatus()[$data->survey_status] ?></td>
					</tr>
					<tr>
						<th>Histori</th>
						<td>
							<?php if (!empty($approval_history)): ?>
								<ul>
									<li>
										<b><?= $approval_history['datetime'] ?></b>
										direspons oleh: <?= $approval_history['user_name'] ?> <br>
										<?= $approval_history['remark'] ?>
									</li>
								</ul>
							<?php else: ?>
								-
							<?php endif; ?>
						</td>
					</tr>
				</table>
			</div>
			<?php if (in_array($data->questionnaire_type, QuestionnaireModel::listIndividual())): ?>
				<div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
					<table class="table table-stripped">
						<tr>
							<th>No</th>
							<th>Uraian Tugas</th>
							<th>Pengembangan Kompetensi</th>
							<th width="23%">Status</th>
						</tr>
						<?php foreach ($competence as $key => $each): ?>
							<tr>
								<td><?= $key + 1 ?></td>
								<td><?= $each['job_description'] ?></td>
								<td><?= $each['nama_pelatihan'] ?></td>
								<td>
									<button type="button" class="btn rounded-pill toggle-status <?= $each['status'] == 1 ? 'btn-success' : 'btn-danger'; ?>" style="pointer-events: none">
										<?= $each['status'] == 1 ? 'Sudah Mengikuti' : 'Belum Mengikuti' ?>
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<br>

	<div class="card">
		<div class="card-header">
			<h5>Hasil Assessment / Penilaian</h5>
		</div>
		<div class="card-body">
			<div class="table-container">
				<div class="x-scroll fixed-column-table">
					<table class="table table-bordered table-responsive" width="100%">
						<thead>
							<tr>
								<th class="sticky-col first-col">No</th>
								<th class="sticky-col second-col">Pertanyaan</th>
								<?php if (!$is_institution): ?>
									<th class="sticky-col third-col">Disetujui</th>
								<?php endif; ?>
								<th>Jawaban</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($detail as $key => $each):
								$temp = $answer[$key];
								krsort($temp);
								$max_key = max(array_keys($temp));
								$bg_color = ($each['approved_answer'] != NULL) && ($each['approved_answer'] != $temp[$max_key]) ? 'pink !important' : 'white !important' ?>
								<tr>
									<td class="sticky-col first-col"><?= $key + 1 ?></td>
									<td class="sticky-col second-col"><?= $each['question'] ?></td>
									<?php if (!$is_institution): ?>
										<td class="sticky-col third-col" style="background-color: <?= $bg_color ?>;"><?= $each['approved_answer'] ?? '-' ?></td>
									<?php endif; ?>
									<?php foreach ($temp as $datetime => $value): ?>
										<td>
											<b><?= CommonHelper::formatDate($datetime, 2) . '</b><br>' . esc($value) ?>
										</td>
									<?php endforeach; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>