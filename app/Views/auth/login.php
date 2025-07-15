<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Studio | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- ================== BEGIN core-css ================== -->
    <link href="assets/css/vendor.min.css" rel="stylesheet">
    <link href="assets/css/app.min.css" rel="stylesheet">
    <link href="assets/css/sweetalert2.css" rel="stylesheet">
    <!-- ================== END core-css ================== -->

</head>

<body>
    <!-- BEGIN #app -->
    <div id="app" class="app app-full-height app-without-header">
        <!-- BEGIN login -->
        <div class="login">
            <!-- BEGIN login-content -->
            <div class="login-content">
                <form action="./login" method="POST" name="login_form">
                    <h1 class="text-center">UPT Pelatihan Kesehatan Masyarakat <strong>Murnajati</strong></h1>
                    <div class="text-muted text-center mb-4">
                        Kawah Candradimuka Insan Kesehatan Indonesia
                    </div>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Alamat E-mail</label>
                        <input type="text" name="email" class="form-control form-control-lg fs-15px" value="" placeholder="username@address.com">
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <label class="form-label">Password</label>
                            <a href="#" class="ms-auto text-muted">Forgot password?</a>
                        </div>
                        <input type="password" name="password" class="form-control form-control-lg fs-15px" value="" placeholder="Enter your password">
                    </div>
                    <button type="submit" class="btn btn-theme btn-lg d-block w-100 fw-500 mb-3">Sign In</button>
                </form>
            </div>
            <!-- END login-content -->
        </div>
        <!-- END login -->

        <!-- BEGIN btn-scroll-top -->
        <a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
        <!-- END btn-scroll-top -->

    </div>
    <!-- END #app -->

    <!-- ================== BEGIN core-js ================== -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/sweetalert2.all.js"></script>
    <!-- ================== END core-js ================== -->
    <!-- <script>
        Swal.fire({
            title: 'Error!',
            text: 'Do you want to continue',
            icon: 'error',
            confirmButtonText: 'Cool'
        });
    </script> -->

</body>

</html>