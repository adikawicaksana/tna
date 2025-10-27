<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-profile.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/chartjs/chartjs.css') ?>" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$selectedYear = $_GET['y'] ?? date('Y');
?>

<!-- Content -->
           <div class="container-xxl flex-grow-1 container-p-y">
            
    <?php if($data['institusi_detail']) {?>

	<div class="card">
        <div class="card-header">
            
	            <h3><?= $title ?></h3>
            <div class="row">
                    <div class="col-xl-9 gap-2 mb-4">
             <select name="institusi" id="institusi" class="form-select select2">
                <?php foreach ($data['institusi'] as $i): ?>
                    <option value="<?= esc($i['id']) ?>"
                        <?= $i['id'] === $data['institusi_selected'] ? 'selected' : '' ?>>
                        <?=  $i['type'] !== 'rumahsakit' ? strtoupper($data['institusi_detail']['type']) : '' ?> <?= esc($i['name']) ?>
                    </option>
                <?php endforeach; ?>
                </select>
                    </div>
                    <div class="col-xl-3">
                        <select name="survey_year" id="survey_year" class="form-select">
                            <?php foreach ($data['years'] as $key => $each): ?>
                                <?php $selected = ($key == $selectedYear) ? 'selected' : ''; ?>
                                <option value="<?= esc($key) ?>" <?= $selected ?>>
                                    <?= esc($each) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    </div>
        </div>
		<div class="card-body">


           <!-- Statistics -->

                            <div class="row">
                            <!-- Informasi Institusi -->
                            <div class="col-md-4 mb-4">
                                <table class="table-borderless m-0">
                                    <tr>
                                        <td class="align-top"><i class="menu-icon icon-base ti tabler-building"></i></td>
                                        <td class="align-top"><?= $data['institusi_detail']['name'] ?></td>
                                    </tr>
                                    <?php if (!empty($data['institusi_detail']['type'])): ?>
                                    <tr>
                                        <td class="align-top"><i class="menu-icon icon-base ti tabler-category-plus"></i></td>
                                        <td class="align-top"><?= $data['institusi_detail']['type'] === 'rumahsakit' ? 'RUMAH SAKIT' : strtoupper($data['institusi_detail']['type']) ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td class="align-top"><i class="menu-icon icon-base ti tabler-map-pin"></i></td>
                                        <td class="align-top">
                                            <?= trim(($data['institusi_detail']['address'] ? $data['institusi_detail']['address'] . ', ' : '') .
                                                    ($data['institusi_detail']['district_name'] ? 'Kec. ' . $data['institusi_detail']['district_name'] . ', ' : '') .
                                                    ($data['institusi_detail']['regencies_name'] ? $data['institusi_detail']['regencies_name'] . ', ' : '') .
                                                    ($data['institusi_detail']['provinces_name'] ?? ''), ', ') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><i class="menu-icon icon-base ti tabler-map"></i></td>
                                        <td class="align-top">
                                            <a href="https://www.google.com/maps?q=<?= $data['institusi_detail']['latitude'] ?>,<?= $data['institusi_detail']['longitude'] ?>" target="_blank" rel="noopener noreferrer">
                                                <?= "Latitude: ".$data['institusi_detail']['latitude']."; Longitude: ".$data['institusi_detail']['longitude']; ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><i class="menu-icon icon-base ti tabler-user"></i></td>
                                        <td class="align-top">Pengelola Data:<br>
                                            <ul>
                                            <?php foreach ($data['pengelola'] as $key => $each): ?>
                                                   <li> <?= $each['fullname'] ?> </li>
                                            <?php endforeach; ?>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Doughnut Chart -->
                            <div class="col-md-3 d-flex justify-content-center align-items-center mb-4">
                                <div class="col-md-7 d-flex justify-content-center align-items-center">
                                    <canvas id="doughnutChart" class="chartjs mb-6" data-height="150"></canvas>
                                </div>
                            </div>

                            <!-- Statistik User -->
                            <div class="col-md-2 mb-4">
                                <?php
                                $stats = [
                                    ['label'=>'Terdaftar','value'=>$data['total_users_institusi'],'bg'=>'primary','icon'=>'tabler-users'],
                                    ['label'=>'Sudah Assessment','value'=>$data['total_users_survey'],'bg'=>'info','icon'=>'tabler-user'],
                                    ['label'=>'Belum Assessment','value'=>($data['total_users_institusi']-$data['total_users_survey']),'bg'=>'danger','icon'=>'tabler-user']
                                ];
                                ?>
                                <?php foreach($stats as $s): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="badge rounded bg-label-<?= $s['bg'] ?> me-3 p-2">
                                        <i class="icon-base ti <?= $s['icon'] ?> icon-lg"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0"><?= ($s['value'] < 0) ? 0 : $s['value'] ?></h5>
                                        <small><?= $s['label'] ?></small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Tombol Survey -->
                            <div class="col-md-3 mb-4">
                                
                              

                            </div>

                        </div> <!-- end row -->

            <!--/ Statistics -->

        <div class="row">
            <div class="col-md-12 mb-6">
                <table id="dataTable" class="table table-responsive table-bordered table-hover w-100">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Tanggal</th>
						<th>Grup</th>
						<th>Instansi</th>
						<th>Nama</th>
						<th>Status</th>
						<th>Tanggal Disetujui</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
            </div>
        </div>


		</div>
	</div>
     <?php } ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <!-- Page JS -->
    <script src="<?= base_url('assets/vendor/libs/chartjs/chartjs.js') ?>"></script>

    <script>
    const baseUrl = window.location.href;

    	$(document).ready(function () {
            var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "<?= current_url() ?>",
                type: "GET",
                data: function (d) {
                    d.id = $('#institusi').val();
                    d.year = $('#survey_year').val();
                },
                error: function (xhr, error, code) {
                    console.error("AJAX Error:", xhr.responseText);
                }
            },
            columns: [
                { data: "no", name: "no", orderable: false, searchable: false },
                { data: "created_at" },
                { data: "institution_category" },
                { data: "institution_name" },
                { data: "fullname" },
                { data: "survey_status" },
                { data: "approved_at" },
                { data: "action", orderable: false, searchable: false }
            ],
            columnDefs: [
                {
                    targets: [0],
                    className: 'text-center',
                }
            ],
        });
	});

    $('#institusi').on('change', function () {
        const id = $(this).val();
        const year = $('#survey_year').val();
        const baseUrl = window.location.origin + window.location.pathname; 

        if (id) {
            window.location.href = `${baseUrl}?ic=${id}&yc=${year}`;
        }
    });

    $('#survey_year').on('change', function () {
        const id = $(this).val();
        const year = $('#survey_year').val();
        const baseUrl = window.location.origin + window.location.pathname; 
        if (year) {
            window.location.href = `${baseUrl}?ic=${$('#institusi').val()}&yc=${year}`;
        }
    });

