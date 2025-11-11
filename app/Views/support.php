<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
.faq-header .input-wrapper {
  position: relative;
  inline-size: 100%;
  max-inline-size: 55%;
}
.faq-header .input-wrapper .input-group-text,
.faq-header .input-wrapper .form-control {
  background-color: var(--bs-paper-bg);
}
@media (max-width: 575.98px) {
  .faq-header .input-wrapper {
    max-inline-size: 70%;
  }
}

.faq-banner-img {
  position: absolute;
  block-size: 100%;
  inline-size: 100%;
  inset-block-start: 0;
  inset-inline-start: 0;
  object-fit: cover;
  object-position: left;
}

.bg-faq-section {
  background-color: rgba(var(--bs-base-color-rgb), 0.06);
}
</style>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Manual Book -->
    <div class="row g-6">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-6 gap-2">
              <div class="me-1">
                <h5 class="mb-0">Petunjuk Teknis</h5>
                <p class="mb-0">Oleh: <span class="fw-medium text-heading"> Tim Pengembang Website TNA </span></p>
              </div>
              <div class="d-flex align-items-center">
                <span class="badge bg-label-danger">Diperbarui: 2025/11/11</span>
              </div>
            </div>
            <div class="card academy-content shadow-none border">
              <div class="p-2">
                <div class="row justify-content-center gap-md-0 gap-6">
                  <object data="https://drive.google.com/file/d/1Xul0LrRwqNUgBjZlVuSbypecYX_ZPV51/preview"
                    type="application/pdf" width="600" height="600"></object>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / Manual Book -->

    <!-- Contact -->
    <div class="row my-6">
      <div class="col-12 text-center my-6">
        <div class="badge bg-label-primary">Bingung?</div>
        <h4 class="my-2">Ada pertanyaan atau kendala?</h4>
        <p class="mb-0">
          Jika Anda mengalami kendala teknis atau memiliki pertanyaan terkait penggunaan Website TNA, jangan ragu untuk menghubungi tim pengelola kami!
        </p>
      </div>
    </div>
    <div class="row justify-content-center gap-md-0 gap-6">
      <div class="col-md-4">
        <div class="py-6 rounded bg-faq-section text-center">
          <span class="badge bg-label-primary p-2">
            <i class="icon-base ti tabler-phone icon-26px mx-50 mt-50"></i>
          </span>
          <h5 class="mt-4 mb-1"><a class="text-heading" href="tel:+62341426015">(0341) 426015</a></h5>
          <p class="mb-0">Kami siap membantu dengan senang hati!</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="py-6 rounded bg-faq-section text-center">
          <span class="badge bg-label-primary p-2">
            <i class="fab fa-whatsapp icon-26px mx-50 mt-50"></i>
          </span>
          <h5 class="mt-4 mb-1"><a class="text-heading" href="https://wa.me/+6285385257407" target="_blank">+62 853-8525-7407</a></h5>
          <p class="mb-0">Hubungi kami untuk mendapatkan jawaban dengan cepat!</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="py-6 rounded bg-faq-section text-center">
          <span class="badge bg-label-primary p-2">
            <i class="icon-base ti tabler-mail icon-26px mx-50 mt-50"></i>
          </span>
          <h5 class="mt-4 mb-1">
            <a class="text-heading" href="mailto:latkesmas-murnajati@jatimprov.go.id">latkesmas-murnajati@jatimprov.go.id</a>
          </h5>
          <p class="mb-0">Kami siap memberikan jawaban terbaik untuk Anda!</p>
        </div>
      </div>
    </div>
    <!-- / Contact -->
  </div>
</div>
<?= $this->endSection() ?>