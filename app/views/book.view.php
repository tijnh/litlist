<?php require "common/header.view.php" ?>
<h3><?= esc($book["title"]) ?></h3>
<a href="<?= esc($book["imageLink"]) ?>" target="_blank"> <img src="<?= esc($book["imageLink"]) ?>" alt="<?= esc($book["title"]) ?>" height="200"></a>
<p>Hier komt informatie over dit book.</p>
<?php show($book) ?>
<?php require "common/footer.view.php" ?>