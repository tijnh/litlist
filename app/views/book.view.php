<?php require "common/header.view.php" ?>
<div class="container-fluid search-container d-flex align-items-center">
  <a href="<?= ROOT ?>/browse" class="btn btn-primary-reversed "><i class="bi bi-arrow-left"></i> Zoek een boek</a>
</div>

<div class="container-sm mt-3">

  <div class="row justify-content-center">

    <!-- Title and author on small devices -->
    <div class="col-12 d-block d-md-none text-center mb-3">
      <h1 class="mb-2"><?= esc($book["title"]) ?></h1>
      <h3 class="text-grey-1"><?= esc(implode(", ", $book["authors"])) ?></h3>
    </div>

    <!-- Image -->
    <div class="col-12 col-md-3 col-lg-2 text-center">
      <a href="<?= esc($book["imageLink"]) ?>"><img class="book-img" src="<?= esc($book["imageLink"]) ?>" alt="<?= esc($book["title"]) ?>"></a>
    </div>

    <!-- Right -->
    <div class="col-12 col-md-7 col-lg-8 text-center text-md-start">

      <div class="row justify-content-center">

        <!-- Title and author on larger devices -->
        <div class="col-12 d-none d-md-block">
          <h1 class="mb-2"><?= esc($book["title"]) ?></h1>
          <h3 class="text-grey-1"><?= esc(implode(", ", $book["authors"])) ?></h3>
        </div>

        <!-- Textual info -->
        <div class="col-12">

          <?php if (!empty($book["blurb"])) : ?>
            <div class="info-header">Beschrijving</div>
            <p><?= esc($book["blurb"]) ?></p>
          <?php endif ?>

          <?php if (!empty($book["summary"])) : ?>
            <div class="info-header">Samenvatting</div>
            <p><?= esc($book["summary"]) ?></p>
          <?php endif ?>

          <?php if (!empty($book["themes"])) : ?>
            <div class="info-header">Thema's</div>
            <ul>
              <?php foreach ($book["themes"] as $theme) : ?>
                <li><?= esc(ucfirst($theme)) ?></li>
              <?php endforeach ?>
            </ul>
          <?php endif ?>

          <?php if (!empty($book["recommendationText"])) : ?>
            <div class="info-header">Segbroek docent over dit boek</div>
            <p><?= esc($book["recommendationText"]) ?></p>
          <?php endif ?>

          <?php if (!empty($book["reviewText"]) || !empty($book["reviewLink"])) : ?>
            <div class="info-header">Review</div>

            <?php if (!empty($book["reviewText"])) : ?>
              <p><?= esc($book["reviewText"]) ?></p>
            <?php endif ?>

            <?php if (!empty($book["reviewLink"])) : ?>
              <p>Klik <a class="inline-link" href="<?= esc($book["reviewLink"]) ?>">hier</a> voor een review.</p>
            <?php endif ?>

          <?php endif ?>

          <?php if (!empty($book["secondaryLiteratureText"]) || !empty($book["secondaryLiteratureLink"])) : ?>
            <div class="info-header">Secundaire literatuur</div>

            <?php if (!empty($book["secondaryLiteratureText"])) : ?>
              <p><?= esc($book["secondaryLiteratureText"]) ?></p>
            <?php endif ?>

            <?php if (!empty($book["secondaryLiteratureLink"])) : ?>
              <p>Klik <a class="inline-link" href="<?= esc($book["secondaryLiteratureLink"]) ?>">hier</a> voor secundaire literatuur.</p>
            <?php endif ?>

          <?php endif ?>



        </div>

      </div>
    </div>



  </div>
</div>











</div>
</div>
</div>


<?php require "common/footer.view.php" ?>