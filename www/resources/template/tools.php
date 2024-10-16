
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Tools</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">Tools</h1>
  <p class="lead">We provide several tools which can help to migrate from an external specification or generate specific output based on an existing to TypeSchema specification.</p>
  <div class="row">
    <div class="col-6">
      <div class="list-group">
        <li class="list-group-item disabled font-weight-bold" aria-disabled="true">Migration</li>
        <a href="<?php echo $router->getAbsolutePath([\App\Controller\Tools\Json::class, 'show']); ?>" class="list-group-item list-group-item-action">JSON</a>
        <a href="<?php echo $router->getAbsolutePath([\App\Controller\Tools\JsonSchema::class, 'show']); ?>" class="list-group-item list-group-item-action">JSON Schema</a>
        <a href="<?php echo $router->getAbsolutePath([\App\Controller\Tools\OpenAPI::class, 'show']); ?>" class="list-group-item list-group-item-action">OpenAPI</a>
      </div>
    </div>
    <div class="col-6">
      <div class="list-group">
        <li class="list-group-item disabled font-weight-bold" aria-disabled="true">Generate</li>
        <a href="<?php echo $router->getAbsolutePath([\App\Controller\Tools\Changelog::class, 'show']); ?>" class="list-group-item list-group-item-action">Changelog</a>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
