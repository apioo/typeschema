<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="<?php echo $base; ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $base; ?>/css/highlight.min.css">
  <link rel="stylesheet" href="<?php echo $base; ?>/css/app.css">
  <script src="<?php echo $base; ?>/js/highlight.min.js"></script>
  <title>TypeSchema</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?php echo $url; ?>">TypeSchema</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Index::class); ?>">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Specification::class); ?>">Specification</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Implementation::class); ?>">Implementation</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Generator::class); ?>">Generator</a>
      </li>
    </ul>
  </div>
</nav>
