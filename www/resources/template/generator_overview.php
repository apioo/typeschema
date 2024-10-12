
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Generator</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">DTO Generator</h1>
  <p class="lead">This list gives you access to our reference code generator implementation.
  For more advanced integration options like an REST API, CLI or GitHub action please take a look
  at the <a href="https://sdkgen.app/">SDKgen project</a>.
  </p>
  <div class="row">
    <?php foreach ($types as $chunk): ?>
      <div class="col-6">
        <div class="list-group">
          <?php foreach ($chunk as $type => $typeTitle): ?>
            <a href="<?php echo $router->getAbsolutePath([\App\Controller\Generator::class, 'showType'], ['type' => $type]); ?>" class="list-group-item list-group-item-action"><?php echo $typeTitle; ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
