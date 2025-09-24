<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-profile.css') ?>" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Content -->
           <div class="container">
	<h1><?= $title ?></h1>
    <?php if($data['kabkota_detail']) {?>
	<div class="card">
        <div class="card-header">
             <select name="kabkota" id="kabkota" class="form-select select2">
                <?php foreach ($data['kabkota'] as $i): ?>
                    <option value="<?= esc($i['id']) ?>"
                        <?= $i['id'] === $data['kabkota_selected'] ? 'selected' : '' ?>>
                        <?= ($i['type'] === 'rumahsakit' ? '' : strtoupper($i['type'])) ?>
                        <?= esc($i['name']) ?>
                    </option>
                <?php endforeach; ?>
                </select>
        </div>  
		<div class="card-body">

        
          <div class="row">
            <div class="col-md-12 mb-6">
                <table>
                <tr>
                    <td><i class="menu-icon icon-base ti tabler-building"></i></td>
                    <td><?php echo $data['kabkota_detail']['name'] ?></td>
                </tr>
                </table>
            </div>
          </div>


           <!-- Statistics -->
            <div class="col-xl-12 col-md-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                <!-- <h5 class="card-title mb-0">Statistics</h5>
                <small class="text-body-secondary">Updated 1 month ago</small> -->
                </div>
                <div class="card-body d-flex align-items-end">
                <div class="w-100">
                    <div class="row gy-3">
                    <div class="col-md-4 col-6">
                        <div class="d-flex align-items-center">
                        <div class="badge rounded bg-label-primary me-4 p-2"><i class="icon-base ti tabler-users icon-lg"></i></div>
                        <div class="card-info">
                            <h5 class="mb-0"><?= esc($data['jumlah_user_institusi']) ?></h5>
                            <small>Terdaftar</small>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="d-flex align-items-center">
                        <div class="badge rounded bg-label-info me-4 p-2"><i class="icon-base ti tabler-user icon-lg"></i></div>
                        <div class="card-info">
                            <h5 class="mb-0">25</h5>
                            <small>Sudah Assessment</small>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="d-flex align-items-center">
                        <div class="badge rounded bg-label-danger me-4 p-2"><i class="icon-base ti tabler-user icon-lg"></i></div>
                        <div class="card-info">
                            <h5 class="mb-0">25</h5>
                            <small>Belum Assessment</small>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
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

    <script>
    const baseUrl = "<?= base_url('institusi') ?>";

    $('#institusi').on('change', function () {
        const id = $(this).val();  
        if (id) {
            window.location.href = `${baseUrl}/${id}`;
        }
    });
    </script>
    
<?= $this->endSection() ?>