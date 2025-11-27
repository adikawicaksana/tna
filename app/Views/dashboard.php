<?= $this->extend('layout/main') ?>


<?= $this->section('css') ?>

<!-- Page CSS -->
<link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/cards-advance.css') ?>" />

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row g-6">

    <!-- Support Tracker -->
    <div class="col-12">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title mb-0">
            <h5 class="mb-1">Rekap Kompetensi</h5>
          </div>
        </div>
        <div class="card-body row">
          <div class="col-12 col-sm-4">
            <div class="mt-lg-4 mt-lg-2 mb-lg-6 mb-2">
              <h2 class="mb-0" id="total-incomplete"></h2>
              <p class="mb-0">Belum Terpenuhi</p>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                <div class="badge rounded bg-label-info p-1_5">
                  <i class="icon-base ti tabler-circle-check icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-nowrap">Sudah Disetujui</h6>
                  <small class="text-body-secondary" id="approved"></small>
                </div>
              </li>
              <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
                <div class="badge rounded bg-label-primary p-1_5">
                  <i class="icon-base ti tabler-ticket icon-md"></i>
                </div>
                <div>
                  <h6 class="mb-0 text-nowrap">Proses Pengajuan</h6>
                  <small class="text-body-secondary" id="submitted"></small>
                </div>
              </li>
            </ul>
          </div>
          <div class="col-12 col-md-8">
            <div id="supportTracker"></div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Support Tracker -->
  </div>
</div>
<!-- / Content -->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Page JS -->
<script>
  const urlCompetencyPercentage = "<?= url_to('getCompetencyPercentage') ?>";
  const urlIncompleteCompetence = "<?= url_to('countIncompleteCompetence') ?>";
</script>
<script src="<?= base_url('assets/js/dashboards-analytics.js') ?>"></script>

<?php /*
<script>
  function refreshTokenHeartbeat() {
      fetch('/refresh-token', {
        method: 'POST',
        credentials: 'include'
      })
      .then(response => {
        if (!response.ok) {
          window.location.href = '/login';
          return;
        }
        return response.json();
      })
      .then(data => {
        if (data?.access_token) {
          console.log('Token diperbarui otomatis');
        }
      })
      .catch(() => {
        window.location.href = '/login';
      });
    }

    // Jalankan tiap 10 menit
    setInterval(refreshTokenHeartbeat, 10 * 60 * 1000);
</script>
*/ ?>
<?= $this->endSection() ?>