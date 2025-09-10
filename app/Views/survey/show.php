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
  width: max-content; /* Supaya bisa scroll ke kanan */
  min-width: 100%;
}
.sticky-col {
  position: sticky;
  left: 0;
  background-color: #f8f9fa; /* Bootstrap light gray */
  z-index: 2;
}
.first-top {
	left: 0;
	z-index: 10;
}
.second-col {
	left: 10;
	z-index: 10;
}
.third-col {
	left: 20;
	z-index: 10;
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
			<div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
				<table class="table table-stripped">
					<tr>
						<th>No</th>
						<th>Uraian Tugas</th>
						<th>Pengembangan Kompetensi</th>
						<th>Status</th>
					</tr>
					<?php foreach($competence as $key => $each): ?>
						<tr>
							<td><?= $key+1 ?></td>
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
		</div>
	</div>
	<br>

	<div class="card">
		<div class="card-header">
			<h5>Hasil Assessment / Penilaian</h5>
		</div>
		<div class="card-body">
			<div class="table-container">
				<div class="table-responsive x-scroll text-nowrap fixed-column-table">
					<table class="table table-bordered" width="100%">
						<thead>
							<tr>
								<th class="sticky-col first-col">No</th>
								<th class="sticky-col second-col">Pertanyaan</th>
								<th class="sticky-col third-col">Disetujui</th>
								<th>Jawaban</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($detail as $key => $each):
								$temp = $answer[$key]; ?>
								<tr>
									<td><?= $key+1 ?></td>
									<td><?= $each['question'] ?></td>
									<td><?= $each['approved_answer'] ?></td>
									<?php foreach ($temp as $datetime => $value): ?>
										<td><?= $datetime . '<br>' . $value ?></td>
									<?php endforeach; ?>
									<?php foreach ($temp as $datetime => $value): ?>
										<td><?= $datetime . '<br>' . $value ?></td>
									<?php endforeach; ?><?php foreach ($temp as $datetime => $value): ?>
										<td><?= $datetime . '<br>' . $value ?></td>
									<?php endforeach; ?><?php foreach ($temp as $datetime => $value): ?>
										<td><?= $datetime . '<br>' . $value ?></td>
									<?php endforeach; ?><?php foreach ($temp as $datetime => $value): ?>
										<td><?= $datetime . '<br>' . $value ?></td>
									<?php endforeach; ?><?php foreach ($temp as $datetime => $value): ?>
										<td><?= $datetime . '<br>' . $value ?></td>
									<?php endforeach; ?><?php foreach ($temp as $datetime => $value): ?>
										<td><?= $datetime . '<br>' . $value ?></td>
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