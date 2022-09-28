<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="<?php echo $base; ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $base; ?>/css/highlight.min.css">
  <link rel="stylesheet" href="<?php echo $base; ?>/css/app.css">
  <script src="<?php echo $base; ?>/js/highlight.min.js"></script>
  <script src="<?php echo $base; ?>/js/jquery.min.js"></script>
  <script src="<?php echo $base; ?>/js/popper.min.js"></script>
  <script src="<?php echo $base; ?>/js/bootstrap.min.js"></script>
  <title>TypeSchema</title>
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-BB1NL30RKL"></script>
  <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-BB1NL30RKL', { 'anonymize_ip': true });
  </script>
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
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">Generator</a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath(\App\Website\Generator\Schema::class); ?>">Schema</a>
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath(\App\Website\Generator\Changelog::class); ?>">Changelog</a>
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath(\App\Website\Generator\Hash::class); ?>">Hash</a>
      </div>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">Migration</a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath(\App\Website\Migration\JsonSchema::class); ?>">JSON Schema</a>
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath(\App\Website\Migration\OpenAPI::class); ?>">OpenAPI</a>
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath(\App\Website\Migration\Json::class); ?>">JSON</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Developer::class); ?>">Developer</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Ecosystem::class); ?>">Ecosystem</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath(\App\Website\Faq::class); ?>">FAQ</a>
    </li>
  </ul>
  <a href="https://github.com/apioo/typeschema"><img src="<?php echo $base; ?>/img/github-32.png"></a>
</nav>
