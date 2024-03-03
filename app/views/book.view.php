<?php require "common/header.view.php" ?>
<div class="container-fluid search-container d-flex flex-column justify-content-center">
  <h1 class="text-white mt-0 mb-1"><?= esc($book["title"]) ?></h1>
  <h5 class="text-white mt-0 mb-1"><i><?= esc(implode(", ", $book["authors"])) ?></i></h5>
</div>
<div class="container-fluid pt-3">
  <div class="row">
    <div class="col-12 d-flex justify-content-center">
      <a href="<?= esc($book["imageLink"]) ?>"><img class="book-img" src="<?= esc($book["imageLink"]) ?>" alt="<?= esc($book["title"]) ?>"></a>
    </div>
  </div>
</div>

<!-- <p class="ll-card-blurb m-0 mb-3"><?= esc($book["blurb"]) ?></p> -->
<!-- <p class="ll-card-details text-grey-2"><i><?= !empty($book["themes"]) ? esc(implode(", ", $book["themes"])) : "" ?></i></p> -->
<!-- <?php if (!empty($book["year"])) : ?>
        <div class="ll-card-details mb-1 text-grey-2"><i class="bi bi-calendar"></i> <?= esc($book["year"]) ?></div>
      <?php endif ?>
      <?php if (!empty($book["pages"])) : ?>
        <div class="ll-card-details mb-1 text-grey-2"><i class="bi bi-book"></i> <?= esc($book["pages"]) ?></div>
      <?php endif ?>
      <?php if (!empty($book["readingLevel"])) : ?>
        <div class="ll-card-details mb-1 text-grey-2"><i class="bi bi-star"></i> <?= esc($book["readingLevel"]) ?></div>
      <?php endif ?>
      <?php if (!empty($book["audiobook"])) : ?>
        <div class="ll-card-details mb-1 text-grey-2"><i class="bi bi-headphones"></i> <?= esc(abbreviate($book["audiobook"])) ?></div>
      <?php endif ?> -->

<?php require "common/footer.view.php" ?>