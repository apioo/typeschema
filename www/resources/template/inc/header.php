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
  <script>
    var _paq = window._paq = window._paq || [];
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//matomo.apioo.de/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '3']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
    })();
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
      <a class="nav-link" href="<?php echo $router->getAbsolutePath([\App\Controller\Integration::class, 'show']); ?>">Integration</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath([\App\Controller\Ecosystem::class, 'show']); ?>">Ecosystem</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath([\App\Controller\Tools::class, 'show']); ?>">Tools</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $router->getAbsolutePath([\App\Controller\History::class, 'show']); ?>">History</a>
    </li>
  </ul>
  <a href="https://github.com/apioo/typeschema"><img src="<?php echo $base; ?>/img/github-32.png" width="32" height="32" alt="GitHub logo"></a>
</nav>
