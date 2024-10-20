
<?php include __DIR__ . '/inc/header.php'; ?>

<div class="jumbotron">
  <div class="container" style="text-align: center">
    <h1 class="display-4">TypeSchema</h1>
    <p class="lead">TypeSchema is a JSON specification to describe data models.</p>
    <p>
      <a class="btn btn-primary" href="<?php echo $router->getAbsolutePath([\App\Controller\Specification::class, 'show']); ?>" role="button">Specification</a>
      <a class="btn btn-secondary" href="https://sandbox.typeschema.org/" role="button">Editor</a>
      <a class="btn btn-secondary" href="<?php echo $router->getAbsolutePath([\App\Controller\Generator::class, 'show']); ?>" role="button">Generator</a>
    </p>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-12">
      <h2>Features</h2>
      <p class="lead"></p>
      <ul class="lead">
        <li>An elegant specification optimized for code-generation</li>
        <li>A portable format to share data models across different programming languages</li>
        <li>Generate clean and simple to use <abbr title="Data-Transfer-Objects">DTOs</abbr></li>
        <li>Handle advanced concepts like inheritance, polymorphism and generics</li>
        <li>Use reflection to easily turn any class into a TypeSchema specification</li>
        <li>Easily implement your own code generator</li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <hr>
      <h2>Examples</h2>
      <p class="lead">At the following list you can take a look at example output for each supported programming language.</p>
    </div>
    <?php foreach ($types as $chunk): ?>
    <div class="col-6">
      <div class="list-group">
        <?php foreach ($chunk as $type => $typeTitle): ?>
          <a href="<?php echo $router->getAbsolutePath([\App\Controller\Example::class, 'show'], ['type' => $type]); ?>" class="list-group-item list-group-item-action"><?php echo $typeTitle; ?></a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/resources/template/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<script>window.addEventListener('load', function() { hljs.highlightAll() });</script>

<?php include __DIR__ . '/inc/footer.php'; ?>
