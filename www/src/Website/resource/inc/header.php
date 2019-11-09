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
  <a href="https://github.com/chriskapp/typeschema"><img src="<?php echo $base; ?>/img/github-32.png"></a>
</nav>
