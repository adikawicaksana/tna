<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-profile.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/select2/select2.css') ?>" />
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
                            <h4 class="mb-2 mt-lg-6">John Doe</h4>
                            <ul
                              class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                              <li class="list-inline-item d-flex gap-2 align-items-center">
                                <i class="icon-base ti tabler-palette icon-lg"></i
                                ><span class="fw-medium">UX Designer</span>
                              </li>
                              <li class="list-inline-item d-flex gap-2 align-items-center">
                                <i class="icon-base ti tabler-map-pin icon-lg"></i
                                ><span class="fw-medium">Vatican City</span>
                              </li>
                              <li class="list-inline-item d-flex gap-2 align-items-center">
                                <i class="icon-base ti tabler-calendar icon-lg"></i
                                ><span class="fw-medium"> Joined April 2021</span>
                              </li>
                            </ul>
                          </div>
                          <a href="javascript:void(0)" class="btn btn-primary mb-1">
                            <i class="icon-base ti tabler-user-check icon-xs me-2"></i>Connected
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Header -->

              <!-- Navbar pills -->
              <div class="row">
                <div class="col-md-12">
                  <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-sm-0 gap-2">
                      <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"
                          ><i class="icon-base ti tabler-user-check icon-sm me-1_5"></i> Biodata</a
                        >
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="?p=fasyankes">
                          <i class="icon-base ti tabler-building-hospital icon-sm me-1_5"></i> Fasyankes</a>
                      </li>
                      <!--<li class="nav-item">
                        <a class="nav-link" href="pages-profile-projects.html"
                          ><i class="icon-base ti tabler-layout-grid icon-sm me-1_5"></i> Projects</a
                        >
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="pages-profile-connections.html"
                          ><i class="icon-base ti tabler-link icon-sm me-1_5"></i> Connections</a
                        >
                      </li> -->
                    </ul>
                  </div>
                </div>
              </div>
              <!--/ Navbar pills -->

              <!-- User Profile Content -->
               <div class="row">
  <!-- Basic Layout -->
  <div class="col-xl">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">                      
      </div>
      <div class="card-body">
        <form>
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
              <!-- <label class="form-label" for="basic-default-mobile-number">Nomor Telepon</label>
              <input type="text" name="user_mobile_number" class="form-control" id="basic-default-mobile-number" /> -->

              <label class="form-label" for="MobileNumber">Nomor Telepon</label>
                      <div class="input-group">
                        <span class="input-group-text">(+62)</span>
                        <input type="text" id="MobileNumber" name="user_mobilenumber"
                          class="form-control multi-steps-mobile phone-mask" placeholder="81 234 xxx xxx" value="<?= esc($data['mobile']) ?>"/>
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
              <select name="user_provinces" id="provinsi" class="form-control"></select>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="Kabupaten">Kabupaten / Kota</label>
              <select name="user_regencies" id="kabupaten" class="form-select"></select>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6 mb-6">
                <label class="form-label" for="Kecamatan">Kecamatan</label>
                <select name="user_districts" id="kecamatan" class="form-control"></select>
              </div>
              <div class="col-md-6 mb-6">
                <label class="form-label" for="Kelurahan">Kelurahan / Desa</label>
                <select name="user_villages" id="kelurahan" class="form-select"></select>
              </div>
          </div>    
          <div class="row">
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-jenjang">Pendidikan Terkahir</label>
              <input type="text" name="user_jenjang" class="form-control" id="basic-default-jenjang" value="<?= esc($data['nip']) ?>"/>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-nik">Jurusan / Profesi</label>
              <input type="text" name="user_nik" class="form-control" id="basic-default-nik" value="<?= esc($data['nik']) ?>"/>
            </div>
          </div>  

          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

              <!--/ User Profile Content -->
            </div>

             <div class="container-xxl flex-grow-1 container-p-y">
              <!-- DataTable with Buttons --><div class="card p-3">
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
              <th>Aksi</th>
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
              <th>Institusi</th>
              <th>Alamat</th>
              <th>Aksi</th>
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
            <label class="form-label">Nama Institusi</label>            
            <div class="position-relative">
              <input type="hidden" name="institution_id" id="institution_id" class="form-control"
                autocomplete="off" />
              <input type="text" name="institution_name" id="institution_name" class="form-control"
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
              <div id="institution_suggestions"
                class="autocomplete-overlay border bg-white rounded-bottom shadow-sm"
                style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; display: none;">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="institution_address" id="institution_address" class="form-control" readonly></textarea>
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
    <script src="<?= base_url('assets/vendor/libs/select2/select2.js') ?>"></script>
    <script>
    <?php if(session()->getFlashdata('warning_profile')): ?>
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: '<?= session()->getFlashdata('warning_profile') ?>',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
    
    $(document).ready(function () {
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

  const InstitutionDetail = (id) => {
    loadDetail('institution_check', { id }, (r) => {
      $('#institution_id').val(r.id || "");
      $('#institution_name').val(r.institution_name || "");
      $('#institution_address').val(r.institution_address || "");
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

  $('#institution_name').on('keypress', e => e.which === 13 && e.preventDefault());

  $('#institution_name').on('keyup', function () {
    const query = $(this).val();
    if (query.length > 1) {
      ajaxRequest(`${api_url}/institution_search`, 'POST', { keyword: query }, (response) => {
        renderSuggestions('#institution_suggestions', response.data,
          item => `<div class="item" data-id="${item.id}">${item.text}</div>`,
          'Tidak ditemukan'
        );
      });
    } else {
      $('#institution_suggestions').slideUp(150);
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

  $(document).on('click', '#institution_suggestions .item', function () {
    InstitutionDetail($(this).data('id'));
    $('#institution_suggestions').fadeOut();
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

  // === Load DataTables ===
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
});


  </script>
<?= $this->endSection() ?>