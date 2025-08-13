<?php

use App\Helpers\CommonHelper;
?>

<?= $this->extend('layout/main') ?>
<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<div class="card-header d-flex">
			<?= $title ?>
			<div class="ms-auto">
				<a href="https://docs.google.com/spreadsheets/d/1NghDs19tL6ff5eqFy-P0wEk0CtQH4l4C/edit?usp=sharing&ouid=100181077883614027034&rtpof=true&sd=true"
					class="btn btn-sm btn-primary float-right" target="_blank">Pelatihan Terakreditasi Ditmutu</a>
			</div>
		</div>
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
					Tidak ada survei yang sedang aktif. Mohon hubungi pihak Murnajati.
				</div>
			<?php else: ?>
				<?= view('survey/_form_survey') ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>