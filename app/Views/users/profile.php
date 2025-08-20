<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-profile.css') ?>" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Header -->
              <div class="row">
                <div class="col-12">
                  <div class="card mb-6">
                    <div class="user-profile-header-banner">
                      <img src="../../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top" />
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                      <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img
                          src="../../assets/img/avatars/1.png"
                          alt="user image"
                          class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
                      </div>
                      <div class="flex-grow-1 mt-3 mt-lg-5">
                        <div
                          class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                          <div class="user-profile-info">
                            <h4 class="mb-2 mt-lg-6"><?= esc($data['front_title']) ?> <?= esc($data['fullname']) ?>, <?= esc($data['back_title']) ?></h4>
                            <ul
                              class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">                              
                              <li class="list-inline-item d-flex gap-2 align-items-center">
                                <i class="icon-base ti tabler-map-pin icon-lg"></i
                                ><span class="fw-medium"><?= esc($data['address']) ?>, <?= esc($data['users_kelurahan']) ?>, <?= esc($data['users_kecamatan']) ?>, <?= esc($data['users_kabkota']) ?>, <?= esc($data['users_provinsi']) ?></span>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Header -->

              <!-- User Profile Content -->
               <div class="row">
  <!-- Basic Layout -->
  <div class="col-xl">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">                      
      </div>
      <div class="card-body">
        <form action="<?= base_url('profile') ?>" method="POST">
          <div class="row">
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-nip">NIP</label>
              <input type="text" name="user_nip" class="form-control" id="basic-default-nip" value="<?= esc($data['nip']) ?>"/>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-nik">NIK</label>
              <input type="text" name="user_nik" class="form-control" id="basic-default-nik" value="<?= esc($data['nik']) ?>"/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-6">
              <label class="form-label" for="basic-default-fullname">Nama Lengkap (tanpa gelar)</label>
              <input type="text" name="user_fullname" class="form-control" id="basic-default-fullname" value="<?= esc($data['fullname']) ?>" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-front-title">Gelar Depan</label>
              <input type="text" name="user_front_title" class="form-control" id="basic-default-front-title" value="<?= esc($data['front_title']) ?>"/>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-back-title">Gelar Belakang</label>
              <input type="text" name="user_back_title" class="form-control" id="basic-default-back-title" value="<?= esc($data['back_title']) ?>"/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-6">
              <label class="form-label" for="MobileNumber">Nomor Telepon</label>
                      <div class="input-group">
                        <span class="input-group-text">(+62)</span>
                        <input type="text" id="MobileNumber" name="user_mobilenumber"
                          class="form-control multi-steps-mobile" placeholder="81 234 xxx xxx" value="<?= esc($data['mobile']) ?>"/>
                      </div>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-email">E-mail</label>
              <input type="email" name="user_email" class="form-control" id="basic-default-email" value="<?= esc($data['email']) ?>"/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-6">
          <label class="form-label" for="address">Alamat</label>                 
              <textarea name="user_address" class="form-control" ><?= esc($data['address']) ?></textarea>
          </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-6">
              <label class="form-label" for="Provinsi">Provinsi</label>
              <select name="user_provinces" id="provinsi" class="form-control">
                <? if($data['users_provinces']){ ?><option value="<?= esc($data['users_provinces']) ?>" selected><?= esc($data['users_provinsi']) ?></option><? } ?>
              </select>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="Kabupaten">Kabupaten / Kota</label>
              <select name="user_regencies" id="kabupaten" class="form-select">
                <? if($data['users_regencies']){ ?><option value="<?= esc($data['users_regencies']) ?>" selected><?= esc($data['users_kabkota']) ?></option><? } ?>
              </select>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6 mb-6">
                <label class="form-label" for="Kecamatan">Kecamatan</label>
                <select name="user_districts" id="kecamatan" class="form-control">
                <? if($data['users_districts']){ ?><option value="<?= esc($data['users_districts']) ?>" selected><?= esc($data['users_kecamatan']) ?></option><? } ?>
              </select>
              </div>
              <div class="col-md-6 mb-6">
                <label class="form-label" for="Kelurahan">Kelurahan / Desa</label>
                <select name="user_villages" id="kelurahan" class="form-select">
                <? if($data['users_villages']){ ?><option value="<?= esc($data['users_villages']) ?>" selected><?= esc($data['users_kelurahan']) ?></option><? } ?>
              </select>
              </div>
          </div>    
          <div class="row">
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-jenjang">Pendidikan Terkahir</label>
                <select id="jenjangPendidikan" name="user_jenjang_pendidikan" class="form-select select2">
                   <option value=""></option>
                    <?php foreach ($jenjangPendidikan as $key => $label): ?>
                        <option value="<?= esc($key) ?>" 
                            <?= isset($data['jenjang_pendidikan']) && $data['jenjang_pendidikan'] === $key ? 'selected' : '' ?>>
                            <?= esc($label) ?>
                        </option>
                        <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-nik">Jurusan / Profesi</label>
              <select id="jurusanProfesi" name="user_jurusan_profesi" class="form-select select2">
               <option value=""></option>
                    <?php foreach ($jurusanProfesi as $key => $label): ?>
                        <option value="<?= esc($key) ?>" 
                            <?= isset($data['jurusan_profesi']) && $data['jurusan_profesi'] === $key ? 'selected' : '' ?>>
                            <?= esc($label) ?>
                        </option>
                        <?php endforeach; ?>
              </select>
                <div id="jurusanManualWrapper" class="mb-3" style="display:none;">
                  <br>
                  <label for="jurusanManual" class="form-label">Masukkan Jurusan / Profesi</label>
                  <input type="text" id="jurusanManual" name="jurusan_profesi_manual" class="form-control" placeholder="Ketik jurusan/profesi">
                </div>
            </div>
          </div>  

          <div class="text-end">
          <!-- isi form -->
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

              <!--/ User Profile Content -->
            </div>

  <div class="container-xxl flex-grow-1 container-p-y">
  <!-- DataTable with Buttons -->
    <div class="card p-3">
  <div class="row">
    <!-- Fasyankes -->
    <div class="col-md-6 mb-6">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5>Fasyankes</h5>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalFasyankes">
          <i class="icon-base ti tabler-plus icon-sm me-1_5"></i> Fasyankes
        </button>
      </div>
      <div class="card-datatable table-responsive pt-0">
        <table class="table datatables-fasyankes">
          <thead>
            <tr>
              <th>No</th>
              <th>Fasyankes</th>
              <th>Alamat</th>
              <th></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

    <!-- Non Fasyankes -->
    <div class="col-md-6 mb-6">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5>Non-Fasyankes</h5>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalNonFasyankes">
          <i class="icon-base ti tabler-plus icon-sm me-1_5"></i> Non Fasyankes
        </button>
      </div>
      <div class="card-datatable table-responsive pt-0">
        <table class="table datatables-non-fasyankes">
          <thead>
            <tr>
              <th>No</th>
              <th>Non Fasyankes</th>
              <th>Alamat</th>
              <th></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<br>

