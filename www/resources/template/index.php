
<?php include __DIR__ . '/inc/header.php'; ?>

<div class="jumbotron">
  <div class="container" style="text-align: center">
    <h1 class="display-4">TypeSchema</h1>
    <p class="lead">TypeSchema is a JSON format to describe data models in a language neutral
    format. A TypeSchema can be easily transformed into specific code for almost
    any programming language. This helps to reuse core data models in different
    environments.</p>
    <p>
      <a class="btn btn-primary" href="<?php echo $router->getAbsolutePath([\App\Controller\Specification::class, 'show']); ?>" role="button">Specification</a>
      <a class="btn btn-secondary" href="<?php echo $router->getAbsolutePath([\App\Controller\Generator\Schema::class, 'show']); ?>" role="button">Generator</a>
    </p>
  </div>
</div>

<div class="container">
  <?php foreach($examples as $key => $example): ?>
  <div class="row">
    <div class="col-md-6">
      <div class="psx-object">
        <h1><?php echo $example->title; ?></h1>
        <div class="psx-object-description"><?php echo $example->description; ?></div>
        <div class="example-box"><pre><code class="json"><?php echo $example->schema; ?></code></pre></div>
      </div>
    </div>
    <div class="col-md-6">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <?php foreach ($example->types as $type => $code): ?>
          <a class="nav-item nav-link <?php echo key(get_object_vars($example->types)) === $type ? 'active' : ''; ?>" id="<?php echo $type . '-' . $key; ?>-tab" data-toggle="tab" href="#<?php echo $type . '-' . $key; ?>" role="tab"><?php echo ucfirst($type); ?></a>
          <?php endforeach; ?>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <?php foreach ($example->types as $type => $code): ?>
        <div class="tab-pane fade <?php echo key(get_object_vars($example->types)) === $type ? 'show active' : ''; ?>" id="<?php echo $type . '-' . $key; ?>" role="tabpanel">
            <div class="example-box"><pre><code class="<?php echo $type; ?>"><?php echo htmlspecialchars($code); ?></code></pre></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <hr>
  <?php endforeach; ?>

  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/src/Website/resource/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<script>window.addEventListener('load', function() { hljs.highlightAll() });</script>

<?php include __DIR__ . '/inc/footer.php'; ?>
