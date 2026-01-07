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
              <label class="form-label" for="basic-default-nip">NIP<span class="text-danger">*</span></label>
              <input type="text" name="user_nip" class="form-control" id="basic-default-nip" value="<?= esc($data['nip']) ?>"/>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-nik">NIK<span class="text-danger">*</span></label>
              <input type="text" name="user_nik" class="form-control" id="basic-default-nik" value="<?= esc($data['nik']) ?>"/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-6">
              <label class="form-label" for="basic-default-fullname">Nama Lengkap (tanpa gelar)<span class="text-danger">*</span></label>
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
              <label class="form-label" for="basic-default-front-title">Pangkat/Golongan<span class="text-danger">*</span></label>
              <input type="text" name="user_pangkatgolongan" class="form-control" id="basic-default-front-title" value="<?= esc($data['pangkatgolongan']) ?>"/>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-back-title">Jabatan<span class="text-danger">*</span></label>
              <input type="text" name="user_jabatan" class="form-control" id="basic-default-back-title" value="<?= esc($data['jabatan']) ?>"/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-6">
              <label class="form-label" for="MobileNumber">Nomor Telepon<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <span class="input-group-text">(+62)</span>
                        <input type="text" id="MobileNumber" name="user_mobilenumber"
                          class="form-control multi-steps-mobile" placeholder="81 234 xxx xxx" value="<?= esc($data['mobile']) ?>"/>
                      </div>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-email">E-mail<span class="text-danger">*</span></label>
              <input type="email" name="user_email" class="form-control" id="basic-default-email" value="<?= esc($data['email']) ?>"/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-6">
          <label class="form-label" for="address">Alamat Rumah<span class="text-danger">*</span></label>
              <textarea name="user_address" class="form-control" ><?= esc($data['address']) ?></textarea>
          </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-6">
              <label class="form-label" for="Provinsi">Provinsi<span class="text-danger">*</span></label>
              <select name="user_provinces" id="provinsi" class="form-control">
                <? if($data['_id_provinces']){ ?><option value="<?= esc($data['_id_provinces']) ?>" selected><?= esc($data['users_provinsi']) ?></option><? } ?>
              </select>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="Kabupaten">Kabupaten / Kota<span class="text-danger">*</span></label>
              <select name="user_regencies" id="kabupaten" class="form-select">
                <? if($data['_id_regencies']){ ?><option value="<?= esc($data['_id_regencies']) ?>" selected><?= esc($data['users_kabkota']) ?></option><? } ?>
              </select>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6 mb-6">
                <label class="form-label" for="Kecamatan">Kecamatan<span class="text-danger">*</span></label>
                <select name="user_districts" id="kecamatan" class="form-control">
                <? if($data['_id_districts']){ ?><option value="<?= esc($data['_id_districts']) ?>" selected><?= esc($data['users_kecamatan']) ?></option><? } ?>
              </select>
              </div>
              <div class="col-md-6 mb-6">
                <label class="form-label" for="Kelurahan">Kelurahan / Desa<span class="text-danger">*</span></label>
                <select name="user_villages" id="kelurahan" class="form-select">
                <? if($data['_id_villages']){ ?><option value="<?= esc($data['_id_villages']) ?>" selected><?= esc($data['users_kelurahan']) ?></option><? } ?>
              </select>
              </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-jenjang">Pendidikan Terakhir<span class="text-danger">*</span></label>
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
              <label class="form-label" for="basic-default-nik">Jurusan / Profesi<span class="text-danger">*</span></label>
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
                  <input type="text" id="jurusanManual" name="user_jurusan_profesi_manual" class="form-control" placeholder="Ketik jurusan/profesi">
                </div>
            </div>
          </div>
          <span class="text-danger">*</span> Wajib diisi
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
          <i class="icon-base ti tabler-plus icon-sm me-1_5"></i> Uraian Tugas</button>
      </div>
      <div class="card-datatable table-responsive pt-0">
        <table id="tableUraianTugas" class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Uraian Tugas</th>
              <th>Pengembangan Kompetensi</th>
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
            <div class="row">
                  <div class="col-sm-6">
                    <label class="form-label">Nama Fasyankes</label>
                    <div class="position-relative">
                      <input type="text" name="fasyankes_name" id="fasyankes_name" class="form-control"
                        placeholder="Cth.: RS Gxxx xxxx" autocomplete="off" />
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
                      <div id="suggestions_fasyankes_name" class="autocomplete-overlay border bg-white rounded-bottom shadow-sm"
                        style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; display: none;">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                          <label class="form-label">Tipe Fasyankes</label>
                          <input type="text" id="fasyankes_type" name="fasyankes_type" class="form-control" readonly />
                  </div>
            </div>
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

    
    const ajaxGet = (url, successCb, errorCb) => {
        $.ajax({
          url,
          method: 'GET',
          dataType: 'json',
          success: successCb,
          error: xhr => errorCb && errorCb(xhr)
        });
      };

        const showAlert = (type, message, redirect = null) => {
          Swal.fire({
            text: message,
            icon: type,
            confirmButtonText: 'OK'
          }).then((result) => {
            if (redirect && result.isConfirmed) window.location.href = redirect;
          });
        };

  $(document).ready(function () {

  const base_url = "<?= base_url() ?>";
  const api_url  = base_url + "api";


  const ajaxRequest = (url, method = 'GET', data = {}, success, error) => {
    $.ajax({
      url, method, data, dataType: 'json', xhrFields: { withCredentials: true },
      success,
      error: error || (xhr => console.error(xhr.responseText))
    });
  };

  const loadDataTable = (selector, url, columns) => {
    return $(selector).DataTable({
      processing: true,
      serverSide: false,
      ajax: { url, type: "GET",  dataSrc: function (json) {
        if (json.status && Array.isArray(json.data)) {
          // kalau status true → isi data
          return json.data;
        } else {
          // kalau status false → balikin array kosong, jangan bikin error
          return [];
        }
      }, xhrFields: { withCredentials: true } },
      columns
    });
  };

  const renderSuggestions = (container, results, template, emptyText) => {
    $(container).html(results?.length ? results.map(template).join('') : `<div class="item text-muted">${emptyText}</div>`).slideDown(150);
  };

  const handleDelete = (selector, tableSelector, urlSegment, message) => {
    $(document).on('click', selector, function() {
      const id = $(this).data('id');
      Swal.fire({ title: 'Yakin?', text: message, icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, nonaktifkan!' })
        .then(result => {
          if (result.isConfirmed) {
            ajaxRequest(`${base_url}${urlSegment}/${id}`, 'POST', {}, res => {
              if (res.success) {
                $(tableSelector).DataTable().ajax.reload();
                showSwal('success', 'Berhasil', res.message);
              } else {
                showSwal('error', 'Gagal', res.message);
              }
            }, xhr => showSwal('error','Error',xhr.responseText));
          }
        });
    });
  };

  const formatMobile = input => {
    let v = input.value.replace(/\D/g, '').replace(/^(0|62)/, '');
    input.value = v.replace(/^(\d{0,2})(\d{0,3})(\d{0,4})(\d{0,4}).*/, (_, a, b, c, d) => [a,b,c,d].filter(Boolean).join(' '));
  };
  $('#MobileNumber').on('input', function(){ formatMobile(this); });
  formatMobile(document.getElementById('MobileNumber'));

  const initSelect2 = (selector, url, extraData) => {
    $(selector).select2({
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

  $('.select2').select2({ placeholder: '-- Pilih --', allowClear: true, width: '100%' });
  initSelect2('#provinsi','provinsi');
  initSelect2('#kabupaten','kabupaten', () => ({ prov_id: $('#provinsi').val() }));
  initSelect2('#kecamatan','kecamatan', () => ({ kab_id: $('#kabupaten').val() }));
  initSelect2('#kelurahan','kelurahan', () => ({ kec_id: $('#kecamatan').val() }));

  const loadDetail = (url, params, onSuccess) => ajaxRequest(`${api_url}/${url}?${new URLSearchParams(params)}`, 'GET', null, res => onSuccess(res.code === 200 ? res.data[0] : {}));

  // === Detail Handlers ===
      const fillForm = (res, fields) => {
        if (res.code === 200) {
           Object.entries(fields).forEach(([key, val]) => $(`#${key}`).val(val));
        } else {
          Object.keys(fields).forEach(key => $(`#${key}`).val(""));
        }
        showAlert(res.type, res.message);
      };

const getInstitutionDetail = (id, type = "fasyankes", cb) => {
      const mappings = {
        fasyankes: {
          fasyankes_type: "type",
          fasyankes_name: "name",
          fasyankes_address: "address"
        },
        nonfasyankes: {
          nonfasyankes_id: "id",
          nonfasyankes_name: "name",
          nonfasyankes_address: "address"
        }
      };

  if (!mappings[type]) {
    console.error(`Unknown institution type: ${type}`);
    return;
  }

  ajaxGet(`${api_url}/institution?k=${encodeURIComponent(id)}`, res => {
    const mapping = mappings[type];
    const detail = res.status && res.data?.length > 0 ? res.data[0] : null;

    const filled = {};
    Object.entries(mapping).forEach(([formField, dataKey]) => {
      let value = detail?.[dataKey] || "";

      if (formField === "fasyankes_type") {
        if (type === "fasyankes" && value.toLowerCase() === "rumahsakit") {
          value = "RUMAH SAKIT"; 
        } else {
          value = value.toUpperCase();
        }
      }

      filled[formField] = value;
    });

    fillForm(res, filled);
    if (typeof cb === "function") cb(res, filled);
  });
};

 

 // === Search live ===
      const liveSearch = (selector, category, container, template) => {
      $(selector).on('keyup', function () {
        const q = $(this).val();
        if (q.length > 1) {
          ajaxGet(`${api_url}/institution?k=${encodeURIComponent(q)}&c=${category}`, res => {
            const list = Array.isArray(res.data) ? res.data : [];
            $(container).html(
              list.length
                ? list.map(template).join('')
                : `<div class="item text-muted">Tidak ditemukan</div>`
            ).slideDown(150);
          });
        } else {
          $(container).slideUp(150);
        }
      });
    
      // Tutup suggestion saat klik di luar
      $(document).on('click', function(e) {
        if (!$(e.target).closest(selector).length && !$(e.target).closest(container).length) {
          $(container).slideUp(150);
        }
      });
    };


      liveSearch('#nonfasyankes_name', 'nonfasyankes', '#nonfasyankes_suggestions',
        item => `<div class="item" data-id="${item.id}">${item.name}</div>`);

      liveSearch('#fasyankes_code', 'fasyankes', '#suggestions',
          item => `<div class="item" data-code="${item.code}" data-id="${item.id}">
            ${item.code} - ${item.type === 'puskesmas' ? item.type.toUpperCase() + ' ' : ''}${item.name}- 
            ${item.address}${[
              item.district_name,
              item.regencies_name,
              item.provinces_name
            ].filter(Boolean).map(v => `, ${v}`).join('')}
          </div>`
        );
        
        liveSearch('#fasyankes_name', 'fasyankesname', '#suggestions_fasyankes_name',
        item => `
          <div class="item" data-code="${item.code}" data-id="${item.id}">
            ${item.code} -
            ${item.type === 'puskesmas' ? item.type.toUpperCase() + ' ' : ''}${item.name} - 
            ${item.address}${[
              item.district_name,
              item.regencies_name,
              item.provinces_name
            ].filter(Boolean).map(v => `, ${v}`).join('')}
          </div>
        `
      );
      
      $('#fasyankes_code').on('keydown', function (e) {
        if (e.key === "Enter" || e.which === 13) {
          e.preventDefault();
          getInstitutionDetail($(this).val(),'fasyankes');
        }
      });
      
      $('#fasyankes_name').on('keydown', function (e) {
        if (e.key === "Enter" || e.which === 13) {
          e.preventDefault();
          getInstitutionDetail($(this).val(),'fasyankes');
        }
      });

      $('#nonfasyankes_name').on('keydown', function (e) {
        if (e.key === "Enter" || e.which === 13) {
          e.preventDefault();
        }
      });

      $(document).on('click', '#suggestions .item', function () {
        const code = $(this).data('code');
        const id = $(this).data('id');
        $('#fasyankes_code').val(code);
        getInstitutionDetail(id,'fasyankes');
        
         $('#suggestions').fadeOut();
      });
      
      $(document).on('click', '#suggestions_fasyankes_name .item', function () {
        const code = $(this).data('code');
        const id = $(this).data('id');
        $('#fasyankes_code').val(code);
        getInstitutionDetail(id,'fasyankes');
        
         $('#suggestions_fasyankes_name').fadeOut();
      });
      
      $(document).on('click', '#nonfasyankes_suggestions .item', function () {       
          getInstitutionDetail($(this).data('id'),'nonfasyankes');
          $('#nonfasyankes_suggestions').fadeOut();
      });


  $('#jurusanProfesi').on('change', function(){
    const val = $(this).val();
    $('#jurusanManualWrapper').toggle(val==='lainnya');
    $('#jurusanManual').attr('required', val==='lainnya').val(val==='lainnya'?'':'');
  });

  const handleFormSubmit = (formSelector, url, tableSelector=null) => {
    $(formSelector).on('submit', function(e){
      e.preventDefault();
      ajaxRequest(url, 'POST', $(this).serialize(), res => {
        $(formSelector).closest('.modal').modal('hide');
        showSwal(res.success?'success':'error', res.success?'Berhasil':'Gagal', res.message);
        if(res.success && tableSelector) $(tableSelector).DataTable().ajax.reload();
      }, () => showSwal('error','Error','Terjadi kesalahan pada server.'));
    });
  };

  handleFormSubmit('#formFasyankes', base_url+'profile/fasyankes','.datatables-fasyankes');
  handleFormSubmit('#formNonFasyankes', base_url+'profile/nonfasyankes','.datatables-non-fasyankes');

  loadDataTable('.datatables-fasyankes', base_url+'profile/institutions/data?c=fasyankes', [
    { data: "no" }, { data: "name" }, { data: "address" }, { data: "action" }
  ]);
  loadDataTable('.datatables-non-fasyankes', base_url+'profile/institutions/data?c=nonfasyankes', [
    { data: "no" }, { data: "name" }, { data: "address" }, { data: "action" }
  ]);

  handleDelete('.delete-fasyankes', '.datatables-fasyankes','profile/institutions/delete','Data fasyankes ini akan dihapus');
  handleDelete('.delete-non-fasyankes', '.datatables-non-fasyankes','profile/institutions/delete','Data non fasyankes ini akan dihapus');

  initJobdescTable();

    $('#user_pelatihan').select2({
    dropdownParent: $('#modalUraianTugas'),
    placeholder: "Cari dan pilih pelatihan",
    multiple: true,
    minimumInputLength: 2,
    ajax: {
      url: '/api/pelatihan_siakpel',
      type: 'GET',
      dataType: 'json',
      delay: 250,
      data: params => ({ q: params.term, maxData: 20, }),
      processResults: data => ({ results: data }),
      cache: true
    },
    templateSelection: data => {
      if (!data.id) return data.text;
      const color = data.id.includes('&&1') ? '#28a745' : data.id.includes('&&0') ? '#dc3545' : null;
      return color
        ? $(`<span style="background-color:${color};color:white;padding:2px 5px;border-radius:3px;">${data.text}</span>`)
        : data.text;
    }
  });

  $('#user_pelatihan').on('select2:select', e => {
    const { id, text } = e.params.data;
    const $select = $(e.target);

    Swal.fire({
      text: `Apakah sudah melaksanakan "${text}" ?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sudah',
      cancelButtonText: 'Belum',
      buttonsStyling: false,
      customClass: { confirmButton: 'btn btn-success ms-1', cancelButton: 'btn btn-danger ms-1' }
    }).then(result => {
      const newValue = result.isConfirmed ? id + '&&1' : result.dismiss === Swal.DismissReason.cancel ? id + '&&0' : id;
      let selectedOptions = ($select.val() || []).filter(v => !v.startsWith(id));
      selectedOptions.push(newValue);

      if (!$select.find(`option[value='${newValue}']`).length) {
        $select.append(new Option(text, newValue, true, true));
      }

      $select.val(selectedOptions).trigger('change');
    });
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
                { data: 'no', width: '50px', className: 'text-center' },
                { data: 'job_description' },
                {
                    data: 'kompetensi',
                    render: renderKompetensi
                }
            ],
            order: [[0, 'asc']],
            autoWidth: false
        });
    }

    function renderKompetensi(data) {
    return `<ul class="mb-0">
        ${data.map(item => {

            const status = item.status === '1'
                ? { text: 'Sudah', btn: 'btn-success' }
                : item.status === '0'
                    ? { text: 'Belum', btn: 'btn-danger' }
                    : { text: 'Tidak Valid', btn: 'btn-secondary' };

            return `
                <li class="mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="me-2">${item.nama_pelatihan}</span>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button"
                                class="btn rounded-pill ${status.btn} toggle-status"
                                data-id="${item.id}"
                                data-status="${item.status ?? ''}">
                                ${status.text}
                            </button>
                            <button type="button"
                                class="btn rounded-pill btn-danger delete-competence ms-1"
                                data-id="${item.id}">
                                <i class="icon-base ti tabler-trash icon-sm"></i>
                            </button>
                        </div>
                    </div>
                </li>`;
        }).join('')}
    </ul>`;
}


    function showSwal(icon, title, text) {
        Swal.fire({ icon, title, text });
    }

    $('#formUraianTugas').on('submit', function(e) {
        e.preventDefault();

        const userUraian = $('#user_uraiantugas').val();
        const userPelatihan = $('#user_pelatihan').val();

        $.post({
            url: "<?= base_url('profile/jobdesc-competence') ?>",
            data: { "<?= csrf_token() ?>": "<?= csrf_hash() ?>", user_uraiantugas: userUraian, user_pelatihan: userPelatihan },
            dataType: 'json',
            success: function(response) {
                if(response.success){
                    showSwal('success', 'Berhasil', response.message);
                    tableJobdesc.ajax.reload(null, false);
                    $('#formUraianTugas')[0].reset();
                    $('#user_pelatihan').val(null).trigger('change');
                    $('#modalUraianTugas').modal('hide');
                } else {
                    showSwal('warning', 'Gagal', response.message);
                }
            }
        });
    });


    $('#tableUraianTugas').on('click', '.toggle-status, .delete-competence', function(e) {
        e.stopPropagation();
        let $btn = $(this);
        let id = $btn.data('id');

        if ($btn.hasClass('toggle-status')) {
            let newStatus = $btn.data('status') == '1' ? '0' : '1';
            $.post('/profile/update-status-competence', { id, status: newStatus }, function(res) {
                if (res.success) tableJobdesc.ajax.reload(null, false);
                else alert('Gagal update status');
            }, 'json').fail(() => alert('Terjadi kesalahan server'));
        }

        if ($btn.hasClass('delete-competence')) {
          Swal.fire({ text: 'Apakah Anda yakin ingin menghapus kompetensi ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya' })
            .then(result => {
              if (result.isConfirmed) {

                $.post('/profile/delete-competence', { id }, function(res) {
                if (res.success) tableJobdesc.ajax.reload(null, false);
                else showSwal('error', 'Gagal', res.message);
            }, 'json').fail(() => showSwal('error', 'Gagal', 'Terjadi kesalahan server'));
              }
            });

        }
    });


  </script>
<?= $this->endSection() ?>