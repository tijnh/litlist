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
            <button class="accordion-button bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#year-filter-accordion" aria-expanded="false" aria-controls="year-filter-accordion">
              <i class="bi bi-calendar filter-icon"></i> Jaar van verschijnen
            </button>
          </h2>
          <div id="year-filter-accordion" class="accordion-collapse collapse">
            <div class="accordion-body">

              <div class="row g-1">
                <div class="col-3">
                  <!-- minYear input -->
                  <input name="minYear" type="number" class="form-control" <?= isset($userFilters["minYear"]) ? "value='" . esc($userFilters["minYear"]) . "'" : ""; ?> min="0" placeholder="van">
                </div>
                <div class="col-3">
                  <!-- maxYear input -->
                  <input name="maxYear" type="number" class="form-control" <?= isset($userFilters["maxYear"]) ? "value='" . esc($userFilters["maxYear"]) . "'" : ""; ?> min="0" placeholder="tot">
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Pages filter -->
        <div class="accordion-item border-0">
          <h2 class="accordion-header border-bottom">
            <button class="accordion-button bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pages-filter-accordion" aria-expanded="false" aria-controls="pages-filter-accordion">
              <i class="bi bi-book filter-icon"></i> Aantal pagina's
            </button>
          </h2>
          <div id="pages-filter-accordion" class="accordion-collapse collapse">
            <div class="accordion-body">

              <div class="row g-1">
                <div class="col-3">
                  <!-- minPages input -->
                  <input name="minPages" type="number" class="form-control" <?= isset($userFilters["minPages"]) ? "value='" . esc($userFilters["minPages"]) . "'" : ""; ?> placeholder="van" min="0" size="4">
                </div>
                <div class="col-3">
                  <!-- maxPages input -->
                  <input name="maxPages" type="number" class="form-control" <?= isset($userFilters["maxPages"]) ? "value='" . esc($userFilters["maxPages"]) . "'" : ""; ?> placeholder="tot" min="0" size="4">
                </div>
              </div>

            </div>
          </div>
        </div>

        <?php if (!empty($filterMenu["readingLevels"])) : ?>
          <!-- Reading Level filter -->
          <div class="accordion-item border-0">
            <h2 class="accordion-header border-bottom">
              <button class="accordion-button bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#reading-level-filter-accordion" aria-expanded="false" aria-controls="reading-level-filter-accordion">
                <i class="bi bi-star filter-icon"></i> Niveau
              </button>
            </h2>
            <div id="reading-level-filter-accordion" class="accordion-collapse collapse">
              <div class="accordion-body">

                <!-- Checkboxes -->
                <?php foreach ($filterMenu["readingLevels"] as $level) : ?>
                  <div class="form-check">
                    <input type="checkbox" name="readingLevels[]" id="checkboxReadingLevel<?= esc($level) ?>" class="form-check-input reading-level-checkbox" value="<?= esc($level) ?>" <?php if (isset($userFilters["readingLevels"]) and in_array($level, $userFilters["readingLevels"])) : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="checkboxReadingLevel<?= esc($level) ?>"><?= esc($level) ?></label>
                  </div>
                <?php endforeach ?>

              </div>
            </div>
          </div>
        <?php endif ?>

        <?php if (!empty($filterMenu["audiobookSources"])) : ?>
          <!-- Audiobook filter -->
          <div class="accordion-item border-0">
            <h2 class="accordion-header border-bottom">
              <button class="accordion-button bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#audiobook-filter-accordion" aria-expanded="false" aria-controls="audiobook-filter-accordion">
                <i class="bi bi-headphones filter-icon"></i> Audioboek
              </button>
            </h2>
            <div id="audiobook-filter-accordion" class="accordion-collapse collapse">
              <div class="accordion-body">

                <!-- Checkboxes -->
                <?php foreach ($filterMenu["audiobookSources"] as $source) : ?>
                  <div class="form-check">
                    <input type="checkbox" name="audiobookSources[]" id="checkboxAudiobook<?= esc($source) ?>" class="form-check-input audiobook-checkbox" value="<?= esc($source) ?>" <?php if (isset($userFilters["audiobookSources"]) and in_array($source, $userFilters["audiobookSources"])) : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="checkboxAudiobook<?= esc($source) ?>"><?= esc($source) ?></label>
                  </div>
                <?php endforeach ?>

              </div>
            </div>
          </div>
        <?php endif ?>

        <?php if (!empty($filterMenu["themes"])) : ?>
          <!-- Audiobook filter -->
          <div class="accordion-item border-0">
            <h2 class="accordion-header border-bottom">
              <button class="accordion-button bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#themes-filter-accordion" aria-expanded="false" aria-controls="themes-filter-accordion">
                <i class="bi bi-chat-left-text filter-icon"></i> Thema
              </button>
            </h2>
            <div id="themes-filter-accordion" class="accordion-collapse collapse">
              <div class="accordion-body">

                <!-- Checkboxes -->
                <?php foreach ($filterMenu["themes"] as $theme) : ?>
                  <div class="form-check">
                    <input type="checkbox" name="themes[]" id="checkboxTheme<?= esc($theme) ?>" class="form-check-input theme-checkbox" value="<?= esc($theme) ?>" <?php if (isset($userFilters["themes"]) and in_array($theme, $userFilters["themes"])) : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="checkboxTheme<?= esc($theme) ?>"><?= esc($theme) ?></label>
                  </div>
                <?php endforeach ?>

              </div>
            </div>
          </div>
        <?php endif ?>

      </div> <!-- end of accordion -->

      <!-- Submit button -->
      <div class="row py-4">
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary w-100">Zoeken</button>
        </div>
      </div>

    </div>

  </div>
