<?php

use App\Helpers\CommonHelper;
use App\Models\QuestionnaireModel;
use App\Models\SurveyModel;

?>
<?= $this->extend('layout/main') ?>
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
		box-shadow: 2px 0 5px rgba(0,0,0,0.1);
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
										<?= $approval_history['user_id'] ?> <br>
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

	<?= view('survey/_form_approval') ?>
</div>
<?= $this->endSection(); ?>