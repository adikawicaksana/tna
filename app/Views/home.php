
<!doctype html>

<html
  lang="en"
  class="layout-navbar-fixed layout-wide"
  dir="ltr"
  data-skin="default"
  data-assets-path="<?= base_url('assets/') ?>"
  data-template="front-pages"
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

    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/front-page.css') ?>" />

    <!-- Vendors CSS -->

    <!-- endbuild -->

    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/nouislider/nouislider.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/swiper/swiper.css') ?>" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/front-page-landing.css') ?>" />

    <!-- Helpers -->
    <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="<?= base_url('assets/vendor/js/template-customizer.js') ?>"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="<?= base_url('assets/js/front-config.js') ?>"></script>
  </head>

  <body>
    <script src="<?= base_url('assets/vendor/js/dropdown-hover.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/mega-dropdown.js') ?>"></script>
    <!-- Navbar: Start -->
    <nav class="layout-navbar shadow-none py-0">
      <div class="container">
        <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">
          <!-- Menu logo wrapper: Start -->
          <div class="navbar-brand app-brand demo d-flex py-0 me-4 me-xl-8 ms-0">
            <!-- Mobile menu toggle: Start-->
            <button
              class="navbar-toggler border-0 px-0 me-4"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation">
              <i class="icon-base ti tabler-menu-2 icon-lg align-middle text-heading fw-medium"></i>
            </button>
            <!-- Mobile menu toggle: End-->
            <a href="./" class="app-brand-link">
              <span class="app-brand-logo demo">
                <span class="text-primary">
                  <img src="<?= base_url('assets/img/front-pages/landing-page/logo_provinsi_jatim.png') ?>" height="32">
                </span>
              </span>
              <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">MURNAJATI</span>
            </a>
          </div>
          <!-- Menu logo wrapper: End -->
          <!-- Menu wrapper: Start -->
          <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
            <button
              class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl p-2"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation">
              <i class="icon-base ti tabler-x icon-lg"></i>
            </button>
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link fw-medium" aria-current="page" href="./">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-medium" href="landing-page.html#landingFeatures">Formulir TNA SDMK</a>
              </li>
            </ul>
          </div>
          <div class="landing-menu-overlay d-lg-none"></div>
          <!-- Menu wrapper: End -->
          <!-- Toolbar: Start -->
          <ul class="navbar-nav flex-row align-items-center ms-auto">
            

            <!-- navbar button: Start -->
            <li>
              <a href="./login" class="btn btn-primary"
                ><span class="tf-icons icon-base ti tabler-login scaleX-n1-rtl me-md-1"></span
                ><span class="d-none d-md-block">Login/Register</span></a
              >
            </li>
            <!-- navbar button: End -->
          </ul>
          <!-- Toolbar: End -->
        </div>
      </div>
    </nav>
    <!-- Navbar: End -->

    <!-- Sections:Start -->

    <div data-bs-spy="scroll" class="scrollspy-example">
      <!-- Hero: Start -->
      <section id="hero-animation">
        <div id="landingHero" class="section-py landing-hero position-relative">
          <img
            src="<?= base_url('assets/img/front-pages/backgrounds/hero-bg.png') ?>"
            alt="hero background"
            class="position-absolute top-0 start-50 translate-middle-x object-fit-cover w-100 h-100"
            data-speed="1" />
          <div class="container">
            <div class="hero-text-box text-center position-relative">
              <h1 class="text-primary hero-title display-6 fw-extrabold">
                Training Need Assesment
              </h1>
              <h2 class="hero-sub-title h6 mb-6">
                UPT Pelatihan Kesehatan Masyarakat<br class="d-none d-lg-block" />
                Murnajati
              </h2>
            </div>
            <div id="heroDashboardAnimation" class="hero-animation-img">
              <a href="#" target="_blank">
                <div id="heroAnimationImg" class="position-relative hero-dashboard-img">
                  <img
                    src="<?= base_url('assets/img/front-pages/landing-page/dashboard-murnajati.png') ?>"
                    alt="hero dashboard"
                    class="animation-img"
                    data-app-light-img="front-pages/landing-page/dashboard-murnajati.png"
                    data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png" />
                  <img
                    src="<?= base_url('assets/img/front-pages/landing-page/element-murnajati.png') ?>"
                    alt="hero elements"
                    class="position-absolute hero-elements-img animation-img top-0 start-0"
                    data-app-light-img="front-pages/landing-page/element-murnajati.png"
                    data-app-dark-img="front-pages/landing-page/hero-elements-dark.png" />
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="landing-hero-blank"></div>
      </section>
      <!-- Hero: End -->

      <!-- Useful features: Start -->
      <section id="landingFeatures" class="section-py landing-features">
        <div class="container">
          <div class="text-center mb-4">
            <span class="badge bg-label-primary">Useful Features</span>
          </div>
          <h4 class="text-center mb-1">
            <span class="position-relative fw-extrabold z-1"
              >Everything you need
              <img
                src="<?= base_url('assets/img/front-pages/icons/section-title-icon.png') ?>"
                alt="laptop charging"
                class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
            to start your next project
          </h4>
          <p class="text-center mb-12">
            Not just a set of tools, the package includes ready-to-deploy conceptual application.
          </p>
          <div class="features-icon-wrapper row gx-0 gy-6 g-sm-12">
            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="mb-4 text-primary text-center">
                <svg width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    opacity="0.2"
                    d="M10 44.4663V18.4663C10 17.4054 10.4214 16.388 11.1716 15.6379C11.9217 14.8877 12.9391 14.4663 14 14.4663H50C51.0609 14.4663 52.0783 14.8877 52.8284 15.6379C53.5786 16.388 54 17.4054 54 18.4663V44.4663H10Z"
                    fill="currentColor" />
                  <path
                    d="M10 44.4663V18.4663C10 17.4054 10.4214 16.388 11.1716 15.6379C11.9217 14.8877 12.9391 14.4663 14 14.4663H50C51.0609 14.4663 52.0783 14.8877 52.8284 15.6379C53.5786 16.388 54 17.4054 54 18.4663V44.4663M36 22.4663H28M6 44.4663H58V48.4663C58 49.5272 57.5786 50.5446 56.8284 51.2947C56.0783 52.0449 55.0609 52.4663 54 52.4663H10C8.93913 52.4663 7.92172 52.0449 7.17157 51.2947C6.42143 50.5446 6 49.5272 6 48.4663V44.4663Z"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </div>
              <h5 class="mb-2">Quality Code</h5>
              <p class="features-icon-description">
                Code structure that all developers will easily understand and fall in love with.
              </p>
            </div>
            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="mb-4 text-primary text-center">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    opacity="0.2"
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M52.8934 36.9867L45.1661 27.709C45.4614 33.3937 44.0587 40.0137 39.7274 47.5687L47.1102 53.475C47.3728 53.6835 47.6842 53.8215 48.0149 53.8759C48.3457 53.9303 48.6849 53.8994 49.0004 53.786C49.3159 53.6726 49.5972 53.4806 49.8177 53.228C50.0381 52.9755 50.1905 52.6709 50.2602 52.343L53.2872 38.6602C53.3602 38.3701 53.3625 38.0667 53.294 37.7755C53.2255 37.4843 53.0881 37.2138 52.8934 36.9867ZM10.959 37.1344L18.6864 27.8813C18.3911 33.566 19.7938 40.1859 24.1251 47.7164L16.7422 53.6227C16.4814 53.8311 16.1718 53.9698 15.8426 54.0256C15.5134 54.0814 15.1754 54.0526 14.8604 53.9419C14.5453 53.8311 14.2637 53.6421 14.0418 53.3925C13.82 53.143 13.6653 52.8411 13.5922 52.5152L10.5653 38.8078C10.4923 38.5177 10.49 38.2144 10.5585 37.9232C10.627 37.632 10.7644 37.3615 10.959 37.1344Z"
                    fill="currentColor" />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M30.1373 4.56417C30.661 4.13034 31.3197 3.89282 31.9999 3.89282C32.6817 3.89282 33.3419 4.1314 33.8661 4.56708C36.2461 6.5048 41.3981 11.3124 44.2413 18.7028C45.231 21.2754 45.9359 24.1485 46.1526 27.3062L53.8054 36.4894C54.1015 36.8368 54.3105 37.2498 54.4151 37.6941C54.519 38.1357 54.5167 38.5956 54.4085 39.0361L51.3844 52.7309L51.3837 52.734C51.2735 53.2253 51.0402 53.6805 50.7057 54.0569C50.3712 54.4332 49.9465 54.7183 49.4715 54.8853C48.9964 55.0523 48.4867 55.0957 47.9903 55.0115C47.4939 54.9273 47.027 54.7182 46.6337 54.4039L46.6332 54.4035L39.5243 48.7164H24.4758L17.3669 54.4035L17.3665 54.4039C16.9731 54.7182 16.5062 54.9273 16.0098 55.0115C15.5134 55.0957 15.0037 55.0523 14.5287 54.8853C14.0537 54.7183 13.6289 54.4332 13.2944 54.0569C12.9599 53.6805 12.7266 53.2253 12.6165 52.734L12.6158 52.7309L9.59162 39.0361C9.48345 38.5957 9.48117 38.1358 9.58509 37.6941C9.68969 37.2496 9.89886 36.8364 10.1952 36.489L17.7037 27.4979C17.9004 24.2604 18.619 21.3188 19.6398 18.6906C22.5111 11.2981 27.7301 6.49122 30.1373 4.56417ZM44.1834 27.8703C44.1674 27.7856 44.1625 27.6995 44.1686 27.6142C43.9794 24.5834 43.3088 21.8491 42.3746 19.4209C39.7071 12.4872 34.8477 7.94455 32.5992 6.11468L32.5893 6.10666L32.5894 6.1066C32.424 5.96848 32.2154 5.89282 31.9999 5.89282C31.7845 5.89282 31.5759 5.96848 31.4105 6.1066L31.3942 6.11994C29.1222 7.93749 24.1977 12.4799 21.5041 19.4147C20.5347 21.9107 19.8484 24.7306 19.6863 27.8638C19.6871 27.9087 19.6849 27.9536 19.6796 27.9984C19.4292 33.348 20.7083 39.6051 24.7062 46.7164H39.2879C43.2365 39.5474 44.4691 33.2477 44.1834 27.8703ZM52.2729 37.7746L46.2018 30.4892C46.0153 35.5301 44.567 41.2065 41.1592 47.4631L47.8821 52.8414C48.0105 52.944 48.1628 53.0122 48.3248 53.0397C48.4868 53.0672 48.6531 53.053 48.8081 52.9985C48.9631 52.944 49.1017 52.851 49.2109 52.7282C49.3197 52.6057 49.3957 52.4576 49.4318 52.2978L49.4321 52.2965L52.4584 38.5922C52.4605 38.5827 52.4627 38.5733 52.4651 38.5639C52.499 38.4289 52.5001 38.2877 52.4682 38.1522C52.4363 38.0167 52.3724 37.8908 52.2818 37.7852L52.2728 37.7746L52.2729 37.7746ZM17.6801 30.6463L11.7266 37.7754L11.7184 37.7852L11.7183 37.7852C11.6277 37.8908 11.5638 38.0167 11.5319 38.1522C11.5 38.2877 11.5011 38.4289 11.5351 38.5639C11.5374 38.5733 11.5397 38.5827 11.5418 38.5922L14.568 52.2965L14.5683 52.2978C14.6044 52.4576 14.6804 52.6057 14.7893 52.7282C14.8984 52.851 15.037 52.944 15.192 52.9985C15.347 53.053 15.5133 53.0672 15.6753 53.0397C15.8373 53.0122 15.9897 52.944 16.118 52.8414L22.835 47.4678C19.3947 41.2766 17.9053 35.6511 17.6801 30.6463ZM27.0626 55.5914C27.0626 55.0391 27.5103 54.5914 28.0626 54.5914H35.9376C36.4899 54.5914 36.9376 55.0391 36.9376 55.5914C36.9376 56.1437 36.4899 56.5914 35.9376 56.5914H28.0626C27.5103 56.5914 27.0626 56.1437 27.0626 55.5914ZM34.9532 24.0914C34.9532 25.7224 33.631 27.0445 32.0001 27.0445C30.3691 27.0445 29.047 25.7224 29.047 24.0914C29.047 22.4604 30.3691 21.1383 32.0001 21.1383C33.631 21.1383 34.9532 22.4604 34.9532 24.0914Z"
                    fill="currentColor" />
                </svg>
              </div>
              <h5 class="mb-2">Continuous Updates</h5>
              <p class="features-icon-description">
                Free updates for the next 12 months, including new demos and features.
              </p>
            </div>
            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="text-center mb-4 text-primary">
                <svg width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    opacity="0.2"
                    d="M52.575 9.44123L5.97499 22.5662C5.57831 22.6747 5.2247 22.9028 4.96234 23.2195C4.69997 23.5361 4.54161 23.926 4.50881 24.3359C4.47602 24.7459 4.57039 25.1559 4.77907 25.5103C4.98775 25.8647 5.3006 26.1461 5.67499 26.3162L27.075 36.4412C27.4942 36.6354 27.8309 36.972 28.025 37.3912L38.15 58.7912C38.3201 59.1656 38.6016 59.4785 38.9559 59.6872C39.3103 59.8958 39.7204 59.9902 40.1303 59.9574C40.5402 59.9246 40.9301 59.7662 41.2468 59.5039C41.5634 59.2415 41.7915 58.8879 41.9 58.4912L55.025 11.8912C55.1245 11.5512 55.1306 11.1906 55.0428 10.8474C54.955 10.5041 54.7765 10.1908 54.5259 9.94028C54.2754 9.68975 53.9621 9.51123 53.6189 9.42342C53.2756 9.33562 52.9151 9.34177 52.575 9.44123Z"
                    fill="currentColor" />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M53.8666 8.45462C53.3513 8.32282 52.8102 8.33156 52.2995 8.47988L52.2942 8.48144L5.71115 21.6016L5.70701 21.6028C5.11366 21.7659 4.5848 22.1076 4.19216 22.5815C3.79862 23.0565 3.56107 23.6413 3.51188 24.2562C3.46268 24.8711 3.60424 25.4862 3.91726 26.0177C4.22884 26.5468 4.69522 26.9675 5.25338 27.2231L26.6472 37.3452L26.6472 37.3452L26.6546 37.3486C26.8589 37.4432 27.0229 37.6072 27.1175 37.8115L27.1174 37.8115L27.1209 37.8189L37.243 59.2126C37.4985 59.7708 37.9192 60.2372 38.4484 60.5488C38.9799 60.8619 39.595 61.0034 40.2099 60.9542C40.8248 60.905 41.4096 60.6675 41.8846 60.2739C42.3586 59.8813 42.7002 59.3524 42.8634 58.759L42.8645 58.755L55.9847 12.1719L55.9862 12.1668C56.1346 11.656 56.1433 11.1149 56.0115 10.5996C55.8792 10.0825 55.6103 9.61055 55.2329 9.23317C54.8556 8.85579 54.3836 8.58688 53.8666 8.45462ZM52.846 10.4038L52.5749 9.44123L52.8556 10.401C53.0235 10.3519 53.2015 10.3489 53.3709 10.3922C53.5404 10.4356 53.695 10.5237 53.8187 10.6474C53.9424 10.7711 54.0305 10.9257 54.0739 11.0952C54.1172 11.2646 54.1142 11.4426 54.0651 11.6105L54.065 11.6105L54.0623 11.6201L40.9373 58.2201L40.9353 58.2275C40.8811 58.4258 40.767 58.6026 40.6087 58.7338C40.4503 58.865 40.2554 58.9442 40.0504 58.9606C39.8455 58.977 39.6404 58.9298 39.4632 58.8255C39.2861 58.7211 39.1454 58.5647 39.0603 58.3775L39.0538 58.3635L28.9323 36.971L28.9303 36.9667C28.9285 36.9629 28.9268 36.9591 28.925 36.9553L39.732 26.1483C40.1225 25.7578 40.1225 25.1246 39.732 24.7341C39.3415 24.3436 38.7083 24.3436 38.3178 24.7341L27.5108 35.5411C27.5069 35.5393 27.503 35.5375 27.4991 35.5357L6.10255 25.4123L6.0886 25.4058C5.9014 25.3208 5.74498 25.18 5.64064 25.0029C5.53629 24.8257 5.48911 24.6206 5.50551 24.4157C5.5219 24.2107 5.60109 24.0158 5.73227 23.8574C5.86345 23.6991 6.04025 23.5851 6.2386 23.5308L6.2386 23.5309L6.24598 23.5288L52.846 10.4038Z"
                    fill="currentColor" />
                </svg>
              </div>
              <h5 class="mb-2">Stater-Kit</h5>
              <p class="features-icon-description">
                Start your project quickly without having to remove unnecessary features.
              </p>
            </div>
            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="text-center mb-4 text-primary">
                <svg width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    opacity="0.2"
                    d="M13.625 50.8413C11.325 48.5413 12.85 43.7163 11.675 40.8913C10.5 38.0663 6 35.5913 6 32.4663C6 29.3413 10.45 26.9663 11.675 24.0413C12.9 21.1163 11.325 16.3913 13.625 14.0913C15.925 11.7913 20.75 13.3163 23.575 12.1413C26.4 10.9663 28.875 6.46631 32 6.46631C35.125 6.46631 37.5 10.9163 40.425 12.1413C43.35 13.3663 48.075 11.7913 50.375 14.0913C52.675 16.3913 51.15 21.2163 52.325 24.0413C53.5 26.8663 58 29.3413 58 32.4663C58 35.5913 53.55 37.9663 52.325 40.8913C51.1 43.8163 52.675 48.5413 50.375 50.8413C48.075 53.1413 43.25 51.6163 40.425 52.7913C37.6 53.9663 35.125 58.4663 32 58.4663C28.875 58.4663 26.5 54.0163 23.575 52.7913C20.65 51.5663 15.925 53.1413 13.625 50.8413Z"
                    fill="currentColor" />
                  <path
                    d="M43 26.4663L28.325 40.4663L21 33.4663M13.625 50.8413C11.325 48.5413 12.85 43.7163 11.675 40.8913C10.5 38.0663 6 35.5913 6 32.4663C6 29.3413 10.45 26.9663 11.675 24.0413C12.9 21.1163 11.325 16.3913 13.625 14.0913C15.925 11.7913 20.75 13.3163 23.575 12.1413C26.4 10.9663 28.875 6.46631 32 6.46631C35.125 6.46631 37.5 10.9163 40.425 12.1413C43.35 13.3663 48.075 11.7913 50.375 14.0913C52.675 16.3913 51.15 21.2163 52.325 24.0413C53.5 26.8663 58 29.3413 58 32.4663C58 35.5913 53.55 37.9663 52.325 40.8913C51.1 43.8163 52.675 48.5413 50.375 50.8413C48.075 53.1413 43.25 51.6163 40.425 52.7913C37.6 53.9663 35.125 58.4663 32 58.4663C28.875 58.4663 26.5 54.0163 23.575 52.7913C20.65 51.5663 15.925 53.1413 13.625 50.8413Z"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </div>
              <h5 class="mb-2">API Ready</h5>
              <p class="features-icon-description">
                Just change the endpoint and see your own data loaded within seconds.
              </p>
            </div>
            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="text-center mb-4 text-primary">
                <svg width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    opacity="0.2"
                    d="M31.9999 8.46631C27.1437 8.46489 22.4012 9.93672 18.399 12.6874C14.3969 15.438 11.3233 19.3381 9.58436 23.8723C7.84542 28.4066 7.52291 33.3617 8.65945 38.0831C9.79598 42.8045 12.3381 47.0701 15.9499 50.3163C17.4549 47.3526 19.7511 44.8636 22.5841 43.125C25.417 41.3864 28.676 40.4662 31.9999 40.4663C30.0221 40.4663 28.0887 39.8798 26.4442 38.781C24.7997 37.6822 23.518 36.1204 22.7611 34.2931C22.0043 32.4659 21.8062 30.4552 22.1921 28.5154C22.5779 26.5756 23.5303 24.7938 24.9289 23.3952C26.3274 21.9967 28.1092 21.0443 30.049 20.6585C31.9888 20.2726 33.9995 20.4706 35.8268 21.2275C37.654 21.9844 39.2158 23.2661 40.3146 24.9106C41.4135 26.5551 41.9999 28.4885 41.9999 30.4663C41.9999 33.1185 40.9464 35.662 39.071 37.5374C37.1956 39.4127 34.6521 40.4663 31.9999 40.4663C35.3238 40.4662 38.5829 41.3864 41.4158 43.125C44.2487 44.8636 46.545 47.3526 48.0499 50.3163C51.6618 47.0701 54.2039 42.8045 55.3404 38.0831C56.477 33.3617 56.1545 28.4066 54.4155 23.8723C52.6766 19.3381 49.603 15.438 45.6008 12.6874C41.5987 9.93672 36.8562 8.46489 31.9999 8.46631Z"
                    fill="currentColor" />
                  <path
                    d="M32 40.4663C37.5228 40.4663 42 35.9892 42 30.4663C42 24.9435 37.5228 20.4663 32 20.4663C26.4772 20.4663 22 24.9435 22 30.4663C22 35.9892 26.4772 40.4663 32 40.4663ZM32 40.4663C28.6759 40.4663 25.4168 41.3852 22.5839 43.1241C19.7509 44.863 17.4548 47.3524 15.95 50.3163M32 40.4663C35.3241 40.4663 38.5832 41.3852 41.4161 43.1241C44.2491 44.863 46.5452 47.3524 48.05 50.3163M56 32.4663C56 45.7211 45.2548 56.4663 32 56.4663C18.7452 56.4663 8 45.7211 8 32.4663C8 19.2115 18.7452 8.46631 32 8.46631C45.2548 8.46631 56 19.2115 56 32.4663Z"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </div>
              <h5 class="mb-2">Excellent Support</h5>
              <p class="features-icon-description">An easy-to-follow doc with lots of references and code examples.</p>
            </div>
            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="text-center mb-4 text-primary">
                <svg width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    opacity="0.2"
                    d="M55.875 14.4663H8.125C6.95139 14.4663 6 15.4177 6 16.5913V48.3413C6 49.5149 6.95139 50.4663 8.125 50.4663H55.875C57.0486 50.4663 58 49.5149 58 48.3413V16.5913C58 15.4177 57.0486 14.4663 55.875 14.4663Z"
                    fill="currentColor" />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M7 16.5913C7 15.97 7.50368 15.4663 8.125 15.4663H55.875C56.4963 15.4663 57 15.97 57 16.5913V48.3413C57 48.9626 56.4963 49.4663 55.875 49.4663H8.125C7.50368 49.4663 7 48.9626 7 48.3413V16.5913ZM8.125 13.4663C6.39911 13.4663 5 14.8654 5 16.5913V48.3413C5 50.0672 6.39911 51.4663 8.125 51.4663H55.875C57.6009 51.4663 59 50.0672 59 48.3413V16.5913C59 14.8654 57.6009 13.4663 55.875 13.4663H8.125ZM14 23.4663C13.4477 23.4663 13 23.914 13 24.4663C13 25.0186 13.4477 25.4663 14 25.4663H50C50.5523 25.4663 51 25.0186 51 24.4663C51 23.914 50.5523 23.4663 50 23.4663H14ZM14 31.4663C13.4477 31.4663 13 31.914 13 32.4663C13 33.0186 13.4477 33.4663 14 33.4663H50C50.5523 33.4663 51 33.0186 51 32.4663C51 31.914 50.5523 31.4663 50 31.4663H14ZM13 40.4663C13 39.914 13.4477 39.4663 14 39.4663H16C16.5523 39.4663 17 39.914 17 40.4663C17 41.0186 16.5523 41.4663 16 41.4663H14C13.4477 41.4663 13 41.0186 13 40.4663ZM24 39.4663C23.4477 39.4663 23 39.914 23 40.4663C23 41.0186 23.4477 41.4663 24 41.4663H40C40.5523 41.4663 41 41.0186 41 40.4663C41 39.914 40.5523 39.4663 40 39.4663H24ZM47 40.4663C47 39.914 47.4477 39.4663 48 39.4663H50C50.5523 39.4663 51 39.914 51 40.4663C51 41.0186 50.5523 41.4663 50 41.4663H48C47.4477 41.4663 47 41.0186 47 40.4663Z"
                    fill="currentColor" />
                </svg>
              </div>
              <h5 class="mb-2">Well Documented</h5>
              <p class="features-icon-description">An easy-to-follow doc with lots of references and code examples.</p>
            </div>
          </div>
        </div>
      </section>
      <!-- Useful features: End -->

      <!-- Real customers reviews: Start -->
      <section id="landingReviews" class="section-py bg-body landing-reviews pb-0">
        <!-- What people say slider: Start -->
        <div class="container">
          <div class="row align-items-center gx-0 gy-4 g-lg-5 mb-5 pb-md-5">
            <div class="col-md-6 col-lg-5 col-xl-3">
              <div class="mb-4">
                <span class="badge bg-label-primary">Real Customers Reviews</span>
              </div>
              <h4 class="mb-1">
                <span class="position-relative fw-extrabold z-1"
                  >What people say
                  <img
                    src="<?= base_url('assets/img/front-pages/icons/section-title-icon.png') ?>"
                    alt="laptop charging"
                    class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
                </span>
              </h4>
              <p class="mb-5 mb-md-12">
                See what our customers have to<br class="d-none d-xl-block" />
                say about their experience.
              </p>
              <div class="landing-reviews-btns">
                <button id="reviews-previous-btn" class="btn btn-icon btn-label-primary reviews-btn me-3" type="button">
                  <i class="icon-base ti tabler-chevron-left icon-md scaleX-n1-rtl"></i>
                </button>
                <button id="reviews-next-btn" class="btn btn-icon btn-label-primary reviews-btn" type="button">
                  <i class="icon-base ti tabler-chevron-right icon-md scaleX-n1-rtl"></i>
                </button>
              </div>
            </div>
            <div class="col-md-6 col-lg-7 col-xl-9">
              <div class="swiper-reviews-carousel overflow-hidden">
                <div class="swiper" id="swiper-reviews">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-4">
                            <img
                              src="<?= base_url('assets/img/front-pages/branding/logo-1.png') ?>"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            “Vuexy is hands down the most useful front end Bootstrap theme I've ever used. I can't wait
                            to use it again for my next project.”
                          </p>
                          <div class="text-warning mb-4">
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-3 avatar-sm">
                              <img src="<?= base_url('assets/img/avatars/1.png') ?>" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Cecilia Payne</h6>
                              <p class="small text-body-secondary mb-0">CEO of Airbnb</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-4">
                            <img
                              src="<?= base_url('assets/img/front-pages/branding/logo-2.png') ?>"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            “I've never used a theme as versatile and flexible as Vuexy. It's my go to for building
                            dashboard sites on almost any project.”
                          </p>
                          <div class="text-warning mb-4">
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-3 avatar-sm">
                              <img src="<?= base_url('assets/img/avatars/2.png') ?>" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Eugenia Moore</h6>
                              <p class="small text-body-secondary mb-0">Founder of Hubspot</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-4">
                            <img
                              src="<?= base_url('assets/img/front-pages/branding/logo-3.png') ?>"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            This template is really clean & well documented. The docs are really easy to understand and
                            it's always easy to find a screenshot from their website.
                          </p>
                          <div class="text-warning mb-4">
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-3 avatar-sm">
                              <img src="<?= base_url('assets/img/avatars/3.png') ?>" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Curtis Fletcher</h6>
                              <p class="small text-body-secondary mb-0">Design Lead at Dribbble</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-4">
                            <img
                              src="<?= base_url('assets/img/front-pages/branding/logo-4.png') ?>"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            All the requirements for developers have been taken into consideration, so I’m able to build
                            any interface I want.
                          </p>
                          <div class="text-warning mb-4">
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-3 avatar-sm">
                              <img src="<?= base_url('assets/img/avatars/4.png') ?>" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Sara Smith</h6>
                              <p class="small text-body-secondary mb-0">Founder of Continental</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-4">
                            <img
                              src="<?= base_url('assets/img/front-pages/branding/logo-5.png') ?>"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            “I've never used a theme as versatile and flexible as Vuexy. It's my go to for building
                            dashboard sites on almost any project.”
                          </p>
                          <div class="text-warning mb-4">
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-3 avatar-sm">
                              <img src="<?= base_url('assets/img/avatars/5.png') ?>" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Eugenia Moore</h6>
                              <p class="small text-body-secondary mb-0">Founder of Hubspot</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-4">
                            <img
                              src="<?= base_url('assets/img/front-pages/branding/logo-6.png') ?>"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam nemo mollitia, ad eum
                            officia numquam nostrum repellendus consequuntur!
                          </p>
                          <div class="text-warning mb-4">
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                            <i class="icon-base ti tabler-star-filled"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-3 avatar-sm">
                              <img src="<?= base_url('assets/img/avatars/1.png') ?>" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Sara Smith</h6>
                              <p class="small text-body-secondary mb-0">Founder of Continental</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- What people say slider: End -->
        <hr class="m-0 mt-6 mt-md-12" />
        <!-- Logo slider: Start -->
        <div class="container">
          <div class="swiper-logo-carousel pt-8">
            <div class="swiper" id="swiper-clients-logos">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <img
                    src="<?= base_url('assets/img/front-pages/branding/logo_1-light.png') ?>"
                    alt="client logo"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/logo_1-light.png"
                    data-app-dark-img="front-pages/branding/logo_1-dark.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="<?= base_url('assets/img/front-pages/branding/logo_2-light.png') ?>"
                    alt="client logo"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/logo_2-light.png"
                    data-app-dark-img="front-pages/branding/logo_2-dark.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="<?= base_url('assets/img/front-pages/branding/logo_3-light.png') ?>"
                    alt="client logo"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/logo_3-light.png"
                    data-app-dark-img="front-pages/branding/logo_3-dark.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="<?= base_url('assets/img/front-pages/branding/logo_4-light.png') ?>"
                    alt="client logo"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/logo_4-light.png"
                    data-app-dark-img="front-pages/branding/logo_4-dark.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="<?= base_url('assets/img/front-pages/branding/logo_5-light.png') ?>"
                    alt="client logo"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/logo_5-light.png"
                    data-app-dark-img="front-pages/branding/logo_5-dark.png" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Logo slider: End -->
      </section>
      <!-- Real customers reviews: End -->

      <!-- Our great team: Start -->
      <section id="landingTeam" class="section-py landing-team">
        <div class="container">
          <div class="text-center mb-4">
            <span class="badge bg-label-primary">Our Great Team</span>
          </div>
          <h4 class="text-center mb-1">
            <span class="position-relative fw-extrabold z-1"
              >Didukung oleh
              <img
                src="<?= base_url('assets/img/front-pages/icons/section-title-icon.png') ?>"
                alt="laptop charging"
                class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
            Widyaiswara
          </h4>
          <p class="text-center mb-md-11 pb-0 pb-xl-12">Who is behind these great-looking interfaces?</p>
          <div class="row gy-12 mt-2">
            <div class="col-lg-3 col-sm-6">
              <div class="card mt-3 mt-lg-0 shadow-none">
                <div
                  class="bg-label-primary border border-bottom-0 border-label-primary position-relative team-image-box">
                  <img
                    src="<?= base_url('assets/img/front-pages/landing-page/team-member-1.png') ?>"
                    class="position-absolute card-img-position bottom-0 start-50"
                    alt="human image" />
                </div>
                <div class="card-body border border-top-0 border-label-primary text-center">
                  <h5 class="card-title mb-0">Sophie Gilbert</h5>
                  <p class="text-body-secondary mb-0">Project Manager</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="card mt-3 mt-lg-0 shadow-none">
                <div class="bg-label-info border border-bottom-0 border-label-info position-relative team-image-box">
                  <img
                    src="<?= base_url('assets/img/front-pages/landing-page/team-member-2.png') ?>"
                    class="position-absolute card-img-position bottom-0 start-50"
                    alt="human image" />
                </div>
                <div class="card-body border border-top-0 border-label-info text-center">
                  <h5 class="card-title mb-0">Paul Miles</h5>
                  <p class="text-body-secondary mb-0">UI Designer</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="card mt-3 mt-lg-0 shadow-none">
                <div
                  class="bg-label-danger border border-bottom-0 border-label-danger position-relative team-image-box">
                  <img
                    src="<?= base_url('assets/img/front-pages/landing-page/team-member-3.png') ?>"
                    class="position-absolute card-img-position bottom-0 start-50"
                    alt="human image" />
                </div>
                <div class="card-body border border-top-0 border-label-danger text-center">
                  <h5 class="card-title mb-0">Nannie Ford</h5>
                  <p class="text-body-secondary mb-0">Development Lead</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="card mt-3 mt-lg-0 shadow-none">
                <div
                  class="bg-label-success border border-bottom-0 border-label-success position-relative team-image-box">
                  <img
                    src="<?= base_url('assets/img/front-pages/landing-page/team-member-4.png') ?>"
                    class="position-absolute card-img-position bottom-0 start-50"
                    alt="human image" />
                </div>
                <div class="card-body border border-top-0 border-label-success text-center">
                  <h5 class="card-title mb-0">Chris Watkins</h5>
                  <p class="text-body-secondary mb-0">Marketing Manager</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Our great team: End -->

      <!-- Fun facts: Start -->
      <section id="landingFunFacts" class="section-py landing-fun-facts">
        <div class="container">
          <div class="row gy-6">
            <div class="col-sm-6 col-lg-3">
              <div class="card border border-primary shadow-none">
                <div class="card-body text-center">
                  <div class="mb-4 text-primary">
                    <svg width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        opacity="0.2"
                        d="M10 44.4663V18.4663C10 17.4054 10.4214 16.388 11.1716 15.6379C11.9217 14.8877 12.9391 14.4663 14 14.4663H50C51.0609 14.4663 52.0783 14.8877 52.8284 15.6379C53.5786 16.388 54 17.4054 54 18.4663V44.4663H10Z"
                        fill="currentColor" />
                      <path
                        d="M10 44.4663V18.4663C10 17.4054 10.4214 16.388 11.1716 15.6379C11.9217 14.8877 12.9391 14.4663 14 14.4663H50C51.0609 14.4663 52.0783 14.8877 52.8284 15.6379C53.5786 16.388 54 17.4054 54 18.4663V44.4663M36 22.4663H28M6 44.4663H58V48.4663C58 49.5272 57.5786 50.5446 56.8284 51.2947C56.0783 52.0449 55.0609 52.4663 54 52.4663H10C8.93913 52.4663 7.92172 52.0449 7.17157 51.2947C6.42143 50.5446 6 49.5272 6 48.4663V44.4663Z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                    </svg>
                  </div>
                  <h3 class="mb-0">7.1k+</h3>
                  <p class="fw-medium mb-0">
                    Support Tickets<br />
                    Resolved
                  </p>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card border border-success shadow-none">
                <div class="card-body text-center">
                  <div class="mb-4 text-success">
                    <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g id="User">
                        <path
                          id="Vector"
                          opacity="0.2"
                          d="M32.4999 8.52881C27.6437 8.52739 22.9012 9.99922 18.899 12.7499C14.8969 15.5005 11.8233 19.4006 10.0844 23.9348C8.34542 28.4691 8.02291 33.4242 9.15945 38.1456C10.296 42.867 12.8381 47.1326 16.4499 50.3788C17.9549 47.4151 20.2511 44.9261 23.0841 43.1875C25.917 41.4489 29.176 40.5287 32.4999 40.5288C30.5221 40.5288 28.5887 39.9423 26.9442 38.8435C25.2997 37.7447 24.018 36.1829 23.2611 34.3556C22.5043 32.5284 22.3062 30.5177 22.6921 28.5779C23.0779 26.6381 24.0303 24.8563 25.4289 23.4577C26.8274 22.0592 28.6092 21.1068 30.549 20.721C32.4888 20.3351 34.4995 20.5331 36.3268 21.29C38.154 22.0469 39.7158 23.3286 40.8146 24.9731C41.9135 26.6176 42.4999 28.551 42.4999 30.5288C42.4999 33.181 41.4464 35.7245 39.571 37.5999C37.6956 39.4752 35.1521 40.5288 32.4999 40.5288C35.8238 40.5287 39.0829 41.4489 41.9158 43.1875C44.7487 44.9261 47.045 47.4151 48.5499 50.3788C52.1618 47.1326 54.7039 42.867 55.8404 38.1456C56.977 33.4242 56.6545 28.4691 54.9155 23.9348C53.1766 19.4006 50.103 15.5005 46.1008 12.7499C42.0987 9.99922 37.3562 8.52739 32.4999 8.52881Z"
                          fill="currentColor" />
                        <path
                          id="Vector_2"
                          d="M32.5 40.5288C38.0228 40.5288 42.5 36.0517 42.5 30.5288C42.5 25.006 38.0228 20.5288 32.5 20.5288C26.9772 20.5288 22.5 25.006 22.5 30.5288C22.5 36.0517 26.9772 40.5288 32.5 40.5288ZM32.5 40.5288C29.1759 40.5288 25.9168 41.4477 23.0839 43.1866C20.2509 44.9255 17.9548 47.4149 16.45 50.3788M32.5 40.5288C35.8241 40.5288 39.0832 41.4477 41.9161 43.1866C44.7491 44.9255 47.0452 47.4149 48.55 50.3788M56.5 32.5288C56.5 45.7836 45.7548 56.5288 32.5 56.5288C19.2452 56.5288 8.5 45.7836 8.5 32.5288C8.5 19.274 19.2452 8.52881 32.5 8.52881C45.7548 8.52881 56.5 19.274 56.5 32.5288Z"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round" />
                      </g>
                    </svg>
                  </div>
                  <h3 class="mb-0">50k+</h3>
                  <p class="fw-medium mb-0">
                    Join creatives<br />
                    community
                  </p>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card border border-info shadow-none">
                <div class="card-body text-center">
                  <div class="mb-4 text-info">
                    <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        opacity="0.2"
                        d="M46.5001 10.5288H32.5001L20.2251 26.5288L32.5001 56.5288L60.5001 26.5288L46.5001 10.5288Z"
                        fill="currentColor" />
                      <path
                        d="M18.5 10.5288H46.5L60.5 26.5288L32.5 56.5288L4.5 26.5288L18.5 10.5288Z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M33.2934 9.92012C33.1042 9.67343 32.8109 9.52881 32.5 9.52881C32.1891 9.52881 31.8958 9.67343 31.7066 9.92012L19.7318 25.5288H4.5C3.94772 25.5288 3.5 25.9765 3.5 26.5288C3.5 27.0811 3.94772 27.5288 4.5 27.5288H19.5537L31.5745 56.9075C31.7282 57.2833 32.094 57.5288 32.5 57.5288C32.906 57.5288 33.2718 57.2833 33.4255 56.9075L45.4463 27.5288H60.5C61.0523 27.5288 61.5 27.0811 61.5 26.5288C61.5 25.9765 61.0523 25.5288 60.5 25.5288H45.2682L33.2934 9.92012ZM42.7474 25.5288L32.5 12.1717L22.2526 25.5288H42.7474ZM21.7146 27.5288L32.5 53.8881L43.2854 27.5288H21.7146Z"
                        fill="currentColor" />
                    </svg>
                  </div>
                  <h3 class="mb-0">4.8/5</h3>
                  <p class="fw-medium mb-0">
                    Highly Rated<br />
                    Products
                  </p>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card border border-warning shadow-none">
                <div class="card-body text-center">
                  <div class="mb-4 text-warning">
                    <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        opacity="0.2"
                        d="M14.125 50.9038C11.825 48.6038 13.35 43.7788 12.175 40.9538C11 38.1288 6.5 35.6538 6.5 32.5288C6.5 29.4038 10.95 27.0288 12.175 24.1038C13.4 21.1788 11.825 16.4538 14.125 14.1538C16.425 11.8538 21.25 13.3788 24.075 12.2038C26.9 11.0288 29.375 6.52881 32.5 6.52881C35.625 6.52881 38 10.9788 40.925 12.2038C43.85 13.4288 48.575 11.8538 50.875 14.1538C53.175 16.4538 51.65 21.2788 52.825 24.1038C54 26.9288 58.5 29.4038 58.5 32.5288C58.5 35.6538 54.05 38.0288 52.825 40.9538C51.6 43.8788 53.175 48.6038 50.875 50.9038C48.575 53.2038 43.75 51.6788 40.925 52.8538C38.1 54.0288 35.625 58.5288 32.5 58.5288C29.375 58.5288 27 54.0788 24.075 52.8538C21.15 51.6288 16.425 53.2038 14.125 50.9038Z"
                        fill="currentColor" />
                      <path
                        d="M43.5 26.5288L28.825 40.5288L21.5 33.5288M14.125 50.9038C11.825 48.6038 13.35 43.7788 12.175 40.9538C11 38.1288 6.5 35.6538 6.5 32.5288C6.5 29.4038 10.95 27.0288 12.175 24.1038C13.4 21.1788 11.825 16.4538 14.125 14.1538C16.425 11.8538 21.25 13.3788 24.075 12.2038C26.9 11.0288 29.375 6.52881 32.5 6.52881C35.625 6.52881 38 10.9788 40.925 12.2038C43.85 13.4288 48.575 11.8538 50.875 14.1538C53.175 16.4538 51.65 21.2788 52.825 24.1038C54 26.9288 58.5 29.4038 58.5 32.5288C58.5 35.6538 54.05 38.0288 52.825 40.9538C51.6 43.8788 53.175 48.6038 50.875 50.9038C48.575 53.2038 43.75 51.6788 40.925 52.8538C38.1 54.0288 35.625 58.5288 32.5 58.5288C29.375 58.5288 27 54.0788 24.075 52.8538C21.15 51.6288 16.425 53.2038 14.125 50.9038Z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                    </svg>
                  </div>
                  <h3 class="mb-0">100%</h3>
                  <p class="fw-medium mb-0">
                    Money Back<br />
                    Guarantee
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Fun facts: End -->

      <!-- FAQ: Start -->
      <section id="landingFAQ" class="section-py bg-body landing-faq">
        <div class="container">
          <div class="text-center mb-4">
            <span class="badge bg-label-primary">FAQ</span>
          </div>
          <h4 class="text-center mb-1">
            Frequently asked
            <span class="position-relative fw-extrabold z-1"
              >questions
              <img
                src="<?= base_url('assets/img/front-pages/icons/section-title-icon.png') ?>"
                alt="laptop charging"
                class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
          </h4>
          <p class="text-center mb-12 pb-md-4">
            Browse through these FAQs to find answers to commonly asked questions.
          </p>
          <div class="row gy-12 align-items-center">
            <div class="col-lg-5">
              <div class="text-center">
                <img
                  src="<?= base_url('assets/img/front-pages/landing-page/faq-boy-with-logos.png') ?>"
                  alt="faq boy with logos"
                  class="faq-image" />
              </div>
            </div>
            <div class="col-lg-7">
              <div class="accordion" id="accordionExample">
                <div class="card accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button
                      type="button"
                      class="accordion-button"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionOne"
                      aria-expanded="true"
                      aria-controls="accordionOne">
                      Do you charge for each upgrade?
                    </button>
                  </h2>

                  <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Lemon drops chocolate cake gummies carrot cake chupa chups muffin topping. Sesame snaps icing
                      marzipan gummi bears macaroon dragée danish caramels powder. Bear claw dragée pastry topping
                      soufflé. Wafer gummi bears marshmallow pastry pie.
                    </div>
                  </div>
                </div>
                <div class="card accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button
                      type="button"
                      class="accordion-button collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionTwo"
                      aria-expanded="false"
                      aria-controls="accordionTwo">
                      Do I need to purchase a license for each website?
                    </button>
                  </h2>
                  <div
                    id="accordionTwo"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée oat cake
                      dragée ice cream halvah tootsie roll. Danish cake oat cake pie macaroon tart donut gummies. Jelly
                      beans candy canes carrot cake. Fruitcake chocolate chupa chups.
                    </div>
                  </div>
                </div>
                <div class="card accordion-item active">
                  <h2 class="accordion-header" id="headingThree">
                    <button
                      type="button"
                      class="accordion-button"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionThree"
                      aria-expanded="false"
                      aria-controls="accordionThree">
                      What is regular license?
                    </button>
                  </h2>
                  <div
                    id="accordionThree"
                    class="accordion-collapse collapse show"
                    aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Regular license can be used for end products that do not charge users for access or service(access
                      is free and there will be no monthly subscription fee). Single regular license can be used for
                      single end product and end product can be used by you or your client. If you want to sell end
                      product to multiple clients then you will need to purchase separate license for each client. The
                      same rule applies if you want to use the same end product on multiple domains(unique setup). For
                      more info on regular license you can check official description.
                    </div>
                  </div>
                </div>
                <div class="card accordion-item">
                  <h2 class="accordion-header" id="headingFour">
                    <button
                      type="button"
                      class="accordion-button collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionFour"
                      aria-expanded="false"
                      aria-controls="accordionFour">
                      What is extended license?
                    </button>
                  </h2>
                  <div
                    id="accordionFour"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingFour"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis et aliquid quaerat possimus maxime!
                      Mollitia reprehenderit neque repellat deleniti delectus architecto dolorum maxime, blanditiis
                      earum ea, incidunt quam possimus cumque.
                    </div>
                  </div>
                </div>
                <div class="card accordion-item">
                  <h2 class="accordion-header" id="headingFive">
                    <button
                      type="button"
                      class="accordion-button collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionFive"
                      aria-expanded="false"
                      aria-controls="accordionFive">
                      Which license is applicable for SASS application?
                    </button>
                  </h2>
                  <div
                    id="accordionFive"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingFive"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi molestias exercitationem ab cum
                      nemo facere voluptates veritatis quia, eveniet veniam at et repudiandae mollitia ipsam quasi
                      labore enim architecto non!
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- FAQ: End -->

      <!-- CTA: Start -->
      <section id="landingCTA" class="section-py landing-cta position-relative p-lg-0 pb-0">
        <img
          src="<?= base_url('assets/img/front-pages/backgrounds/cta-bg-light.png') ?>"
          class="position-absolute bottom-0 end-0 scaleX-n1-rtl h-100 w-100 z-n1"
          alt="cta image"
          data-app-light-img="front-pages/backgrounds/cta-bg-light.png"
          data-app-dark-img="front-pages/backgrounds/cta-bg-dark.png" />
        <div class="container">
          <div class="row align-items-center gy-12">
            <div class="col-lg-6 text-start text-sm-center text-lg-start">
              <h3 class="cta-title text-primary fw-bold mb-1">Ready to Get Started?</h3>
              <h5 class="text-body mb-8">Start your project with a 14-day free trial</h5>
              <a href="payment-page.html" class="btn btn-lg btn-primary">Get Started</a>
            </div>
            <div class="col-lg-6 pt-lg-12 text-center text-lg-end">
              <img
                src="<?= base_url('assets/img/front-pages/landing-page/cta-dashboard.png') ?>"
                alt="cta dashboard"
                class="img-fluid mt-lg-4" />
            </div>
          </div>
        </div>
      </section>
      <!-- CTA: End -->

      <!-- Contact Us: Start -->
      <section id="landingContact" class="section-py bg-body landing-contact">
        <div class="container">
          <div class="text-center mb-4">
            <span class="badge bg-label-primary">Contact US</span>
          </div>
          <h4 class="text-center mb-1">
            <span class="position-relative fw-extrabold z-1"
              >Let's work
              <img
                src="<?= base_url('assets/img/front-pages/icons/section-title-icon.png') ?>"
                alt="laptop charging"
                class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
            together
          </h4>
          <p class="text-center mb-12 pb-md-4">Any question or remark? just write us a message</p>
          <div class="row g-6">
            <div class="col-lg-5">
              <div class="contact-img-box position-relative border p-2 h-100">
                <img
                  src="<?= base_url('assets/img/front-pages/icons/contact-border.png') ?>"
                  alt="contact border"
                  class="contact-border-img position-absolute d-none d-lg-block scaleX-n1-rtl" />
                <img
                  src="<?= base_url('assets/img/front-pages/landing-page/contact-customer-service.png') ?>"
                  alt="contact customer service"
                  class="contact-img w-100 scaleX-n1-rtl" />
                <div class="p-4 pb-2">
                  <div class="row g-4">
                    <div class="col-md-6 col-lg-12 col-xl-6">
                      <div class="d-flex align-items-center">
                        <div class="badge bg-label-primary rounded p-1_5 me-3">
                          <i class="icon-base ti tabler-mail icon-lg"></i>
                        </div>
                        <div>
                          <p class="mb-0">Email</p>
                          <h6 class="mb-0">
                            <a href="mailto:example@gmail.com" class="text-heading">example@gmail.com</a>
                          </h6>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                      <div class="d-flex align-items-center">
                        <div class="badge bg-label-success rounded p-1_5 me-3">
                          <i class="icon-base ti tabler-phone-call icon-lg"></i>
                        </div>
                        <div>
                          <p class="mb-0">Phone</p>
                          <h6 class="mb-0"><a href="tel:+1234-568-963" class="text-heading">+1234 568 963</a></h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="card h-100">
                <div class="card-body">
                  <h4 class="mb-2">Send a message</h4>
                  <p class="mb-6">
                    If you would like to discuss anything related to payment, account, licensing,<br
                      class="d-none d-lg-block" />
                    partnerships, or have pre-sales questions, you’re at the right place.
                  </p>
                  <form>
                    <div class="row g-4">
                      <div class="col-md-6">
                        <label class="form-label" for="contact-form-fullname">Full Name</label>
                        <input type="text" class="form-control" id="contact-form-fullname" placeholder="john" />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="contact-form-email">Email</label>
                        <input
                          type="text"
                          id="contact-form-email"
                          class="form-control"
                          placeholder="johndoe@gmail.com" />
                      </div>
                      <div class="col-12">
                        <label class="form-label" for="contact-form-message">Message</label>
                        <textarea
                          id="contact-form-message"
                          class="form-control"
                          rows="7"
                          placeholder="Write a message"></textarea>
                      </div>
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary">Send inquiry</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Contact Us: End -->
    </div>

    <!-- / Sections:End -->

    <!-- Footer: Start -->
    <footer class="landing-footer bg-body footer-text">
      <div class="footer-top position-relative overflow-hidden z-1">
        <img
          src="<?= base_url('assets/img/front-pages/backgrounds/footer-bg.png') ?>"
          alt="footer bg"
          class="footer-bg banner-bg-img z-n1" />
        <div class="container">
          <div class="row gx-0 gy-6 g-lg-10">
            <div class="col-lg-5">
              <a href="landing-page.html" class="app-brand-link mb-6">
                <span class="app-brand-logo demo">
                  <span class="text-primary">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="currentColor" />
                      <path
                        opacity="0.06"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                        fill="#161616" />
                      <path
                        opacity="0.06"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                        fill="#161616" />
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="currentColor" />
                    </svg>
                  </span>
                </span>
                <span class="app-brand-text demo footer-link fw-bold ms-2 ps-1">Vuexy</span>
              </a>
              <p class="footer-text footer-logo-description mb-6">
                Most developer friendly & highly customisable Admin Dashboard Template.
              </p>
              <form class="footer-form">
                <label for="footer-email" class="small">Subscribe to newsletter</label>
                <div class="d-flex mt-1">
                  <input
                    type="email"
                    class="form-control rounded-0 rounded-start-bottom rounded-start-top"
                    id="footer-email"
                    placeholder="Your email" />
                  <button
                    type="submit"
                    class="btn btn-primary shadow-none rounded-0 rounded-end-bottom rounded-end-top">
                    Subscribe
                  </button>
                </div>
              </form>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
              <h6 class="footer-title mb-6">Demos</h6>
              <ul class="list-unstyled">
                <li class="mb-4">
                  <a href="../vertical-menu-template/" target="_blank" class="footer-link">Vertical Layout</a>
                </li>
                <li class="mb-4">
                  <a href="../horizontal-menu-template/" target="_blank" class="footer-link">Horizontal Layout</a>
                </li>
                <li class="mb-4">
                  <a href="../vertical-menu-template-bordered/" target="_blank" class="footer-link">Bordered Layout</a>
                </li>
                <li class="mb-4">
                  <a href="../vertical-menu-template-semi-dark/" target="_blank" class="footer-link"
                    >Semi Dark Layout</a
                  >
                </li>
                <li class="mb-4">
                  <a href="../vertical-menu-template-dark/" target="_blank" class="footer-link">Dark Layout</a>
                </li>
              </ul>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
              <h6 class="footer-title mb-6">Pages</h6>
              <ul class="list-unstyled">
                <li class="mb-4">
                  <a href="pricing-page.html" class="footer-link">Pricing</a>
                </li>
                <li class="mb-4">
                  <a href="payment-page.html" class="footer-link"
                    >Payment<span class="badge bg-primary ms-2">New</span></a
                  >
                </li>
                <li class="mb-4">
                  <a href="checkout-page.html" class="footer-link">Checkout</a>
                </li>
                <li class="mb-4">
                  <a href="help-center-landing.html" class="footer-link">Help Center</a>
                </li>
                <li class="mb-4">
                  <a href="../vertical-menu-template/auth-login-cover.html" target="_blank" class="footer-link"
                    >Login/Register</a
                  >
                </li>
              </ul>
            </div>
            <div class="col-lg-3 col-md-4">
              <h6 class="footer-title mb-6">Download our app</h6>
              <a href="javascript:void(0);" class="d-block mb-4"
                ><img src="<?= base_url('assets/img/front-pages/landing-page/apple-icon.png') ?>" alt="apple icon"
              /></a>
              <a href="javascript:void(0);" class="d-block"
                ><img src="<?= base_url('assets/img/front-pages/landing-page/google-play-icon.png') ?>" alt="google play icon"
              /></a>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom py-3 py-md-5">
        <div
          class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
          <div class="mb-2 mb-md-0">
            <span class="footer-bottom-text"
              >©
              <script>
                document.write(new Date().getFullYear());
              </script>
            </span>
            <a href="https://pixinvent.com" target="_blank" class="fw-medium text-white">IT Murnajati</a>
            <span class="footer-bottom-text"> Made with ❤️ for a better web.</span>
          </div>
          <div>
            <a href="https://github.com/pixinvent" class="me-1 text-white" target="_blank">
              <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M10.7184 2.19556C6.12757 2.19556 2.40674 5.91639 2.40674 10.5072C2.40674 14.1789 4.78757 17.2947 8.0909 18.3947C8.50674 18.4697 8.65674 18.2139 8.65674 17.9939C8.65674 17.7964 8.65007 17.2731 8.64757 16.5806C6.33507 17.0822 5.84674 15.4656 5.84674 15.4656C5.47007 14.5056 4.92424 14.2497 4.92424 14.2497C4.17007 13.7339 4.98174 13.7456 4.98174 13.7456C5.81674 13.8039 6.25424 14.6022 6.25424 14.6022C6.9959 15.8722 8.2009 15.5056 8.67257 15.2931C8.7484 14.7556 8.96507 14.3889 9.20174 14.1814C7.35674 13.9722 5.41674 13.2589 5.41674 10.0731C5.41674 9.16722 5.74091 8.42389 6.27007 7.84389C6.1859 7.63306 5.89841 6.78722 6.35257 5.64389C6.35257 5.64389 7.05007 5.41972 8.63757 6.49472C9.31557 6.31028 10.0149 6.21614 10.7176 6.21472C11.4202 6.21586 12.1196 6.31001 12.7976 6.49472C14.3859 5.41889 15.0826 5.64389 15.0826 5.64389C15.5367 6.78722 15.2517 7.63306 15.1651 7.84389C15.6984 8.42389 16.0184 9.16639 16.0184 10.0731C16.0184 13.2672 14.0767 13.9689 12.2251 14.1747C12.5209 14.4314 12.7876 14.9381 12.7876 15.7131C12.7876 16.8247 12.7776 17.7214 12.7776 17.9939C12.7776 18.2164 12.9259 18.4747 13.3501 18.3931C16.6517 17.2914 19.0301 14.1781 19.0301 10.5072C19.0301 5.91639 15.3092 2.19556 10.7184 2.19556Z"
                  fill="currentColor" />
              </svg>
            </a>
            <a href="https://www.facebook.com/pixinvents/" class="me-1 text-white" target="_blank">
              <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M11.8609 18.0262V11.1962H14.1651L14.5076 8.52204H11.8609V6.81871C11.8609 6.04704 12.0759 5.51871 13.1834 5.51871H14.5868V3.13454C13.904 3.06136 13.2176 3.02603 12.5309 3.02871C10.4943 3.02871 9.09593 4.27204 9.09593 6.55454V8.51704H6.80676V11.1912H9.10093V18.0262H11.8609Z"
                  fill="currentColor" />
              </svg>
            </a>
            <a href="https://x.com/pixinvents" class="me-1 text-white" target="_blank">
              <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M17.0576 7.19293C17.0684 7.33876 17.0684 7.48376 17.0684 7.62876C17.0684 12.0663 13.6909 17.1796 7.5184 17.1796C5.61674 17.1796 3.85007 16.6288 2.3634 15.6721C2.6334 15.7029 2.8934 15.7138 3.17424 15.7138C4.68506 15.7174 6.15311 15.2122 7.34174 14.2796C6.64125 14.2669 5.96222 14.0358 5.39943 13.6185C4.83665 13.2013 4.41822 12.6187 4.20257 11.9521C4.41007 11.9829 4.6184 12.0038 4.83674 12.0038C5.13757 12.0038 5.44007 11.9621 5.7209 11.8896C4.9607 11.7361 4.27713 11.3241 3.78642 10.7235C3.29571 10.1229 3.02815 9.37097 3.02924 8.59543V8.55376C3.47674 8.80293 3.9959 8.95876 4.5459 8.9796C4.08514 8.67342 3.70734 8.25795 3.44619 7.77026C3.18504 7.28256 3.04866 6.73781 3.04924 6.1846C3.04924 5.56126 3.21507 4.9896 3.5059 4.49126C4.34935 5.52878 5.40132 6.37756 6.59368 6.98265C7.78604 7.58773 9.0922 7.93561 10.4276 8.00376C10.3759 7.75376 10.3442 7.4946 10.3442 7.2346C10.344 6.79373 10.4307 6.35715 10.5993 5.9498C10.7679 5.54245 11.0152 5.17233 11.3269 4.86059C11.6386 4.54885 12.0088 4.30161 12.4161 4.133C12.8235 3.96438 13.26 3.87771 13.7009 3.87793C14.6676 3.87793 15.5401 4.28293 16.1534 4.93793C16.9049 4.79261 17.6255 4.51828 18.2834 4.1271C18.0329 4.90278 17.5082 5.56052 16.8076 5.9771C17.4741 5.90108 18.1254 5.72581 18.7401 5.4571C18.281 6.12635 17.7122 6.71322 17.0576 7.19293Z"
                  fill="currentColor" />
              </svg>
            </a>
            <a href="https://www.instagram.com/pixinvents/" class="text-white" target="_blank">
              <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1833_185630)">
                  <path
                    d="M17.5869 6.33973C17.5774 5.62706 17.444 4.9215 17.1926 4.25456C16.9747 3.69202 16.6418 3.18112 16.2152 2.75453C15.7886 2.32793 15.2776 1.995 14.7151 1.77703C14.0568 1.5299 13.3613 1.39627 12.6582 1.38183C11.753 1.34137 11.466 1.33008 9.16819 1.33008C6.87039 1.33008 6.57586 1.33008 5.67725 1.38183C4.97451 1.39637 4.27932 1.53 3.62127 1.77703C3.05863 1.99485 2.54765 2.32772 2.12103 2.75434C1.69442 3.18096 1.36155 3.69193 1.14373 4.25456C0.896101 4.91242 0.76276 5.60776 0.749471 6.31056C0.70901 7.2167 0.696777 7.50368 0.696777 9.8015C0.696777 12.0993 0.696777 12.3928 0.749471 13.2924C0.763585 13.9963 0.89626 14.6907 1.14373 15.3503C1.36192 15.9128 1.69503 16.4236 2.1218 16.85C2.54855 17.2765 3.05957 17.6091 3.6222 17.8269C4.27846 18.084 4.97377 18.2272 5.67819 18.2504C6.58433 18.2908 6.87133 18.303 9.16913 18.303C11.4669 18.303 11.7615 18.303 12.6601 18.2504C13.3632 18.2365 14.0587 18.1032 14.717 17.8561C15.2794 17.6378 15.7902 17.3048 16.2167 16.8782C16.6433 16.4517 16.9763 15.941 17.1945 15.3785C17.442 14.7198 17.5746 14.0254 17.5888 13.3207C17.6293 12.4155 17.6414 12.1285 17.6414 9.82973C17.6396 7.53191 17.6396 7.24021 17.5869 6.33973ZM9.16255 14.1468C6.75935 14.1468 4.81251 12.2 4.81251 9.79679C4.81251 7.39359 6.75935 5.44676 9.16255 5.44676C10.3163 5.44676 11.4227 5.90506 12.2385 6.72085C13.0543 7.53664 13.5126 8.64309 13.5126 9.79679C13.5126 10.9505 13.0543 12.057 12.2385 12.8727C11.4227 13.6885 10.3163 14.1468 9.16255 14.1468ZM13.6857 6.3002C13.5525 6.30033 13.4206 6.27417 13.2974 6.22325C13.1743 6.17231 13.0624 6.09759 12.9682 6.00338C12.874 5.90917 12.7992 5.79729 12.7483 5.67417C12.6974 5.55105 12.6712 5.41909 12.6713 5.28585C12.6713 5.15271 12.6976 5.02087 12.7485 4.89786C12.7994 4.77485 12.8742 4.66308 12.9683 4.56893C13.0625 4.47479 13.1743 4.4001 13.2973 4.34915C13.4202 4.2982 13.5521 4.27197 13.6853 4.27197C13.8184 4.27197 13.9503 4.2982 14.0732 4.34915C14.1962 4.4001 14.3081 4.47479 14.4022 4.56893C14.4963 4.66308 14.571 4.77485 14.622 4.89786C14.6729 5.02087 14.6991 5.15271 14.6991 5.28585C14.6991 5.84666 14.2456 6.3002 13.6857 6.3002Z"
                    fill="currentColor" />
                  <path
                    d="M9.16296 12.6226C10.7236 12.6226 11.9887 11.3575 11.9887 9.79688C11.9887 8.23629 10.7236 6.97119 9.16296 6.97119C7.60238 6.97119 6.33728 8.23629 6.33728 9.79688C6.33728 11.3575 7.60238 12.6226 9.16296 12.6226Z"
                    fill="currentColor" />
                </g>
                <defs>
                  <clipPath id="clip0_1833_185630">
                    <rect width="16.9412" height="18" fill="currentColor" transform="translate(0.696777 0.528809)" />
                  </clipPath>
                </defs>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </footer>
    <!-- Footer: End -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js -->

    <script src="<?= base_url('assets/vendor/libs/popper/popper.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/node-waves/node-waves.js') ?>"></script>

    <script src="<?= base_url('assets/vendor/libs/@algolia/autocomplete-js.js') ?>"></script>

    <script src="<?= base_url('assets/vendor/libs/pickr/pickr.js') ?>"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?= base_url('assets/vendor/libs/nouislider/nouislider.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/swiper/swiper.js') ?>"></script>

    <!-- Main JS -->

    <script src="<?= base_url('assets/js/front-main.js') ?>"></script>

    <!-- Page JS -->
    <script src="<?= base_url('assets/js/front-page-landing.js') ?>"></script>
  </body>
</html>
