<?php require "common/header.view.php" ?>
<h3><?= esc($book[0]["title"]) ?></h3>
<img src="<?= esc($book[0]["image_link"]) ?>" alt="<?= esc($book[0]["title"]) ?>" height="200">
<p>Hier komt informatie over dit book.</p>
<?php require "common/footer.view.php" ?>