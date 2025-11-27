<?= $this->extend('layout/main') ?>
<?= $this->section('content'); ?>
<?php
$params = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
?>

<div class="container">
	<h3><?= $title ?></h3>
	<div class="card">
		<div class="card-header">
			<h5>Pencarian</h5>
		</div>
		<div class="card-body">
			<form action="<?= current_url() ?>" method="get">
				<div class="col-12 row">
					<div class="col-6">
						<label class="form-label">Instansi</label>
						<select class="select2 form-select" name="institution_id" id="institution_id">
							<option value="">Pilih Instansi</option>
							<?php foreach ($institution as $each): ?>
								<option value="<?= $each['id'] ?>" <?= ($each['id'] == ($_GET['institution_id'] ?? '')) ? 'selected' : ''; ?>>
									<?= $each['name'] ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-6">
						<label class="form-label">Tahun</label>
						<select class="form-select" name="plan_year">
							<option value="">Pilih Tahun</option>
							<?php foreach ($years as $each): ?>
								<option value="<?= $each ?>"
									<?= ((!isset($_GET['plan_year'])) && (date('Y') + 1 == $each)) ||
										(isset($_GET['plan_year']) && $_GET['plan_year'] == $each) ? 'selected' : '' ?>>
									<?= $each ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-12 text-end mt-2">
						<button type="submit" class="btn btn-sm btn-primary">Cari</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<br>

	<div class="card">
		<div class="card-header">
			<h5>Laporan Rekapitulasi</h5>
			<a href="<?= url_to('report.xlsTrainingNeedsSummary') . $params ?>" class="btn btn-sm btn-primary">Export Data</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-sm table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th style="min-width: 15em;">Instansi</th>
							<th style="min-width: 15em;">Nama</th>
							<th style="min-width: 15em;">NIP</th>
							<th>Pendidikan Terakhir</th>
							<th>Jabatan</th>
							<th>Bidang/Seksi/Subbag</th>
							<th style="min-width: 25em;">SKP / Uraian Tugas</th>
							<th style="min-width: 25em;">Kompetensi (Pelatihan / Peningkatan Kompetensi) yang sudah diikuti</th>
							<th style="min-width: 25em;">Kompetensi (Pelatihan / Peningkatan Kompetensi) yg belum diikuti</th>
							<th>Analisa Kesenjangan Kompetensi</th>
							<th style="min-width: 25em;">Rencana Pengembangan Kompetensi yang Dibutuhkan</th>
							<th>Tahun Usulan</th>
						</tr>
					</thead>
					<?php if (empty($data)): ?>
						<tr>
							<td colspan="13" class="text-center">
								<i>Tidak ada data</i>
							</td>
						</tr>
					<?php endif; ?>
					<tbody>
						<?php foreach ($data as $key => $each): ?>
							<tr>
								<td><?= $key + 1 ?></td>
								<td><?= ucwords(strtolower($each['institution_type'] . ' ' . $each['institution_name'])) ?></td>
								<td><?= $each['fullname'] ?></td>
								<td><?= $each['nip'] ?></td>
								<td><?= $each['jenjang_pendidikan'] ?></td>
								<td><?= $each['jurusan_profesi'] ?></td>
								<td><?= $detail[$each['survey_id']]['work_unit'] ?></td>
								<td>- <?= trim($competence[$each['survey_id']]['job_description']) ?></td>
								<td>- <?= trim($competence[$each['survey_id']]['training_complete']) ?></td>
								<td>- <?= trim($competence[$each['survey_id']]['training_incomplete']) ?></td>
								<td><?= $detail[$each['survey_id']]['gap_competency'] ?></td>
								<td><?= $each['nama_pelatihan'] ?></td>
								<td><?= $each['plan_year'] ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>