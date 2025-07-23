<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TNA - Murnajati</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
	<div class="container">
		<h1>Daftar Survey</h1>
		<div class="card">
			<div class="card-header">
				Daftar Survey
			</div>
			<div class="card-body">
				<?php if (session()->getFlashdata('error')): ?>
					<div class="alert alert-danger">
						<?= session()->getFlashdata('error') ?>
					</div>
				<?php elseif (session()->getFlashdata('success')): ?>
					<div class="alert alert-success">
						<?= session()->getFlashdata('success') ?>
					</div>
				<?php endif; ?>

				<table class="table table-responsive table-bordered table-hover w-100">
					<tr>
						<th class="text-center">No</th>
						<th>Tanggal</th>
						<th>Instansi</th>
						<th>NIP</th>
						<th>Nama</th>
						<th>Action</th>
					</tr>
					<?php foreach ($data as $key => $each): ?>
						<tr>
							<td class="text-center"><?= $key + 1 ?></td>
							<td><?= $each['created_at'] ?></td>
							<td></td>
							<td><?= $each['citizen_id'] ?></td>
							<td><?= $each['responden'] ?></td>
							<td></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</html>