<div class="card p-3">
  <div class="row">
    <!-- Uraian Tugas dan Pelatihan -->
    <div class="col-md-12 mb-6">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5>Uraian Tugas & Pelatihan</h5>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalUraianTugas">
          <i class="icon-base ti tabler-plus icon-sm me-1_5"></i></button>
      </div>
      <div class="card-datatable table-responsive pt-0">
        <table id="tableUraianTugas" class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Uraian Tugas</th>
              <th>Jumlah Pengembangan</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Fasyankes -->
<div class="modal fade" id="modalFasyankes" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="formFasyankes">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Fasyankes</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Kode Fasyankes</label>
            <div class="position-relative">
              <input type="text" name="fasyankes_code" id="fasyankes_code" class="form-control"
                placeholder="Cth.: 10000xxxxx" autocomplete="off" />
              <style>
                .autocomplete-overlay .item {
                  padding: 8px 16px;
                  cursor: pointer;
                  border-bottom: 1px solid #eee;
                }

                .autocomplete-overlay .item:last-child {
                  border-bottom: none;
                }

                .autocomplete-overlay .item:hover {
                  background-color: #f8f9fa;
                }
              </style>
              <!-- Dropdown suggestion -->
              <div id="suggestions" class="autocomplete-overlay border bg-white rounded-bottom shadow-sm"
                style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; display: none;">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Fasyankes</label>
            <input type="text" name="fasyankes_name" id="fasyankes_name" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="fasyankes_address" id="fasyankes_address" class="form-control" readonly></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Non-Fasyankes -->
