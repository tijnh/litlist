<?php require "common/header.view.php" ?>
<div class="container-fluid search-container d-flex align-items-center">
  <a href="<?= ROOT ?>/browse" class="btn btn-primary-reversed"><i class="bi bi-arrow-left"></i> Zoek een boek</a>
</div>
<div class="container-sm pt-3">
  <div class="row justify-content-center">
    <!-- Left -->
    <div class="col-12 col-md-2">
      <!-- Image -->
      <a href="<?= esc($book["imageLink"]) ?>"><img class="book-img" src="<?= esc($book["imageLink"]) ?>" alt="<?= esc($book["title"]) ?>"></a>
      <!-- Details -->
      <div>
        <?php if (!empty($book["year"])) : ?>
          <div class="mt-2"><i class="bi bi-calendar"></i> <?= esc($book["year"]) ?></div>
        <?php endif ?>
        <?php if (!empty($book["pages"])) : ?>
          <div class="mt-2"><i class="bi bi-book"></i> <?= esc($book["pages"]) ?></div>
        <?php endif ?>
        <?php if (!empty($book["readingLevel"])) : ?>
          <div class="mt-2"><i class="bi bi-star"></i> <?= esc($book["readingLevel"]) ?></div>
        <?php endif ?>
        <?php if (!empty($book["audiobook"])) : ?>
          <div class="mt-2"><i class="bi bi-headphones"></i> <?= esc($book["audiobook"]) ?></div>
        <?php endif ?>
      </div>

    </div>
    <!-- Right -->
    <div class="col-12 col-md-8">
      <!-- Title -->
      <h1><?= esc($book["title"]) ?></h1>
      <h3><?= esc(implode(", ", $book["authors"])) ?></h3>

      <?php if (!empty($book["blurb"])) : ?>
        <div class="info-header">Beschrijving</div>
        <p><?= esc($book["blurb"]) ?></p>
      <?php endif ?>

      <?php if (!empty($book["summary"])) : ?>
        <div class="info-header">Samenvatting</div>
        <p><?= esc($book["summary"]) ?></p>
      <?php endif ?>

      <?php if (!empty($book["recommendationText"])) : ?>
        <div class="info-header">Wat zeggen docenten?</div>
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


<?php require "common/footer.view.php" ?>