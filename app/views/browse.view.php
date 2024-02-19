<?php

require "common/header.view.php";
require "common/navbar.view.php";

?>

<!-- Search form -->
<form action="search.php" method="post" class="w-100">
  <div class="container-fluid p-3 search-container d-flex justify-content-center">

    <!-- q input -->
    <input class="searchfield w-100 px-4 form-control mr-sm-2 border-0" name="q" type="search" placeholder="Zoek op titel of auteur" <?php echo isset($userQuery["q"]) ? "value='" . htmlspecialchars($userQuery["q"]) . "'" : ""; ?> autocomplete="off">

  </div>

  <!-- Filter Menu-->
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
                  <input name="min_year" type="number" class="form-control" <?php echo isset($userQuery["min_year"]) ? "value='" . htmlspecialchars($userQuery["min_year"]) . "'" : ""; ?> min="0" placeholder="van">
                </div>
                <div class="col-3">
                  <!-- max_year input -->
                  <input name="max_year" type="number" class="form-control" <?php echo isset($userQuery["max_year"]) ? "value='" . htmlspecialchars($userQuery["max_year"]) . "'" : ""; ?> min="0" placeholder="tot">
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
                  <input name="min_pages" type="number" class="form-control" <?php echo isset($userQuery["min_pages"]) ? "value='" . htmlspecialchars($userQuery["min_pages"]) . "'" : ""; ?> placeholder="van" min="0" size="4">
                </div>
                <div class="col-3">
                  <!-- max_pages input -->
                  <input name="max_pages" type="number" class="form-control" <?php echo isset($userQuery["max_pages"]) ? "value='" . htmlspecialchars($userQuery["max_pages"]) . "'" : ""; ?> placeholder="tot" min="0" size="4">
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
              <?php foreach ($filters["reading_level"] as $level) : ?>

                <div class="form-check">
                  <input type="checkbox" name="reading_level[]" id="checkboxReadingLevel<?php echo htmlspecialchars($level) ?>" class="form-check-input reading-level-checkbox" value="<?php echo htmlspecialchars($level) ?>" <?php if (isset($userQuery["reading_level"]) && in_array($level, $userQuery["reading_level"])) : ?> checked <?php endif ?>>
                  <label class="form-check-label" for="checkboxReadingLevel<?php echo htmlspecialchars($level) ?>">
                    <?php echo htmlspecialchars($level) ?>
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
      <button type="button" id="filter-button" class="ll-btn ll-btn-primary w-100" data-bs-toggle="offcanvas" data-bs-target="#filterMenu" aria-controls="filterMenu">Filter <?php echo count($books) ?> boeken</button>
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
              <a href="#"><img src="<?php echo !empty($book["image_link"]) ? htmlspecialchars($book["image_link"]) : $defaultImage ?>  " alt="$title"></a>
            </div>

            <!-- Middle-->
            <div class="col-8 ll-card-middle">
              <a href="#" class="ll-card-title"><?php echo htmlspecialchars(trim($book["title"])) ?></a>
              <p class="ll-card-details text-secondary mb-2"><?php echo htmlspecialchars(trim(implode(", ", $book["authors"]))) ?></p>
              <p class="ll-card-blurb m-0 mb-3"><?php echo htmlspecialchars(trim(mb_strimwidth($book["blurb"], 0, $blurbLength, "..."))) ?></p>
              <p class="ll-card-details text-secondary"><i><?php echo htmlspecialchars(trim(implode(", ", $book["themes"]))) ?></i></p>
            </div>

            <!-- Right -->
            <div class="col-2">
              <div class="ll-card-details mb-1 text-secondary"><i class="bi bi-calendar"></i> <?php echo htmlspecialchars(strval($book["year"])) ?></div>
              <div class="ll-card-details mb-1 text-secondary"><i class="bi bi-book"></i> <?php echo htmlspecialchars(strval($book["pages"])) ?></div>
              <div class="ll-card-details mb-1 text-secondary"><i class="bi bi-star"></i> <?php echo htmlspecialchars(strval($book["reading_level"])) ?></div>
              <div class="ll-card-details mb-1 text-secondary"><i class="bi bi-headphones"></i> ?</div>
            </div>

          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>

</div>

<script>
  const audiobookCheckboxes = document.querySelectorAll(".audiobook-checkbox");
  const readingLevelCheckboxes = document.querySelectorAll(".reading-level-checkbox");

  addCheckBoxStyling(audiobookCheckboxes, ".audiobook-checkbox");
  addCheckBoxStyling(readingLevelCheckboxes, ".reading-level-checkbox");

  function addCheckBoxStyling(checkboxes, cssClass) {
    markCheckedBoxes(cssClass);

    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener('change', () => {
        markCheckedBoxes(cssClass);
      });
    })
  }

  function markCheckedBoxes(cssClass) {
    let boxes = document.querySelectorAll(cssClass);

    if (allBoxesUnchecked(boxes)) {
      boxes.forEach((box) => {
        findLableForControl(box).classList.remove("checkbox-unchecked");
        findLableForControl(box).classList.remove("checkbox-checked");
      });

    } else {
      boxes.forEach((box) => {
        if (box.checked) {
          findLableForControl(box).classList.remove("checkbox-unchecked");
          findLableForControl(box).classList.add("checkbox-checked");
        } else {
          findLableForControl(box).classList.remove("checkbox-checked");
          findLableForControl(box).classList.add("checkbox-unchecked");
        }
      });

    }
  }

  function allBoxesUnchecked(boxes) {
    for (let box of boxes) {
      if (box.checked) {
        return false;
      }
    }
    return true;
  }

  function findLableForControl(el) {
    var idVal = el.id;
    labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
      if (labels[i].htmlFor == idVal)
        return labels[i];
    }
  }
</script>

<?php

require "common/footer.view.php";

?>