</form>




<!-- Book list -->
<div class="container-fluid">

  <div class="row justify-content-center py-3 ">
    <!-- Filter button -->
    <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
      <button type="button" id="filter-button" class="btn btn-primary w-100" data-bs-toggle="offcanvas" data-bs-target="#filterMenu" aria-controls="filterMenu">Filter <?= count($books) ?> boeken</button>
    </div>
    <!-- Reset filter button -->
    <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
      <a href="<?= ROOT ?>/browse">
        <button type="button" class="btn btn-outline-tertiary w-100"> Reset filters</button>
      </a>
    </div>
  </div>

  <!-- Cards -->
  <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">

    <?php foreach ($books as $book) : ?>
      <!-- Card -->
      <div class="col-12">
        <div class="ll-card h-100 mx-auto pt-3 pb-2 border-top">
          <div class="row g-0">

            <!-- Left -->
            <div class="col-2 ll-card-img">
              <a href="#"><img src="<?= esc($book["imageLink"]) ?>" alt="Book cover"></a>
            </div>

            <!-- Middle-->
            <div class="col-8 ll-card-middle">
              <a href="#" class="ll-card-title"><?= esc($book["title"]) ?></a>
              <p class="ll-card-details text-grey-2 mb-2"><?= esc(implode(", ", $book["authors"])) ?></p>
              <p class="ll-card-blurb m-0 mb-3"><?= esc($book["blurb"]) ?></p>
              <p class="ll-card-details text-grey-2"><i><?= !empty($book["themes"]) ? esc(implode(", ", $book["themes"])) : "" ?></i></p>
            </div>

            <!-- Right -->
            <div class="col-2">
              <div class="ll-card-details mb-1 text-grey-2"><i class="bi bi-calendar"></i> <?= esc($book["year"]) ?></div>
              <div class="ll-card-details mb-1 text-grey-2"><i class="bi bi-book"></i> <?= esc($book["pages"]) ?></div>
              <div class="ll-card-details mb-1 text-grey-2"><i class="bi bi-star"></i> <?= esc($book["readingLevel"]) ?></div>
              <?php if (!empty($book["audiobook"])) : ?>
                <div class="ll-card-details mb-1 text-grey-2"><i class="bi bi-headphones"></i> <?= esc($book["audiobook"]) ?></div>
              <?php endif ?>
            </div>

          </div>
        </div>
      </div>

    <?php endforeach ?>
  </div>

</div>




<script src="<?= ROOT ?>/assets/js/filters.js"></script>

<?php require "common/footer.view.php" ?>