<!doctype html>

<html lang="en" class="layout-wide customizer-hide" dir="ltr" data-skin="default"
  data-assets-path="<?= base_url('assets/') ?>" data-template="vertical-menu-template" data-bs-theme="light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>
    <?= isset($title) ? esc($title) . ' | ' : '' ?>Murnajati
  </title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon"
    href="<?= base_url('assets/img/front-pages/landing-page/logo_provinsi_jatim.png') ?>" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/iconify-icons.css') ?>" />

  <!-- Core CSS -->
  <!-- build:css assets/vendor/css/theme.css  -->

  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/node-waves/node-waves.css') ?>" />

  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/pickr/pickr-themes.css') ?>" />

  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/select2.min.css') ?>" />

  <!-- Vendors CSS -->

  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

  <!-- endbuild -->

  <!-- Vendor -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/bs-stepper/bs-stepper.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/bootstrap-select/bootstrap-select.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/select2/select2.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/@form-validation/form-validation.css') ?>" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.2/dist/sweetalert2.min.css">

  <!-- Page CSS -->

  <!-- Page -->
  <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-auth.css') ?>" />

  <!-- Helpers -->
  <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="<?= base_url('assets/vendor/js/template-customizer.js') ?>"></script>

  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

  <script src="<?= base_url('assets/js/config.js') ?>"></script>
  <script src="<?= base_url('assets/js/select2.min.js') ?>"></script>
</head>

