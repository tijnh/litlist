  <!-- Book list -->
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
                <a href="#"><img src="<?= esc($book["imageLink"]) ?>" alt="Book cover"></a>
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
                <div class="ll-card-details mb-1 text-secondary"><i class="bi bi-star"></i> <?= esc($book["readingLevel"]) ?></div>
                <div class="ll-card-details mb-1 text-secondary"><span style="color:red"><i class="bi bi-headphones"></i> ?</span></div>
              </div>

            </div>
          </div>
        </div>

      <?php endforeach ?>
    </div>

  </div>

  