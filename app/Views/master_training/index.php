<?= $this->extend('layout/main') ?>

<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<div class="card-header">
			<h5><?= $title ?></h5>
			<?php /* <a href="<?= url_to('question.create') ?>" class="btn btn-sm btn-primary">Tambah Baru</a> */ ?>
			<p>Update Terakhir: 04 September 2025</p>
		</div>
		<div class="card-body">
			<table id="dataTable" class="table table-sm table-responsive table-bordered table-hover w-100">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Kategori</th>
						<th>Jenis</th>
						<th>Nama</th>
						<th>Pengusul</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('#dataTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: "<?= current_url() ?>",
				type: "GET"
			},
			columns: [
				{ data: "no", name: "no", orderable: false, searchable: false },
				{ data: "kategori_pelatihan" },
				{ data: "jenis_pelatihan" },
				{ data: "nama_pelatihan" },
				{ data: "instansi_pengusul" },
				{ data: "action", orderable: false, searchable: false }
			],
			columnDefs: [{
				targets: [0],
				className: 'text-center',
			}],
		});
	});
</script>
<?= $this->endSection(); ?>