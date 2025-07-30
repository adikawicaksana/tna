
<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  dir="ltr"
  data-skin="default"
  data-assets-path="<?= base_url('assets/') ?>"
  data-template="vertical-menu-template"
  data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= isset($title) ? esc($title) . ' | ' : '' ?>Murnajati</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/front-pages/landing-page/logo_provinsi_jatim.png') ?>" />

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
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/@form-validation/form-validation.css') ?>" />

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

    <div class="authentication-wrapper authentication-cover">
      <!-- Logo -->
      <a href="index.html" class="app-brand auth-cover-brand">
        <span class="app-brand-logo demo">
          <span class="text-primary">
            <img src="<?= base_url('assets/img/front-pages/landing-page/logo_provinsi_jatim.png') ?>" height="50">
          </span>
        </span>
        <span class="app-brand-text demo text-heading fw-bold">UPT Pelatihan Kesehatan Masyarakat Murnajati</span>
      </a>
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-xl-flex col-xl-8 p-0">
          <div class="auth-cover-bg d-flex justify-content-center align-items-center">
            <img
              src="<?= base_url('assets/img/illustrations/illustration-doctor.png') ?>"
              alt="auth-login-cover"
              class="my-5 auth-illustration"
              data-app-light-img="illustrations/illustration-doctor.png"
              data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
            <img
              src="<?= base_url('assets/img/illustrations/bg-shape-image-light.png') ?>"
              alt="auth-login-cover"
              class="platform-bg"
              data-app-light-img="illustrations/bg-shape-image-light.png"
              data-app-dark-img="illustrations/bg-shape-image-dark.png" />
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
          <div class="w-px-400 mx-auto mt-12 pt-5">
            <h4 class="mb-1">Selamat datang! 👋</h4>
            <p class="mb-6">di Kawah Candradimuka Insan Kesehatan Indonesia</p>

            <form id="formAuthentication" class="mb-6" action="./login" method="POST">
              <?= csrf_field() ?>
              <div class="mb-6 form-control-validation">
                <label for="email" class="form-label">Email</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Enter your email "
                  autofocus />
              </div>
              <div class="mb-6 form-password-toggle form-control-validation">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
                </div>
              </div>
              <div class="my-8">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0 ms-2">
                  </div>
                  <a href="auth-forgot-password-cover.html">
                    <p class="mb-0">Lupa Password?</p>
                  </a>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100">Sign in</button>
            </form>

            <p class="text-center">
              <span>Belum punya akun ?</span>
              <a href="./register">
                <span>Buat Akun</span>
              </a>
            </p>

            <!-- <div class="divider my-6">
              <div class="divider-text">or</div>
            </div>

            <div class="d-flex justify-content-center">
              <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook me-1_5">
                <i class="icon-base ti tabler-brand-facebook-filled icon-20px"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter me-1_5">
                <i class="icon-base ti tabler-brand-twitter-filled icon-20px"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github me-1_5">
                <i class="icon-base ti tabler-brand-github-filled icon-20px"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
                <i class="icon-base ti tabler-brand-google-filled icon-20px"></i>
              </a>
            </div> -->
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>

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
    <script src="<?= base_url('assets/vendor/libs/@form-validation/popular.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/@form-validation/bootstrap5.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/@form-validation/auto-focus.js') ?>"></script>

    <!-- Main JS -->

    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <!-- Page JS -->
    <script src="<?= base_url('assets/js/pages-auth.js') ?>"></script>
  </body>
</html>

