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
                        <a class="nav-link" href="./profile"
                          ><i class="icon-base ti tabler-user-check icon-sm me-1_5"></i> Biodata</a>
                      </li>                      
                      <li class="nav-item">
                        <a class="nav-link active" href="?p=fasyankes">
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
              <label class="form-label" for="basic-default-jenjang">Jenjang Pendidikan</label>
              <input type="text" name="user_jenjang" class="form-control" id="basic-default-jenjang" value="<?= esc($data['nip']) ?>"/>
            </div>
            <div class="col-md-6 mb-6">
              <label class="form-label" for="basic-default-nik">Jurusan / Profesi</label>
              <input type="text" name="user_nik" class="form-control" id="basic-default-nik" value="<?= esc($data['nik']) ?>"/>
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
                

          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

              <!--/ User Profile Content -->
            </div>
            <!-- / Content -->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <!-- Page JS -->
    <script src="<?= base_url('assets/js/pages-auth-multisteps.js') ?>"></script>
    <script src="<?= base_url('assets/js/app-user-view-account.js') ?>"></script>
    <script src="<?= base_url('assets/js/form-layouts.js') ?>"></script>
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

    const reloadCaptcha = () => {
        $('#captchaImg').attr('src', `${base_url}captcha?t=${Date.now()}`);
    };

    const showAlert = (type, message) => {
        Swal.fire({ text: message, icon: type });
    };

    const ajaxPost = (url, data, successCb, errorCb) => {
        $.ajax({
            url,
            method: 'POST',
            data,
            dataType: 'json',
            success: successCb,
            error: (xhr, status, error) => {
                console.error('Error:', error);
                if (errorCb) errorCb(xhr);
            }
        });
    };

    const renderSuggestions = (container, results, template, emptyText) => {
        if (results.length > 0) {
            $(container).html(results.map(template).join('')).slideDown(150);
        } else {
            $(container).html(`<div class="item text-muted">${emptyText}</div>`).fadeIn();
        }
    };

    // === Captcha ===
    $('#reloadCaptcha').on('click', reloadCaptcha);

    // === Detail Handlers ===
    const FasyankesDetail = (code) => {
        ajaxPost(`${api_url}/fasyankes_check`, { fasyankes_code: code }, (response) => {
            const result = response.data;
            if (response.code === 200) {
                $('#fasyankes_type').val(result.fasyankes_type.toUpperCase());
                $('#fasyankes_name').val(result.fasyankes_name);
                $('#fasyankes_address').val(result.fasyankes_address);
                $('#segment2').prop('disabled', false);
            } else {
                $('#fasyankes_type, #fasyankes_name, #fasyankes_address').val("");
                $('#segment2').prop('disabled', true);
            }
            showAlert(response.type, response.message);
        });
    };

    const InstitutionDetail = (id) => {
        ajaxPost(`${api_url}/institution_check`, { id }, (response) => {
            const result = response.data;
            if (response.code === 200) {
                $('#institution_name').val(result.institution_name);
                $('#institution_address').val(result.institution_address);
                $('#segment2').prop('disabled', false);
            } else {
                $('#institution_name, #institution_address').val("");
                $('#segment2').prop('disabled', true);
            }
            showAlert(response.type, response.message);
        });
    };

    // === Input Events ===
    $('#fasyankes_code').on('keypress', e => {
        if (e.which === 13) {
            e.preventDefault();
            FasyankesDetail($(e.target).val());
        }
    });

    $('#institution_name').on('keypress', e => {
        if (e.which === 13) e.preventDefault();
    });

    // Institution live search
    $('#institution_name').on('keyup', function () {
        const query = $(this).val();
        if (query.length > 1) {
            ajaxPost(`${api_url}/institution_search`, { keyword: query }, (response) => {
                renderSuggestions('#institution_suggestions', response.data,
                    item => `<div class="item" data-id="${item.id}">${item.text}</div>`,
                    'Tidak ditemukan'
                );
            });
        } else {
            $('#institution_suggestions').slideUp(150);
        }
    });

    // Fasyankes live search
    $('#fasyankes_code').on('keyup', function () {
        const query = $(this).val();
        if (query.length > 1) {
            ajaxPost(`${api_url}/fasyankes_search`, { keyword: query }, (response) => {
                renderSuggestions('#suggestions', response.data,
                    item => `<div class="item" data-code="${item.fasyankes_code}">${item.text}</div>`,
                    'Tidak ditemukan'
                );
            });
        } else {
            $('#suggestions').slideUp(150);
        }
    });

    // Suggestions click
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

    // Segment Toggle
    $('#segment1').on('click', function () {
        const selected = $('input[name="fasyankes_mode"]:checked').val();
        if (selected === 'fasyankes') {
            $('#non_fasyankes_mode').hide();
            $('#fasyankes_mode').show();
        } else if (selected === 'non-fasyankes') {
            $('#fasyankes_mode').hide();
            $('#non_fasyankes_mode').show();
        } else {
            alert('Wajib ada yang dipilih');
        }
    });

    // === Select2 Dropdowns ===
    const select2Config = (url, extraDataFn) => ({
        placeholder: '-- Pilih --',
        allowClear: true,
        width: '100%',
        ajax: {
            url: `${api_url}/${url}`,
            dataType: 'json',
            delay: 250,
            data: params => ({
                search: params.term,
                ...(extraDataFn ? extraDataFn() : {})
            }),
            processResults: data => ({ results: data })
        }
    });

    $('#provinsi').select2(select2Config('provinsi'));
    $('#kabupaten').select2(select2Config('kabupaten', () => ({ prov_id: $('#provinsi').val() })));
    $('#kecamatan').select2(select2Config('kecamatan', () => ({ kab_id: $('#kabupaten').val() })));
    $('#kelurahan').select2(select2Config('kelurahan', () => ({ kec_id: $('#kecamatan').val() })));

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
});

  </script>
<?= $this->endSection() ?>