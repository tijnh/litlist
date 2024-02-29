<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/img/favicon.ico">
  <title>404: Pagina niet gevonden</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">
</head>

<body>
  <div class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
      <h1 class="display-1 fw-bold">404</h1>
      <p class="fs-3"> <span class="text-danger">Oeps!</span> Pagina niet gevonden.</p>
      <p class="lead">
        De pagina die je zocht bestaat niet.
      </p>
      <a href="<?= ROOT ?>" class="btn btn-primary">Ga terug</a>
    </div>
  </div>
  <?php require "common/footer.view.php" ?>