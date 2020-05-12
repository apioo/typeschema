<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="<?php echo $base; ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $base; ?>/css/highlight.min.css">
  <link rel="stylesheet" href="<?php echo $base; ?>/css/app.css">
  <script src="<?php echo $base; ?>/js/highlight.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <title>TypeSchema</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?php echo $url; ?>">TypeSchema</a>
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Index::class); ?>">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Specification::class); ?>">Specification</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Generator::class); ?>">Generator</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Faq::class); ?>">FAQ</a>
    </li>
  </ul>
  <a href="https://github.com/chriskapp/typeschema"><img src="<?php echo $base; ?>/img/github-32.png"></a>
</nav>
