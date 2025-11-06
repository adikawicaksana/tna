<?= $this->extend('layout/main') ?>

<?= $this->section('content'); ?>
<div class="container">
	<h3><?= $title ?></h3>
	<div class="card">
		<div class="card-header">
			<h5><?= $title ?></h5>
		</div>
		<div class="card-body">
			<table id="dataTable" class="table table-sm table-bordered table-hover w-100">
				<thead>
					<tr>
						<th class="text-center" width="5%">No</th>
						<th>Pengguna</th>
						<th>Instansi</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<script>
	const base_url = "<?= base_url() ?>";
	$(document).ready(function() {
		$('#dataTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: "<?= route_to('usersManager.getManager') ?>",
				type: "GET"
			},
			columns: [{
					data: "no",
					name: "no",
					orderable: false,
					searchable: false
				},
				{
					data: "fullname"
				},
				{
					data: "institution_name"
				},
				{
					data: "user_id",
					render: function(data, type, row) {
						return renderAction(data);
					},
					orderable: false,
					searchable: false
				}

			],
			columnDefs: [{
				targets: [0, 3],
				className: 'text-center',
			}],
			order: [[1, 'ASC'], [2, 'ASC']],
		});
	});

	function renderAction(userId) {
		return `<a href="${base_url}admin/usersManager/${userId}"
			class="btn btn-outline-info btn-sm p-2"><i class="fas fa-eye"></i></a>`;
	}
</script>
<?= $this->endSection(); ?>