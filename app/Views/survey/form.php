<?= $this->extend('layout/main') ?>
<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<?php /*
		<div class="card-header d-flex">
			<?= $title ?>
			<div class="ms-auto">
				<a href="<?= url_to('master-training.index') ?>"
					class="btn btn-sm btn-primary float-right" target="_blank">Pelatihan Terakreditasi Ditmutu</a>
			</div>
		</div>
		*/ ?>
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
					Tidak ada assessment / penilain yang sedang aktif. Mohon hubungi pihak Murnajati.
				</div>
			<?php else: ?>
				<?= view('survey/_form_survey') ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>