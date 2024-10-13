<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="TypeSchema is a JSON specification to describe data models in a programming language neutral format.">
  <meta name="keywords" content="JSON Schema, TypeSchema, Data, Model, Specification, Code Generation, Code Generator">
  <title><?php if(isset($title)): ?><?php echo $title; ?><?php else: ?>TypeSchema<?php endif; ?></title>
  <link rel="preload" href="<?php echo $base; ?>/css/app.min.css" as="style" />
  <link rel="preload" href="<?php echo $base; ?>/js/app.min.js" as="script" />
  <link rel="stylesheet" href="<?php echo $base; ?>/css/app.min.css">
  <link rel="canonical" href="<?php echo $router->getUrl($method, isset($parameters) ? (array) $parameters : []); ?>">
  <script async src="<?php echo $base; ?>/js/app.min.js"></script>
<?php if (isset($js) && is_array($js)): ?>
  <?php foreach ($js as $link): ?><script src="<?php echo $link; ?>"></script>
<?php endforeach; ?>
<?php endif; ?>
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
      <a class="nav-link" href="<?php echo $router->getAbsolutePath([\App\Controller\Index::class, 'show']); ?>">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath([\App\Controller\Specification::class, 'show']); ?>">Specification</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath([\App\Controller\Generator::class, 'show']); ?>">Generator</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath([\App\Controller\Ecosystem::class, 'show']); ?>">Ecosystem</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath([\App\Controller\Faq::class, 'show']); ?>">FAQ</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="generatorDropdown" role="button" data-toggle="dropdown" aria-expanded="false">Tools</a>
      <div class="dropdown-menu" aria-labelledby="generatorDropdown">
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath([\App\Controller\Migration\JsonSchema::class, 'show']); ?>">JSON Schema</a>
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath([\App\Controller\Migration\OpenAPI::class, 'show']); ?>">OpenAPI</a>
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath([\App\Controller\Migration\Json::class, 'show']); ?>">JSON</a>
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath([\App\Controller\Changelog::class, 'show']); ?>">Changelog</a>
        <a class="dropdown-item" href="<?php echo $router->getAbsolutePath([\App\Controller\Hash::class, 'show']); ?>">Hash</a>
      </div>
    </li>
  </ul>
  <a href="https://github.com/apioo/typeschema"><img src="<?php echo $base; ?>/img/github-32.png" width="32" height="32" alt="GitHub logo"></a>
</nav>
