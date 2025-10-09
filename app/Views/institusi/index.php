<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-profile.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/chartjs/chartjs.css') ?>" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Content -->
           <div class="container">
	<h1><?= $title ?></h1>
    <?php if($data['institusi_detail']) {?>
	<div class="card">
        <div class="card-header">
            <div class="row">
                    <div class="col-xl-9">                        
             <select name="institusi" id="institusi" class="form-select select2">
                <?php foreach ($data['institusi'] as $i): ?>
                    <option value="<?= esc($i['id']) ?>"
                        <?= $i['id'] === $data['institusi_selected'] ? 'selected' : '' ?>>
                        <?= ($i['type'] === 'rumahsakit' ? '' : strtoupper($i['type'])) ?>
                        <?= esc($i['name']) ?>
                    </option>
                <?php endforeach; ?>
                </select>
                    </div>
                    <div class="col-xl-3">
                        <select name="training_plan_year" id="training_plan_year" class="form-select">
                            <option value="-" disabled selected>Pilih Tahun</option>
                            <?php foreach ($data['years'] as $key => $each):
                                $selected = ((old('training_plan_year') ?? NULL) == $key) ? 'selected' : ''; ?>
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
            <div class="col-xl-12 col-md-12">
                <div class="card h-100">
                        <div class="row gx-3 gy-3"> <!-- gx = gutter horizontal, gy = gutter vertical -->
                            <!-- Informasi Institusi -->
                            <div class="col-xl-4 col-md-6">
                                <table class="table-borderless m-0">
                                    <tr>
                                        <td><i class="menu-icon icon-base ti tabler-building"></i></td>
                                        <td><?= $data['institusi_detail']['name'] ?></td>
                                    </tr>
                                    <?php if (!empty($data['institusi_detail']['type'])): ?>
                                    <tr>
                                        <td><i class="menu-icon icon-base ti tabler-category-plus"></i></td>
                                        <td><?= $data['institusi_detail']['type'] === 'rumahsakit' ? 'RUMAH SAKIT' : strtoupper($data['institusi_detail']['type']) ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td><i class="menu-icon icon-base ti tabler-map-pin"></i></td>
                                        <td><?= $data['institusi_detail']['address'].", Kec.".$data['institusi_detail']['district_name'].", ".$data['institusi_detail']['regencies_name'].", ".$data['institusi_detail']['provinces_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="menu-icon icon-base ti tabler-map"></i></td>
                                        <td>
                                            <a href="https://www.google.com/maps?q=<?= $data['institusi_detail']['latitude'] ?>,<?= $data['institusi_detail']['longitude'] ?>" target="_blank" rel="noopener noreferrer">
                                                <?= "Latitude: ".$data['institusi_detail']['latitude']."; Longitude: ".$data['institusi_detail']['longitude']; ?>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Doughnut Chart -->
                            <div class="col-xl-3 col-md-6 d-flex justify-content-center align-items-center">
                                <div class="col-xl-7 d-flex justify-content-center align-items-center">
                                    <canvas id="doughnutChart" class="chartjs mb-6" data-height="150"></canvas>             
                                </div>                                               
                            </div>

                            <!-- Statistik User -->
                            <div class="col-xl-2 col-md-6">
                                <?php 
                                $stats = [
                                    ['label'=>'Terdaftar','value'=>$data['jumlah_user_institusi'],'bg'=>'primary','icon'=>'tabler-users'],
                                    ['label'=>'Sudah Assessment','value'=>25,'bg'=>'info','icon'=>'tabler-user'],
                                    ['label'=>'Belum Assessment','value'=>25,'bg'=>'danger','icon'=>'tabler-user']
                                ];
                                ?>
                                <?php foreach($stats as $s): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="badge rounded bg-label-<?= $s['bg'] ?> me-3 p-2">
                                        <i class="icon-base ti <?= $s['icon'] ?> icon-lg"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0"><?= $s['value'] ?></h5>
                                        <small><?= $s['label'] ?></small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Tombol Survey -->
                            <div class="col-xl-3 col-md-6 gap-2">
                                <h5 class="card-title mb-2">Formulir Asesmen Institusi 🎉</h5>
                                <?php foreach ($data['questionnaire_type'] as $key => $each): ?>
                                <a href="<?= url_to('survey.create', $key) ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> &nbsp; <?= $each ?>
                                </a>
                                <?php endforeach; ?>
                            </div>

                        </div> <!-- end row -->
                </div> <!-- end card -->
            </div>

            <!--/ Statistics -->

        <div class="row">
            <div class="col-md-6 mb-6">
                
            </div>

            <div class="col-md-6 mb-6">
            </div>
        </div>
          
            
		</div>
	</div> <?php } ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <!-- Page JS -->
    <script src="<?= base_url('assets/js/pages-auth-multisteps.js') ?>"></script>
    <script src="<?= base_url('assets/js/app-user-view-account.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/chartjs/chartjs.js') ?>"></script>

    <script>
    const baseUrl = "<?= base_url('institusi') ?>";

    $('#training_plan_year').select2({
        placeholder: "Pilih Tahun",
        allowClear: true, // jika ingin bisa clear pilihan
        width: '100%'     // optional agar full-width
    });

    $('#institusi').on('change', function () {
        const id = $(this).val();  
        if (id) {
            window.location.href = `${baseUrl}?i=${id}`;
        }
    });

   // ============================
// Warna Chart
// ============================
const primary = window.Helpers.getCssVar('primary', true);
const info  = window.Helpers.getCssVar('info', true);
const danger  = window.Helpers.getCssVar('danger', true);
const cardColor = window.Helpers.getCssVar('paper-bg', true);
const headingColor = window.Helpers.getCssVar('heading-color', true);
const legendColor = window.Helpers.getCssVar('body-color', true);
const borderColor = window.Helpers.getCssVar('border-color', true);

// ============================
// Set height canvas dari data-height
// ============================
document.querySelectorAll('.chartjs').forEach(chart => {
  chart.height = chart.dataset.height;
});

// ============================
// Doughnut Chart
// ============================
const doughnutChart = document.getElementById('doughnutChart');
if (doughnutChart) {
  new Chart(doughnutChart, {
    type: 'doughnut',
    data: {
      labels: ['Belum Asesmen', 'Sudah Asesmen'],
      datasets: [{
        data: [2,120],
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