<div class="modal fade" id="modalNonFasyankes" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="formNonFasyankes">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Non-Fasyankes</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Institusi Non Fasyankes</label>            
            <div class="position-relative">
              <input type="hidden" name="nonfasyankes_id" id="nonfasyankes_id" class="form-control"
                autocomplete="off" />
              <input type="text" name="nonfasyankes_name" id="nonfasyankes_name" class="form-control"
                placeholder="Cth.: UPT Murnajati" autocomplete="off" />
              <style>
                .autocomplete-overlay .item {
                  padding: 8px 16px;
                  cursor: pointer;
                  border-bottom: 1px solid #eee;
                }

                .autocomplete-overlay .item:last-child {
                  border-bottom: none;
                }

                .autocomplete-overlay .item:hover {
                  background-color: #f8f9fa;
                }
              </style>
              <!-- Dropdown suggestion -->
              <div id="nonfasyankes_suggestions"
                class="autocomplete-overlay border bg-white rounded-bottom shadow-sm"
                style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; display: none;">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="nonfasyankes_address" id="nonfasyankes_address" class="form-control" readonly></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal Tambah Uraian Tugas -->
<div class="modal fade" id="modalUraianTugas" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="formUraianTugas">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Uraian Tugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Uraian Tugas</label>                         
            <textarea name="user_uraiantugas" id="user_uraiantugas" class="form-control" ></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Pengembangan Kompetensi (sesuai dengan SIAKPEL)</label>
            <select name="user_pelatihan[]" id="user_pelatihan" class="form-control" multiple="multiple">
             
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>
              <!--/ DataTable with Buttons -->
            <!-- / Content -->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <!-- Page JS -->
    <script src="<?= base_url('assets/js/pages-auth-multisteps.js') ?>"></script>
    <script src="<?= base_url('assets/js/app-user-view-account.js') ?>"></script>
    <script>
    <?php if(session()->getFlashdata('warning_profile')): ?>
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: '<?= session()->getFlashdata('warning_profile') ?>',
            confirmButtonText: 'OK'
        });
    <?php endif; 
    
    if (session()->has('update_profil')): 
        $notif = session('update_profil'); ?>
         Swal.fire({
            icon: '<?= esc($notif['type']) ?>',
            text: ' <?= esc($notif['message']) ?>',
            confirmButtonText: 'OK'
        });

    <?php endif; ?>
    
    $(document).ready(function () {

      function formatMobile(input) {
          let v = input.value.replace(/\D/g, ''); 
          v = v.replace(/^(0|62)/, '');
            input.value = v.replace(
                /^(\d{0,2})(\d{0,3})(\d{0,4})(\d{0,4}).*/,
                (_, a, b, c, d) => [a, b, c, d].filter(Boolean).join(' ')
            );
      }

      $('#MobileNumber').on('input', function () {
          formatMobile(this);
      });

      formatMobile(document.getElementById('MobileNumber'));

    $('.select2').select2({
      placeholder: '-- Pilih --',
      allowClear: true,
      width: '100%' 
    });

      $('#user_pelatihan').select2({
        dropdownParent: $('#modalUraianTugas'),
        placeholder: "Cari dan pilih pelatihan",
        multiple: true,
        ajax: {
          url: '/api/pelatihan_siakpel',
          type: 'POST',        // pakai POST
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              q: params.term // keyword pencarian
            };
          },
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        },
        minimumInputLength: 2
      });

    $('#jurusanProfesi').on('change', function() {
      if ($(this).val() === 'lainnya') {
        $('#jurusanManualWrapper').show();
        $('#jurusanManual').attr('required', true);
      } else {
        $('#jurusanManualWrapper').hide();
        $('#jurusanManual').removeAttr('required').val('');
      }
    });

  const base_url = "<?= base_url() ?>";
  const api_url  = base_url + "api";

  // === Utility Functions ===
  const showAlert = (type, message) => Swal.fire({ text: message, icon: type });

  const ajaxRequest = (url, method = 'GET', data = {}, successCb, errorCb) => {
    $.ajax({
      url,
      method,
      data,
      dataType: 'json',
      xhrFields: { withCredentials: true },
      success: successCb,
      error: xhr => {
        console.error('Error:', xhr.responseText);
        if (errorCb) errorCb(xhr);
      }
    });
  };

  const renderSuggestions = (container, results, template, emptyText) => {
    $(container).html(
      results?.length
        ? results.map(template).join('')
        : `<div class="item text-muted">${emptyText}</div>`
    ).slideDown(150);
  };

  const loadDetail = (url, data, onSuccess) => {
    ajaxRequest(`${api_url}/${url}`, 'POST', data, (response) => {
      if (response.code === 200) {
        onSuccess(response.data);
        $('#segment2').prop('disabled', false);
      } else {
        onSuccess({});
        $('#segment2').prop('disabled', true);
      }
    });
  };

  const FasyankesDetail = (code) => {
    loadDetail('fasyankes_check', { fasyankes_code: code }, (r) => {
      $('#fasyankes_type').val(r.fasyankes_type?.toUpperCase() || "");
      $('#fasyankes_name').val(r.fasyankes_name || "");
      $('#fasyankes_address').val(r.fasyankes_address || "");
    });
  };

  const NonFasyankesDetail = (id) => {
    loadDetail('nonfasyankes_check', { id }, (r) => {
      $('#nonfasyankes_id').val(r.id || "");
      $('#nonfasyankes_name').val(r.nonfasyankes_name || "");
      $('#nonfasyankes_address').val(r.nonfasyankes_address || "");
    });
  };

  const initSelect2 = (id, url, extraData) => {
    $(id).select2({
      placeholder: '-- Pilih --',
      allowClear: true,
      width: '100%',
      ajax: {
        url: `${api_url}/${url}`,
        dataType: 'json',
        delay: 250,
        data: params => ({ search: params.term, ...(extraData?.() || {}) }),
        processResults: data => ({ results: data })
      }
    });
  };

  // === Input Events ===
  $('#fasyankes_code').on('keypress', e => {
    if (e.which === 13) {
      e.preventDefault();
      FasyankesDetail($(e.target).val());
    }
  });

  $('#nonfasyankes_name').on('keypress', e => { if (e.which === 13) e.preventDefault(); });


  $('#nonfasyankes_name').on('keyup', function () {
    const query = $(this).val();
    if (query.length > 1) {
      ajaxRequest(`${api_url}/nonfasyankes_search`, 'POST', { keyword: query }, (response) => {
        renderSuggestions('#nonfasyankes_suggestions', response.data,
          item => `<div class="item" data-id="${item.id}">${item.text}</div>`,
          'Tidak ditemukan'
        );
      });
    } else {
      $('#nonfasyankes_suggestions').slideUp(150);
    }
  });

  $('#fasyankes_code').on('keyup', function () {
    const query = $(this).val();
    if (query.length > 1) {
      ajaxRequest(`${api_url}/fasyankes_search`, 'POST', { keyword: query }, (response) => {
        renderSuggestions('#suggestions', response.data,
          item => `<div class="item" data-code="${item.fasyankes_code}">${item.text}</div>`,
          'Tidak ditemukan'
        );
      });
    } else {
      $('#suggestions').slideUp(150);
    }
  });

  $(document).on('click', '#suggestions .item', function () {
    const code = $(this).data('code');
    $('#fasyankes_code').val(code);
    FasyankesDetail(code);
    $('#suggestions').fadeOut();
  });

  $(document).on('click', '#nonfasyankes_suggestions .item', function () {
    NonFasyankesDetail($(this).data('id'));
    $('#nonfasyankes_suggestions').fadeOut();
  });

  // === Select2 Dropdowns ===
  initSelect2('#provinsi', 'provinsi');
  initSelect2('#kabupaten', 'kabupaten', () => ({ prov_id: $('#provinsi').val() }));
  initSelect2('#kecamatan', 'kecamatan', () => ({ kab_id: $('#kabupaten').val() }));
  initSelect2('#kelurahan', 'kelurahan', () => ({ kec_id: $('#kecamatan').val() }));

  // === Form Submit ===
  $('#btnRegister').on('click', function () {
    const captcha = $('input[name="captcha"]').val();
    if (!captcha) {
      showAlert('error', 'Captcha wajib diisi.');
      return;
    }

    $.ajax({
      url: $('#multiStepsForm').attr('action'),
      method: $('#multiStepsForm').attr('method'),
      data: $('#multiStepsForm').serialize(),
      dataType: 'json',
      success: (response) => {
        if (response.code === 400) {
          showAlert(response.type, response.message);
          reloadCaptcha();
        }
      },
      error: (xhr) => console.error(xhr.responseText)
    });
  });

  $('#formFasyankes').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: base_url + 'profile/fasyankes',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: (res) => {
        $('#modalFasyankes').modal('hide');
        Swal.fire(res.success ? 'Berhasil' : 'Gagal', res.message, res.success ? 'success' : 'error');
        if (res.success) $('.datatables-fasyankes').DataTable().ajax.reload();
      },
      error: () => Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error')
    });
  });

  // === Load Data Fasyankes ===
  const loadFasyankes = () => {
    $('.datatables-fasyankes').DataTable({
      processing: true,
      serverSide: false,
      ajax: {
        url: base_url + "profile/fasyankes/data",
        type: "GET",
        dataSrc: "data",
        xhrFields: { withCredentials: true }
      },
      columns: [
        { data: "no" },
        { data: "fasyankes" },
        { data: "alamat" },
        { data: "aksi" }
      ]
    });
  };

      $(document).on('click', '.delete-fasyankes', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Yakin?',
            text: "Data fasyankes ini akan dinonaktifkan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, nonaktifkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'profile/fasyankes/delete/' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            $('.datatables-fasyankes').DataTable().ajax.reload();
                            Swal.fire('Berhasil', res.message, 'success');
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseText, 'error');
                    }
                });
            }
        });
    });

  loadFasyankes();


   $('#formNonFasyankes').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: base_url + 'profile/nonfasyankes',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: (res) => {
        $('#modalNonFasyankes').modal('hide');
        Swal.fire(res.success ? 'Berhasil' : 'Gagal', res.message, res.success ? 'success' : 'error');
        if (res.success) $('.datatables-non-fasyankes').DataTable().ajax.reload();
      },
       error: () => Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error')
    });
  });
  
  // === Load Data Fasyankes ===
  const loadNonFasyankes = () => {
    $('.datatables-non-fasyankes').DataTable({
      processing: true,
      serverSide: false,
      ajax: {
        url: base_url + "profile/nonfasyankes/data",
        type: "GET",
        dataSrc: "data",
        xhrFields: { withCredentials: true }
      },
      columns: [
        { data: "no" },
        { data: "non_fasyankes" },
        { data: "alamat" },
        { data: "aksi" }
      ]
    });
  };

      $(document).on('click', '.delete-non-fasyankes', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Yakin?',
            text: "Data non fasyankes ini akan dinonaktifkan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, nonaktifkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'profile/nonfasyankes/delete/' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(res) {
                      console.log(res);
                        if (res.success) {
                            $('.datatables-non-fasyankes').DataTable().ajax.reload();
                            Swal.fire('Berhasil', res.message, 'success');
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseText, 'error');
                    }
                });
            }
        });
    });

  loadNonFasyankes();
  initJobdescTable();
});


  $('#formUraianTugas').on('submit', function(e) {
          e.preventDefault();

          let formData = {
              user_uraiantugas: $('#user_uraiantugas').val(),
              user_pelatihan: $('#user_pelatihan').val(),
          };

          $.ajax({
              url: "<?= base_url('profile/jobdesc-competence') ?>",
              type: "POST",
              data: formData,
              dataType: "json",
              success: function(response) {
                  if(response.success) {
                      Swal.fire({
                          icon: 'success',
                          title: 'Berhasil',
                          text: response.message
                      });
                      $('#modalUraianTugas').modal('hide');
                  } else {
                      Swal.fire({
                          icon: 'warning',
                          title: 'Gagal',
                          text: response.message
                      });
                  }
              },
              error: function(xhr, status, error) {
                  Swal.fire({
                      icon: 'error',
                      title: 'Terjadi Kesalahan',
                      text: 'Silakan coba lagi'
                  });
                  console.log(xhr.responseText);
              }
          });
      });

    let tableJobdesc;

    function initJobdescTable() {
      tableJobdesc = $('#tableUraianTugas').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '/profile/listjobdesc-competence',
          type: 'GET'
        },
        columns: [
          { data: 'no' },
          { data: 'job_description' },
          { data: 'jumlah_kompetensi', className: 'text-center', width: '80px' }
        ]
      });

    $('#tableUraianTugas tbody').on('mouseenter', 'tr td:nth-child(1), tr td:nth-child(2)', function() {
        $(this).css('cursor', 'pointer');
    });

      $('#tableUraianTugas tbody').on('click', 'tr td:nth-child(1), tr td:nth-child(2)', function () {
        let row = tableJobdesc.row(this);
        if (row.child.isShown()) {
          row.child.hide();
          $(this).removeClass('shown');
        } else {
          row.child(format(row.data())).show();
          $(this).addClass('shown');
        }
      });
    }

    function format(d) {
      let html = '<table class="table table-sm">';
      html += '<tr><th>Kompetensi</th><th>Status</th></tr>';
      d.kompetensi.forEach(function (item) {
        html += `<tr>
                  <td>${item.nama_pelatihan}</td>
                  <td>
                    <button type="button"
                            class="btn btn-sm rounded-pill ${item.status == '1' ? 'btn-success' : 'btn-danger'} toggle-status"
                            data-id="${item.id}" 
                            data-status="${item.status}">
                      ${item.status == '1' ? 'Sudah' : 'Belum'}
                    </button>
                    <button type="button"
                            class="btn btn-sm rounded-pill btn-danger delete-competence"
                            data-id="${item.id}">
                      <i class="icon-base ti tabler-trash icon-sm"></i>
                    </button>
                  </td>
                </tr>`;
      });
      html += '</table>';
      return html;
    }

    $(document).on('click', '.toggle-status', function (e) {
      e.stopPropagation(); 
      let id = $(this).data('id');
      let status = $(this).data('status');
      let newStatus = status == '1' ? '0' : '1';

    
      let openRows = [];
      tableJobdesc.rows('.shown').every(function () {
        openRows.push(this.data().id);
      });

      $.ajax({
        url: '/profile/update-status-competence',
        type: 'POST',
        data: { id: id, status: newStatus },
        success: function (res) {
          if (res.success) {
            tableJobdesc.ajax.reload(function () {
              tableJobdesc.rows().every(function () {
                if (openRows.includes(this.data().id)) {
                  $(this.node()).trigger('click'); 
                }
              });
            }, false);
          } else {
            alert('Gagal update status');
          }
        },
        error: function (xhr, status, error) {
          console.error("Error AJAX:", error, xhr.responseText);
          alert('Terjadi kesalahan server');
        }
      });
    });

    $(document).on('click', '.delete-competence', function (e) {
    e.stopPropagation(); 

    if (!confirm('Apakah Anda yakin ingin menghapus kompetensi ini?')) return;

    let id = $(this).data('id');

  
    let openRows = [];
    tableJobdesc.rows('.shown').every(function () {
        openRows.push(this.data().id);
    });

    $.ajax({
        url: '/profile/delete-competence',
        type: 'POST',
        data: { id: id },
        success: function (res) {
            if (res.success) {
                tableJobdesc.ajax.reload(function () {
                    tableJobdesc.rows().every(function () {
                        if (openRows.includes(this.data().id)) {
                            $(this.node()).trigger('click'); 
                        }
                    });
                }, false);
            } else {
                alert(res.message || 'Gagal menghapus kompetensi');
            }
        },
        error: function (xhr, status, error) {
            console.error("Error AJAX:", error, xhr.responseText);
            alert('Terjadi kesalahan server');
        }
    });
});

  </script>
<?= $this->endSection() ?>