<body>
  <!-- Content -->

  <div class="authentication-wrapper authentication-cover authentication-bg">
    <!-- Logo -->
    <a href="<?= base_url(); ?>" class="app-brand auth-cover-brand">
      <span class="app-brand-logo demo">
        <span class="text-primary">
          <img src="<?= base_url('assets/img/front-pages/landing-page/logo_provinsi_jatim.png') ?>" height="32">
        </span>
      </span>
      <span class="app-brand-text demo text-heading fw-bold">MURNAJATI</span>
    </a>
    <!-- /Logo -->
    <div class="authentication-inner row">
      <!-- Left Text -->
      <div
        class="d-none d-lg-flex col-lg-4 align-items-center justify-content-center p-5 position-relative auth-multisteps-bg-height">
        <img src="<?= base_url('assets/img/illustrations/auth-register-multisteps-illustration.png') ?>"
          alt="auth-register-multisteps" class="img-fluid" width="250" />
        <img src="<?= base_url('assets/img/illustrations/auth-register-multisteps-shape-light.png') ?>"
          alt="auth-register-multisteps" class="platform-bg"
          data-app-light-img="illustrations/auth-register-multisteps-shape-light.png"
          data-app-dark-img="illustrations/auth-register-multisteps-shape-dark.png" />
      </div>
      <!-- /Left Text -->

      <!--  Multi Steps Registration -->
      <div class="d-flex col-lg-8 align-items-center justify-content-center authentication-bg p-5">
        <div class="w-px-700">
          <div id="multiStepsValidation" class="bs-stepper border-none shadow-none mt-5">
            <div class="bs-stepper-header border-none pt-12 px-0">
              <div class="step" data-target="#accountDetailsValidation">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle"><i class="icon-base ti tabler-file-analytics icon-md"></i></span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Instansi</span>
                  </span>
                </button>
              </div>
              <div class="line">
                <i class="icon-base ti tabler-chevron-right"></i>
              </div>
              <div class="step" data-target="#personalInfoValidation">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle"><i class="icon-base ti tabler-user icon-md"></i></span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Detail Instansi</span>
                  </span>
                </button>
              </div>
              <div class="line">
                <i class="icon-base ti tabler-chevron-right"></i>
              </div>
              <div class="step" data-target="#billingLinksValidation">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle"><i class="icon-base ti tabler-credit-card icon-md"></i></span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Informasi Personal</span>
                  </span>
                </button>
              </div>
            </div>
            <div class="bs-stepper-content px-0">
              <form id="multiStepsForm" onSubmit="return false" action="./register" method="POST">

                <?= csrf_field() ?>

                <!-- Account Details -->
                <div id="accountDetailsValidation" class="content">
                  <div class="content-header mb-6">
                    <h4 class="mb-0">Informasi</h4>
                    <p class="mb-0">Fasilitas Pelayanan Kesehatan (Fasyankes) atau Instansi Lainnya</p>
                  </div>

                  <!-- Custom plan options -->
                  <div class="row gap-md-0 gap-4 mb-12">
                    <div class="col-md">
                      <div class="form-check custom-option custom-option-icon">
                        <label class="form-check-label custom-option-content" for="basicOption">
                          <span class="custom-option-body">
                            <i class="icon-base ti tabler-building-hospital"></i>
                            <span class="custom-option-title"> FASYANKES </span>
                          </span>
                          <input name="fasyankes_mode" class="form-check-input" type="radio" value="fasyankes"
                            checked />
                        </label>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="form-check custom-option custom-option-icon">
                        <label class="form-check-label custom-option-content" for="standardOption">
                          <span class="custom-option-body">
                            <i class="icon-base ti tabler-building"></i>
                            <span class="custom-option-title"> NON FASYANKES </span>
                          </span>
                          <input name="fasyankes_mode" class="form-check-input" type="radio" value="non-fasyankes" />
                        </label>
                      </div>
                    </div>
                  </div>
                  <!--/ Custom plan options -->
                  <div class="card mb-6">
                    <div class="card-body">
                      <h5 class="card-title mb-1"><i class="icon-base ti tabler-building-hospital"></i> FASYANKES</h5>
                      <p class="card-text">

                        Bagi Anda SDMK atau non-SDMK yang bertugas di Fasilitas Pelayanan Kesehatan (Rumah Sakit,
                        Puskesmas, Klinik, Laboratorium, Apotek, Praktik Dokter, Praktik Bidan, Praktik Perawat, atau
                        Balai Kesehatan).
                      </p>
                    </div>
                  </div>
                  <div class="card mb-6">
                    <div class="card-body">
                      <h5 class="card-title mb-1"><i class="icon-base ti tabler-building"></i> NON FASYANKES</h5>
                      <p class="card-text">
                        Bagi Anda yang <strong>TIDAK BEKERJA</strong> di Fasilitas Pelayanan Kesehatan (Fasyankes), baik
                        yang berstatus sebagai Sumber Daya Manusia Kesehatan (SDMK) maupun yang bukan SDMK (non-SDMK).
                      </p>
                    </div>
                  </div>
                  <div class="row g-6">

                    <div class="col-12 d-flex justify-content-end">
                      <button class="btn btn-primary btn-next" id="segment1">
                        <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Selanjutnya</span>
                        <i class="icon-base ti tabler-arrow-right icon-xs"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <!-- Personal Info -->
                <div id="personalInfoValidation" class="content">

                  <div class="row g-6">
                    <!-- Fasyankes Mode /start -->
                    <div id="fasyankes_mode">
                      <div class="row">
                        <div class="col-sm-6">
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

                        <div class="col-sm-6">
                          <label class="form-label">Tipe Fasyankes</label>
                          <input type="text" id="fasyankes_type" name="fasyankes_type" class="form-control" readonly />
                        </div>
                      </div>

                        
                    
                      <div class="row mt-3">
                        <div class="col-sm-12">
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
                        
                        <!--<div class="col-sm-12 ">-->
                        <!--  <label class="form-label">Nama Fasyankes</label>-->
                        <!--  <input type="text" id="fasyankes_name" name="fasyankes_name" class="form-control" />-->
                        <!--  <style>-->
                        <!--      .autocomplete-overlay .item {-->
                        <!--        padding: 8px 16px;-->
                        <!--        cursor: pointer;-->
                        <!--        border-bottom: 1px solid #eee;-->
                        <!--      }-->

                        <!--      .autocomplete-overlay .item:last-child {-->
                        <!--        border-bottom: none;-->
                        <!--      }-->

                        <!--      .autocomplete-overlay .item:hover {-->
                        <!--        background-color: #f8f9fa;-->
                        <!--      }-->
                        <!--    </style>-->
                            <!-- Dropdown suggestion -->
                        <!--    <div id="suggestions_fasyankes_name" class="autocomplete-overlay border bg-white rounded-bottom shadow-sm"-->
                        <!--      style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; display: none;">-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="col-sm-12  form-control-validation mt-2">
                          <label class="form-label" for="multiStepsConfirmPass">Alamat</label>
                          <textarea id="fasyankes_address" name="fasyankes_address" class="form-control"
                            readonly></textarea>
                        </div>
                      </div>
                    </div>
                    <!-- Fasyankes Mode /end -->

                    <!-- Non Fasyankes Mode /start -->
                    <div id="non_fasyankes_mode">
                      <div class="row">
                        <div class="col-sm-12">
                          <label class="form-label">Nama Instansi Non Fasyankes</label>
                          <input type="hidden" name="nonfasyankes_id" id="nonfasyankes_id" class="form-control" autocomplete="off" />
                          <div class="position-relative">
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
                      </div>
                      <div class="row mt-3">
                        <div class="col-sm-12  form-control-validation mt-2">
                          <label class="form-label" for="multiStepsConfirmPass">Alamat Instansi Non Fasyankes</label>
                          <textarea id="nonfasyankes_address" name="nonfasyankes_address" class="form-control"
                            readonly></textarea>
                        </div>
                      </div>
                    </div>
                    <!-- Non Fasyankes Mode /end -->


                    <div class="col-12 d-flex justify-content-between">
                      <button class="btn btn-label-secondary btn-prev">
                        <i class="icon-base ti tabler-arrow-left icon-xs me-sm-2 me-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                      </button>
                      <button class="btn btn-primary btn-next" id="segment2" disabled>
                        <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Selanjutnya</span>
                        <i class="icon-base ti tabler-arrow-right icon-xs"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <!-- Billing Links -->
                <div id="billingLinksValidation" class="content">
                  <div class="row g-6">



                    <div class="col-sm-12">
                      <label class="form-label" for="fullname">Nama Lengkap (tanpa gelar)</label>
                        <input type="text" id="fullname" name="user_fullname"
                          class="form-control " placeholder="Masukan nama lengkap tanpa gelar" />                      
                    </div>

                    <div class="col-sm-6">
                      <label class="form-label" for="MobileNumber">Nomor Telepon</label>
                      <div class="input-group">
                        <span class="input-group-text">(+62)</span>
                        <input type="text" id="MobileNumber" name="user_mobilenumber"
                          class="form-control multi-steps-mobile" placeholder="81 234 xxx xxx" />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="email">E-mail</label>
                      <input type="Email" id="email" name="user_email" class="form-control"
                        placeholder="Masukan alamat email valid" />
                    </div>
                    <div class="col-md-12">
                      <label class="form-label" for="user_password">Password</label>
                      <input type="password" id="user_password" name="user_password" class="form-control" />
                    </div>
                    <div class="col-sm-12 d-flex flex-column align-items-center">
                      <label class="form-label">Captcha</label>

                      <img id="captchaImg" src="<?= base_url('captcha') ?>" alt="captcha"
                        style="border:1px solid #ccc;">

                      <a href="javascript:void(0);" id="reloadCaptcha"
                        class="mt-1 text-primary text-decoration-underline" style="cursor:pointer;">
                        Perbarui Captcha
                      </a>

                      <input type="text" name="captcha" class="form-control mt-2 text-center"
                        placeholder="Masukkan captcha" style="width: 180px;">
                    </div>


                    <!-- Credit Card Details -->
                    <div class="col-12 d-flex justify-content-between form-control-validation">
                      <button class="btn btn-label-secondary btn-prev">
                        <i class="icon-base ti tabler-arrow-left icon-xs me-sm-2 me-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                      </button>
                      <button type="submit" class="btn btn-success btn-next btn-submit"
                        id="btnRegister">Register</button>
                    </div>
                  </div>
                  <!--/ Credit Card Details -->
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- / Multi Steps Registration -->
    </div>
  </div>

  <!-- Modal OTP -->
  <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow-lg">
        <div class="modal-header">
          <h5 class="modal-title" id="otpModalLabel">Masukkan Kode OTP</h5>
        </div>
        <div class="modal-body text-center">
          <p class="mb-3">Kami telah mengirimkan kode OTP ke nomor <strong id="otpPhoneNumber"></strong>. melalui
            WhatsApp</p>
          <form id="otpForm">
            <div class="d-flex justify-content-center gap-2 mb-3">
              <input type="text" maxlength="1" class="form-control text-center otp-input" inputmode="numeric"
                pattern="[0-9]*" style="width:45px;height:55px;font-size:1.5rem;">
              <input type="text" maxlength="1" class="form-control text-center otp-input" inputmode="numeric"
                pattern="[0-9]*" style="width:45px;height:55px;font-size:1.5rem;">
              <input type="text" maxlength="1" class="form-control text-center otp-input" inputmode="numeric"
                pattern="[0-9]*" style="width:45px;height:55px;font-size:1.5rem;">
              <input type="text" maxlength="1" class="form-control text-center otp-input" inputmode="numeric"
                pattern="[0-9]*" style="width:45px;height:55px;font-size:1.5rem;">
              <input type="text" maxlength="1" class="form-control text-center otp-input" inputmode="numeric"
                pattern="[0-9]*" style="width:45px;height:55px;font-size:1.5rem;">
              <input type="text" maxlength="1" class="form-control text-center otp-input" inputmode="numeric"
                pattern="[0-9]*" style="width:45px;height:55px;font-size:1.5rem;">
            </div>
            <button type="submit" class="btn btn-primary w-100">Verifikasi OTP</button>
          </form>
          <div class="mt-3">
            <small>Belum menerima kode? <a href="#" id="resendOtpLink">Kirim ulang</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
    window.Helpers.initCustomOptionCheck();
  </script>

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/theme.js -->


  <script src="<?= base_url('assets/vendor/libs/popper/popper.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/node-waves/node-waves.js') ?>"></script>

  <script src="<?= base_url('assets/vendor/libs/@algolia/autocomplete-js.js') ?>"></script>

  <script src="<?= base_url('assets/vendor/libs/pickr/pickr.js') ?>"></script>

  <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

  <script src="<?= base_url('assets/vendor/libs/hammer/hammer.js') ?>"></script>

  <script src="<?= base_url('assets/vendor/libs/i18n/i18n.js') ?>"></script>

  <script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="<?= base_url('assets/vendor/libs/cleave-zen/cleave-zen.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/bs-stepper/bs-stepper.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/select2/select2.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/@form-validation/popular.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/@form-validation/bootstrap5.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/@form-validation/auto-focus.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.2/dist/sweetalert2.all.min.js"></script>

  <!-- Main JS -->

  <script src="<?= base_url('assets/js/main.js') ?>"></script>

  <!-- Page JS -->
  <script src="<?= base_url('assets/js/pages-auth-multisteps.js') ?>"></script>
  <script>
    // === Global Utility ===
    const showAlert = (type, message, redirect = null) => {
      Swal.fire({
        text: message,
        icon: type,
        confirmButtonText: 'OK'
      }).then((result) => {
        if (redirect && result.isConfirmed) window.location.href = redirect;
      });
    };

    const ajaxPost = (url, data, successCb, errorCb) => {
      $.ajax({
        url,
        method: 'POST',
        data,
        dataType: 'json',
        success: successCb,
        error: xhr => errorCb && errorCb(xhr)
      });
    };

    const ajaxGet = (url, successCb, errorCb) => {
      $.ajax({
        url,
        method: 'GET',
        dataType: 'json',
        success: successCb,
        error: xhr => errorCb && errorCb(xhr)
      });
    };

    

    $(document).ready(function () {
      const base_url = "<?= base_url() ?>";
      const api_url = `${base_url}api`;

      const reloadCaptcha = () =>
        $('#captchaImg').attr('src', `${base_url}captcha?t=${Date.now()}`);

      // === Detail Handlers ===
      const fillForm = (res, fields) => {
        if (res.code === 200) {
           Object.entries(fields).forEach(([key, val]) => $(`#${key}`).val(val));
          $('#segment2').prop('disabled', false);
        } else {
          Object.keys(fields).forEach(key => $(`#${key}`).val(""));
          $('#segment2').prop('disabled', true);
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

      // Kondisi khusus untuk fasyankes_type
      if (formField === "fasyankes_type") {
        if (type === "fasyankes" && value.toLowerCase() === "rumahsakit") {
          value = "RUMAH SAKIT"; // khusus rumah sakit
        } else {
          value = value.toUpperCase(); // selain rumah sakit tetap uppercase
        }
      }

      filled[formField] = value;
    });

    fillForm(res, filled);
    if (typeof cb === "function") cb(res, filled);
  });
};


      // === Captcha reload ===
      $('#reloadCaptcha').click(reloadCaptcha);

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
            ${item.code} - ${item.type === 'puskesmas' ? item.type.toUpperCase() + ' ' : ''}${item.name}
          </div>`
        );
        
        liveSearch('#fasyankes_name', 'fasyankesname', '#suggestions_fasyankes_name',
          item => `<div class="item" data-code="${item.code}" data-id="${item.id}">
            ${item.code} - ${item.type === 'puskesmas' ? item.type.toUpperCase() + ' ' : ''}${item.name}
          </div>`
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
      
      $('#segment1').click(function () {
        const selected = $('input[name="fasyankes_mode"]:checked').val();
        $('#fasyankes_mode, #non_fasyankes_mode').hide();
        if (selected === 'fasyankes') $('#fasyankes_mode').show();
        else if (selected === 'non-fasyankes') $('#non_fasyankes_mode').show();
        else showAlert('error', 'Wajib ada yang dipilih');
        $('#segment2').prop('disabled', true);
        $('#multiStepsForm').find('input:not([type="submit"]):input:not([type="radio"]):not([type="button"]):not([type="hidden"]), textarea').val('');

      });
      
      $('#btnRegister').click(function () {

        Swal.fire({
          title: "Loading...",
          text: "Sedang memproses pendaftaran, mohon tunggu",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        const captcha = $('input[name="captcha"]').val();

        $.ajax({
          url: $('#multiStepsForm').attr('action'),
          method: $('#multiStepsForm').attr('method'),
          data: $('#multiStepsForm').serialize(),
          dataType: 'json',
          success: res => {
            Swal.close();
            if (res.code === 400) {
              if (res.show_otp_modal) {
                const otpModal = new bootstrap.Modal('#otpModal');

                Swal.fire({
                  text: res.message,
                  icon: res.type,
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.isConfirmed) {
                    $('#otpPhoneNumber').text(res.data.mobile);
                    otpModal.show();
                  }
                });

              } else {
                showAlert(res.type, res.message);
                reloadCaptcha();
                $('input[name="captcha"]').val('');
              }
            } else {
              const otpModal = new bootstrap.Modal('#otpModal');
              $('#otpPhoneNumber').text('+' + res.data.mobile);
              otpModal.show();
            }
          }
        });
      });

      const otpInputs = document.querySelectorAll('.otp-input');
      const otpForm = document.getElementById('otpForm');
      const resendBtn = document.getElementById('resendOtpLink');

      otpInputs.forEach((input, idx) => {
        input.addEventListener('input', function () {
          this.value = this.value.replace(/\D/g, '');
          if (this.value && idx < otpInputs.length - 1) otpInputs[idx + 1].focus();
        });

        input.addEventListener('keydown', e => {
          if (e.key === "Backspace" && !this.value && idx > 0) otpInputs[idx - 1].focus();
        });

        input.addEventListener('paste', e => {
          e.preventDefault();
          const digits = (e.clipboardData.getData('text') || '').replace(/\D/g, '').slice(0, otpInputs.length);
          otpInputs.forEach((box, i) => box.value = digits[i] || '');
        });
      });

      otpForm.addEventListener('submit', e => {
        e.preventDefault();
        Swal.fire({
          title: "Verifikasi OTP...",
          text: "Sedang memverifikasi kode, mohon tunggu",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        const otp = Array.from(otpInputs).map(i => i.value).join('');
        if (otp.length < otpInputs.length) return showAlert('error', 'Silakan isi semua digit OTP');

        fetch(`${base_url}register/verifyOtp`, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: new URLSearchParams({ otp })
        })
          .then(res => {
            if (!res.ok) {
              return res.text().then(text => {
                console.error("Server Error Response:", text);
                throw new Error(`HTTP error! Status: ${res.status}`);
              });
            }
            return res.json();
          })
          .then(data => {
            Swal.close();
            if (data.status) {
              bootstrap.Modal.getInstance(document.getElementById('otpModal')).hide();
              showAlert(data.type, data.message, './login');
            } else {
              showAlert('error', data.message);
            }
          })
          .catch(err => {
            console.error("Fetch Error:", err);  
          });
      });


      resendBtn.addEventListener('click', e => {
        e.preventDefault();
        resendBtn.disabled = true;
        resendBtn.textContent = "Mengirim ulang...";
        fetch(`${base_url}register/resendOtp`, {
          method: "POST"
        })
          .then(res => res.json())
          .then(data => {
            showAlert(data.status ? 'success' : 'error', data.message);
            resendBtn.disabled = false;
            resendBtn.textContent = "Kirim Ulang OTP";
          });
      });
    });
  </script>
</body>

</html>