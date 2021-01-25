
<?php include __DIR__ . '/inc/header.php'; ?>

<div class="jumbotron">
  <div class="container" style="text-align: center">
    <h1 class="display-4">TypeSchema</h1>
    <p class="lead">TypeSchema is a JSON format to describe data models in a language neutral
    format. A TypeSchema can be easily transformed into specific code for almost
    any programming language. This helps to reuse core data models in different
    environments.</p>
    <p>
      <a class="btn btn-primary" href="<?php echo $router->getAbsolutePath(\App\Website\Specification::class); ?>" role="button">Specification</a>
      <a class="btn btn-secondary" href="<?php echo $router->getAbsolutePath(\App\Website\Generator::class); ?>" role="button">Generator</a>
    </p>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-12" style="text-align: center">
      <img src="<?php echo $base; ?>/img/typeschema_flow.png">
      <hr>
      <p class="lead">TypeSchema uses a JSON format to describe your model. Based
      on this JSON format it can generate models in multiple languages. The
      following list shows some examples:</p>
      <br><br>
    </div>
  </div>
</div>

<div class="container">
  <?php foreach($examples as $key => $example): ?>
  <div class="row">
    <div class="col-6">
      <div class="psx-object">
        <h1><?php echo $example->title; ?></h1>
        <div class="psx-object-description"><?php echo $example->description; ?></div>
        <div class="example-box"><pre><code class="json"><?php echo $example->schema; ?></code></pre></div>
      </div>
    </div>
    <div class="col-6">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <?php foreach ($example->types as $type => $code): ?>
          <a class="nav-item nav-link <?php echo key($example->types) === $type ? 'active' : ''; ?>" id="<?php echo $type . '-' . $key; ?>-tab" data-toggle="tab" href="#<?php echo $type . '-' . $key; ?>" role="tab"><?php echo ucfirst($type); ?></a>
          <?php endforeach; ?>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <?php foreach ($example->types as $type => $code): ?>
        <div class="tab-pane fade <?php echo key($example->types) === $type ? 'show active' : ''; ?>" id="<?php echo $type . '-' . $key; ?>" role="tabpanel">
            <div class="example-box"><pre><code class="<?php echo $type; ?>"><?php echo htmlspecialchars($code); ?></code></pre></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <hr>
  <?php endforeach; ?>
</div>

<script>hljs.initHighlightingOnLoad();</script>

<?php include __DIR__ . '/inc/footer.php'; ?>