const primary = window.Helpers.getCssVar('primary', true);
const info  = window.Helpers.getCssVar('info', true);
const danger  = window.Helpers.getCssVar('danger', true);
const cardColor = window.Helpers.getCssVar('paper-bg', true);
const headingColor = window.Helpers.getCssVar('heading-color', true);
const legendColor = window.Helpers.getCssVar('body-color', true);
const borderColor = window.Helpers.getCssVar('border-color', true);

document.querySelectorAll('.chartjs').forEach(chart => {
  chart.height = chart.dataset.height;
});

const doughnutChart = document.getElementById('doughnutChart');
if (doughnutChart) {
  new Chart(doughnutChart, {
    type: 'doughnut',
    data: {
      labels: ['Belum Asesmen', 'Sudah Asesmen'],
      datasets: [{
        data: [<?= ($data['total_users_institusi']-$data['total_users_survey']); ?>,<?= $data['total_users_survey']; ?>],
        backgroundColor: [danger, info],
        borderWidth: 0,
        pointStyle: 'rectRounded'
      }]
    },
    options: {
      responsive: true,
      animation: { duration: 500 },
      cutout: '50%',
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.parsed;
              return ' ' + label + ' : ' + value ;
            }
          },
          rtl: isRtl,
          backgroundColor: cardColor,
          titleColor: headingColor,
          bodyColor: legendColor,
          borderWidth: 1,
          borderColor: borderColor
        }
      }
    }
  });
}

    </script>

<?= $this->endSection() ?>