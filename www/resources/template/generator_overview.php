
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Generator</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">DTO Generator</h1>
  <p class="lead">This list gives you access to our reference code generator implementation.
  To prevent misuse the code generator is protected by recaptcha, if you want to invoke the code generator
  programmatically please take a look at the <a href="https://sdkgen.app/">SDKgen project</a>
  which offers various integration options like an CLI, GitHub action or REST API.
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
