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
						<select class="select2 form-select" name="institution_id" id="institution_id" data-allow-clear="true">
							<option value=""></option>
							<?php foreach ($institution as $each): ?>
								<option value="<?= $each['id'] ?>" <?= ($each['id'] == ($_GET['institution_id'] ?? '')) ? 'selected' : ''; ?>>
									<?= $each['name'] ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-6">
						<label class="form-label">Tahun Usulan</label>
						<select class="form-select" name="plan_year">
							<option value="" <?= (!isset($_GET['plan_year']) || empty($_GET['plan_year'])) ? 'selected' : '' ?>>Pilih Tahun</option>
							<?php foreach ($years as $each): ?>
								<option value="<?= $each ?>"
									<?= (isset($_GET['plan_year']) && $_GET['plan_year'] == $each) ? 'selected' : '' ?>>
									<?= $each ?>
								</option>
							<?php endforeach; ?>
						</select>
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
			<a href="<?= route_to('report.xlsTrainingNeedsSummary2') . $params ?>" class="btn btn-sm btn-primary">Export Data</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-sm table-bordered table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Instansi</th>
							<th>Nama Pelatihan</th>
							<th>Pegawai yang Membutuhkan</th>
							<th>Tahun Usulan</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data as $key => $each): ?>
							<tr>
								<td><?= $key + 1 ?></td>
								<td><?= $each['institution_name'] ?></td>
								<td><?= $each['nama_pelatihan'] ?></td>
								<td><?= $each['fullname'] ?></td>
								<td><?= $each['plan_year'] ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php /*
<script>
	$(document).ready(function() {
		const url_institution = 'http://localhost/api/institution2';
		console.log(url_institution);

		$('#institution_id').select2({
			placeholder: 'Pilih instansi',
			allowClear: true,
			minimumInputLength: 1,
			ajax: {
				url: url_institution,
				dataType: 'json',
				type: 'get',
				delay: 250,
				data: function(params) {
					console.log('User input:', params.term);
					return {
						q: params.term
					};
				},
				processResults: function(data) {
					console.log(data);
					return {
						results: data.map(function(item) {
							return {
								id: item.id,
								text: item.name
							};
						})
					};
				},
				cache: true,
			},

			// data: [{
			// 		id: '',
			// 		text: '',
			// 	},
			// 	{
			// 		id: 1,
			// 		text: 'Test Option 1'
			// 	},
			// 	{
			// 		id: 2,
			// 		text: 'Test Option 2'
			// 	}
			// ],
		})
	})
</script>
*/ ?>
<?= $this->endSection() ?>