

    <!-- Header -->
    <?= view('layout/header') ?>
    <!-- /Header -->
   
    <!-- Side Menu -->
    <?= view('layout/side_menu') ?>
    <!-- / Side Menu -->

    <!-- Top Menu -->
    <?= view('layout/top_menu') ?>
    <!-- / Top Menu -->

    <!-- Content -->
    <?= $this->renderSection('content'); ?>
    <!-- / Content -->

    <!-- Footer -->
    <?= view('layout/footer') ?>
    <!-- / Footer -->


    
</body>

</html>
