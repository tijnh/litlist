<?php require "common/header.view.php"; ?>
<div class="home-container">
  <div class="container shadow col-xxl-8 px-5 py-5 bg-white rounded-3">
    <div class="row flex-lg-row-reverse align-items-center justify-content-center g-5 py-5">
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="<?= ROOT ?>/assets/img/boekendokters.jpg" class="d-block img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold lh-1 mb-3">Welkom bij Litlist!</h1>
        <p class="lead">Het Segbroek College presenteert: LitList! Op deze site vind je alle boeken van de literatuurlijst van het Segbroek. Gebruik de zoekfilters om het boek te vinden dat bij jou past.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
          <a href="<?= ROOT ?>/browse" class="btn btn-primary btn-lg px-4 me-md-2">Zoek een boek</a>
          <button type="button" class="btn btn-outline-secondary btn-lg px-4" disabled>Login</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "common/footer.view.php"; ?>