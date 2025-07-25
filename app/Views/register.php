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
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-auth.css') ?>" />

  <!-- Helpers -->
  <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="<?= base_url('assets/vendor/js/template-customizer.js') ?>"></script>

  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

  <script src="<?= base_url('assets/js/config.js') ?>"></script>
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
              <form id="multiStepsForm" onSubmit="return false">
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
                         
                        Bagi Anda SDMK atau non-SDMK yang bertugas di Fasilitas Pelayanan Kesehatan (Rumah Sakit, Puskesmas, Klinik, Laboratorium, Apotek, Praktik Dokter, Praktik Bidan, Praktik Perawat, atau Balai Kesehatan).
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
                          <div class="col-sm-12 form-password-toggle form-control-validation">
                            <label class="form-label">Nama Fasyankes</label>
                            <input type="text" id="fasyankes_name" name="fasyankes_name" class="form-control" readonly />
                          </div>
                          <div class="col-sm-12 form-password-toggle form-control-validation mt-2">
                            <label class="form-label" for="multiStepsConfirmPass">Alamat</label>
                            <textarea id="fasyankes_address" name="fasyankes_address" class="form-control" readonly></textarea>
                          </div>
                        </div>
                      </div>
                    <!-- Fasyankes Mode /end -->
                    
                    <!-- Non Fasyankes Mode /start -->
                      <div id="non_fasyankes_mode">
                        <div class="row">
                          <div class="col-sm-12">
                            <label class="form-label">Nama Instansi</label>
                            <div class="position-relative">
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
                              <div id="institution_suggestions" class="autocomplete-overlay border bg-white rounded-bottom shadow-sm"
                                style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; display: none;">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="col-sm-12 form-password-toggle form-control-validation mt-2">
                            <label class="form-label" for="multiStepsConfirmPass">Alamat Institusi</label>
                            <textarea id="institution_address" name="institution_address" class="form-control" readonly></textarea>
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

                    <div class="col-sm-6 form-control-validation">
                      <label class="form-label" for="multiStepsFirstName">First Name</label>
                      <input type="text" id="multiStepsFirstName" name="multiStepsFirstName" class="form-control"
                        placeholder="John" />
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="multiStepsLastName">Last Name</label>
                      <input type="text" id="multiStepsLastName" name="multiStepsLastName" class="form-control"
                        placeholder="Doe" />
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="multiStepsMobile">Mobile</label>
                      <div class="input-group">
                        <span class="input-group-text">US (+1)</span>
                        <input type="text" id="multiStepsMobile" name="multiStepsMobile"
                          class="form-control multi-steps-mobile" placeholder="202 555 0111" />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="multiStepsPincode">Pincode</label>
                      <input type="text" id="multiStepsPincode" name="multiStepsPincode"
                        class="form-control multi-steps-pincode" placeholder="Postal Code" maxlength="6" />
                    </div>
                    <div class="col-md-12 form-control-validation">
                      <label class="form-label" for="multiStepsAddress">Address</label>
                      <input type="text" id="multiStepsAddress" name="multiStepsAddress" class="form-control"
                        placeholder="Address" />
                    </div>
                    <div class="col-md-12">
                      <label class="form-label" for="multiStepsArea">Landmark</label>
                      <input type="text" id="multiStepsArea" name="multiStepsArea" class="form-control"
                        placeholder="Area/Landmark" />
                    </div>
                    <div class="col-sm-6 form-control-validation">
                      <label class="form-label" for="multiStepsCity">City</label>
                      <input type="text" id="multiStepsCity" class="form-control" placeholder="Jackson" />
                    </div>
                    <div class="col-sm-6 form-control-validation">
                      <label class="form-label" for="multiStepsState">State</label>
                      <select id="multiStepsState" class="select2 form-select" data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                      </select>
                    </div>
                    <!-- Credit Card Details -->
                    <div class="col-12 d-flex justify-content-between form-control-validation">
                      <button class="btn btn-label-secondary btn-prev">
                        <i class="icon-base ti tabler-arrow-left icon-xs me-sm-2 me-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                      </button>
                      <button type="submit" class="btn btn-success btn-next btn-submit">Submit</button>
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

  <script>
    // Check selected custom option
    window.Helpers.initCustomOptionCheck();
  </script>

  <!-- / Content -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/theme.js -->

  <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>

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
    function FasyankesDetail(code) {
      const base_url = "<?= base_url() ?>";
      var url = base_url + 'api/fasyankes_check'; // 13 = tombol Enter
      const value = code;

      $.ajax({
        url: url,
        method: 'POST',
        data: {
          fasyankes_code: value
        },
        success: function (response) {
          var result = response.data;
          if (response.code === 200) {
            $('#fasyankes_type').val(result.fasyankes_type.toUpperCase());
            $('#fasyankes_name').val(result.fasyankes_name);
            $('#fasyankes_address').val(result.fasyankes_address);
            $('#segment2').prop('disabled', false);
          } else {
            $('#fasyankes_type').val("");
            $('#fasyankes_name').val("");
            $('#fasyankes_address').val("");
            $('#segment2').prop('disabled', true);
          }

          Swal.fire({
            // title: "Gagal!",
            text: response.message,
            icon: response.type
          });
        },
        error: function (xhr) {
          console.error(xhr.responseText);

        }
      });

    }

    function InstitutionDetail(id) {
      const base_url = "<?= base_url() ?>";
      var url = base_url + 'api/institution_check'; // 13 = tombol Enter
      const value = id;

      $.ajax({
        url: url,
        method: 'POST',
        data: {
          id: value
        },
        success: function (response) {
          console.log(response)
          var result = response.data;
          if (response.code === 200) {
            $('#institution_name').val(result.institution_name);
            $('#institution_address').val(result.institution_address);
            $('#segment2').prop('disabled', false);
          } else {
            $('#institution_name').val("");
            $('#institution_address').val("");
            $('#segment2').prop('disabled', true);
          }

          Swal.fire({
            // title: "Gagal!",
            text: response.message,
            icon: response.type
          });
        },
        error: function (xhr) {
          console.error(xhr.responseText);

        }
      });

    }

    
    $('#fasyankes_code').on('keypress', function (e) {
      if (e.which === 13) {
        e.preventDefault();
        FasyankesDetail($(this).val());
      }
    });
    
    $('#institution_name').on('keypress', function (e) {
      if (e.which === 13) {
        e.preventDefault();
      }
    });

    $('#institution_name').on('keyup', function () {
      const base_url = "<?= base_url() ?>";
      const url = base_url + 'api/institution_search';
      let query = $(this).val();

      if (query.length > 1) {
        $.ajax({
          url: url,
          method: 'POST',
          data: {
            keyword: query
          },
          success: function (response) {
            let list = '';
            const results = response.data;

            if (results.length > 0) {
              results.forEach(function (item) {
                list += '<div class="item" data-id="' + item.id + '">' + item.text + '</div>';
              });
              $('#institution_suggestions').html(list).slideDown(150);
            } else {
              $('#institution_suggestions').html('<div class="item text-muted">Tidak ditemukan</div>').fadeIn();
            }
          },
          error: function (xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#institution_suggestions').slideUp(150);
      }
    });

    $('#fasyankes_code').on('keyup', function () {
      const base_url = "<?= base_url() ?>";
      const url = base_url + 'api/fasyankes_search';
      let query = $(this).val();

      if (query.length > 1) {
        $.ajax({
          url: url,
          method: 'POST',
          data: {
            keyword: query
          },
          success: function (response) {
            let list = '';
            const results = response.data;

            if (results.length > 0) {
              results.forEach(function (item) {
                list += '<div class="item" data-code="' + item.fasyankes_code + '">' + item.text + '</div>';
              });
              $('#suggestions').html(list).slideDown(150);
            } else {
              $('#suggestions').html('<div class="item text-muted">Tidak ditemukan</div>').fadeIn();
            }
          },
          error: function (xhr, status, error) {
            console.error('Error:', error);
          }
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
      const id = $(this).data('id');
      InstitutionDetail(id);
      $('#institution_suggestions').fadeOut();
    });


    $('#segment1').on('click', function () {
      var selected = $('input[name="fasyankes_mode"]:checked').val();
      if (selected === 'fasyankes') {
        $('#non_fasyankes_mode').hide();
        $('#fasyankes_mode').show();
      } else if (selected === 'non-fasyankes') {
        $('#fasyankes_mode').hide();
        $('#non_fasyankes_mode').show();
      } else {
        alert('Wajib ada yang dipilih');
        return
      }
    });
  </script>
</body>

</html>