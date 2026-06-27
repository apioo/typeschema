
<?php include __DIR__ . '/../inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / <a href="<?php echo $router->getAbsolutePath([\App\Controller\Generator::class, 'show']); ?>">Generator</a> / <?php echo $typeName; ?></li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4"><?php echo $typeName; ?> DTO Generator</h1>
  <p class="lead">Take a look at our <a href="https://sandbox.sdkgen.app/">Sandbox</a> app of the
  <a href="https://sdkgen.app/">SDKgen project</a> which provides a simple editor to design a specification and generate
  <?php echo $typeName; ?> code. It provides also several other <a href="https://sdkgen.app/integration">integration options</a>.</p>
  <a href="https://sandbox.sdkgen.app/" class="btn btn-primary">Sandbox</a>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
