  <!-- Navbar -->
  <nav class="navbar navbar-expand-sm navbar-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= ROOT ?>">
        <img src="<?= LOGO ?>" alt="Logo" height="24" class="d-inline-block align-text-top">
        LitList
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <div class="offcanvas-title" id="offcanvasNavbarLabel">
            <a class="navbar-brand" href="<?= ROOT ?>">
              <img src="<?= LOGO ?>" alt="Logo" height="24" class="d-inline-block align-text-top">
              LitList
            </a>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link" href="<?= ROOT ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= ROOT ?>/browse">Zoek een boek</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  