<?php require "common/header.view.php"; ?>

<!-- Search form -->
<form method="post" class="w-100">
  <div class="container-fluid p-3 search-container d-flex justify-content-center">

    <!-- searchterm input -->
    <input class="searchfield w-100 px-4 form-control mr-sm-2 border-0" name="searchterm" type="search" placeholder="Zoek op titel of auteur" <?= isset($userFilters["searchterm"]) ? "value='" . esc($userFilters["searchterm"]) . "'" : ""; ?> autocomplete="off">

  </div>

  <!-- Filter Menu -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="filterMenu" aria-labelledby="filterMenu">

    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="filterMenu">Zoek met filters</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
      <div class="accordion" id="accordionPanelsStayOpenExample">

        <!-- Year filter -->
        <div class="accordion-item border-0">
          <h2 class="accordion-header border-bottom">
            <button class="accordion-button bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
              <i class="bi bi-calendar filter-icon"></i> Jaar van verschijnen
            </button>
          </h2>
          <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
            <div class="accordion-body">

              <div class="row g-1">
                <div class="col-3">
                  <!-- min_year input -->
                  <input name="min_year" type="number" class="form-control" <?= isset($userFilters["min_year"]) ? "value='" . esc($userFilters["min_year"]) . "'" : ""; ?> min="0" placeholder="van">
                </div>
                <div class="col-3">
                  <!-- max_year input -->
                  <input name="max_year" type="number" class="form-control" <?= isset($userFilters["max_year"]) ? "value='" . esc($userFilters["max_year"]) . "'" : ""; ?> min="0" placeholder="tot">
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Pages filter -->
        <div class="accordion-item border-0">
          <h2 class="accordion-header border-bottom">
            <button class="accordion-button bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
              <i class="bi bi-book filter-icon"></i> Aantal pagina's
            </button>
          </h2>
          <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
            <div class="accordion-body">

              <div class="row g-1">
                <div class="col-3">
                  <!-- min_pages input -->
                  <input name="min_pages" type="number" class="form-control" <?= isset($userFilters["min_pages"]) ? "value='" . esc($userFilters["min_pages"]) . "'" : ""; ?> placeholder="van" min="0" size="4">
                </div>
                <div class="col-3">
                  <!-- max_pages input -->
                  <input name="max_pages" type="number" class="form-control" <?= isset($userFilters["max_pages"]) ? "value='" . esc($userFilters["max_pages"]) . "'" : ""; ?> placeholder="tot" min="0" size="4">
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Reading Level filter -->
        <div class="accordion-item border-0">
          <h2 class="accordion-header border-bottom">
            <button class="accordion-button bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
              <i class="bi bi-star filter-icon"></i> Niveau
            </button>
          </h2>
          <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
            <div class="accordion-body">

              <!-- Checkboxes -->
              <?php foreach ($filterMenu["reading_level"] as $level) : ?>

                <div class="form-check">
                  <input type="checkbox" name="reading_level[]" id="checkboxReadingLevel<?= esc($level) ?>" class="form-check-input reading-level-checkbox" value="<?= esc($level) ?>" <?php if (isset($userFilters["reading_level"]) AND in_array($level, $userFilters["reading_level"])) : ?> checked <?php endif ?>>
                  <label class="form-check-label" for="checkboxReadingLevel<?= esc($level) ?>">
                    <?= esc($level) ?>
                  </label>
                </div>

              <?php endforeach ?>

            </div>
          </div>
        </div>

        <!-- Audiobook filter -->
        <div class="accordion-item border-0">
          <h2 class="accordion-header border-bottom">
            <button class="accordion-button bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
              <i class="bi bi-headphones filter-icon"></i> Audioboek
            </button>
          </h2>
          <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
            <div class="accordion-body">

              <!-- Checkboxes -->
              <div class="form-check">
                <input type="checkbox" name="audiobook[]" id="checkboxAudiobookYes" class="form-check-input audiobook-checkbox" value="yes" disabled>
                <label class="form-check-label" for="checkboxAudiobookYes">Ja</label>
              </div>
              <div class="form-check">
                <input type="checkbox" name="audiobook[]" id="checkboxAudiobookNo" class="form-check-input audiobook-checkbox" value="no" disabled>
                <label class="form-check-label" for="checkboxAudiobookNo">Nee</label>
              </div>

            </div>
          </div>
        </div>

      </div> <!-- end of accordion -->


      <!-- Submit button -->
      <div class="row py-4">
        <div class="col-12 text-center">
          <button type="submit" class="ll-btn ll-btn-primary w-100">Zoeken</button>
        </div>
      </div>

    </div>

  </div>
</form>



<!-- Book results -->
<div class="container-lg">

  <!-- Filter button -->
  <div class="row justify-content-center p-3 ">
    <div class="col-12">
      <button type="button" id="filter-button" class="ll-btn ll-btn-primary w-100" data-bs-toggle="offcanvas" data-bs-target="#filterMenu" aria-controls="filterMenu">Filter <?= count($books) ?> boeken</button>
    </div>
  </div>

  <!-- Cards -->
  <div class="row row-cols-1 row-cols-md-2">

    <?php foreach ($books as $book) : ?>
      <!-- Card -->
      <div class="col-12">
        <div class="ll-card h-100 mx-auto px-2 pt-3 pb-2 border-top">
          <div class="row g-0">

            <!-- Left -->
            <div class="col-2 ll-card-img">
              <a href="#"><img src="<?= esc($book["image_link"]) ?>" alt="Book cover"></a>
            </div>

            <!-- Middle-->
            <div class="col-8 ll-card-middle">
              <a href="#" class="ll-card-title"><?= esc($book["title"]) ?></a>
              <p class="ll-card-details text-secondary mb-2"><?= esc(implode(", ", $book["authors"])) ?></p>
              <p class="ll-card-blurb m-0 mb-3"><?= esc($book["blurb"]) ?></p>
              <p class="ll-card-details text-secondary"><i><?= !empty($book["themes"]) ? esc(implode(", ", $book["themes"])) : "" ?></i></p>
            </div>

            <!-- Right -->
            <div class="col-2">
              <div class="ll-card-details mb-1 text-secondary"><i class="bi bi-calendar"></i> <?= esc($book["year"]) ?></div>
              <div class="ll-card-details mb-1 text-secondary"><i class="bi bi-book"></i> <?= esc($book["pages"]) ?></div>
              <div class="ll-card-details mb-1 text-secondary"><i class="bi bi-star"></i> <?= esc($book["reading_level"]) ?></div>
              <div class="ll-card-details mb-1 text-secondary"><i class="bi bi-headphones"></i> ?</div>
            </div>

          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>

</div>

<script src="<?=ROOT?>/assets/js/filters.js"></script>

<?php

require "common/footer.view.php";

?>