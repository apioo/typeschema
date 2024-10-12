
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / <?php echo $type; ?></li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4"><?php echo $type; ?> examples</h1>
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
      <?php foreach ($example->types as $type => $code): ?>
          <?php if ($code instanceof stdClass): ?>
            <?php foreach ($code as $fileName => $chunk): ?>
            <div class="psx-object">
              <h1><?php echo $fileName; ?></h1>
              <div class="example-box"><pre><code class="<?php echo $type; ?>"><?php echo htmlspecialchars($chunk); ?></code></pre></div>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
          <div class="psx-object">
            <h1>Output</h1>
            <div class="example-box"><pre><code class="<?php echo $type; ?>"><?php echo htmlspecialchars($code); ?></code></pre></div>
          </div>
          <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
  <hr>
  <?php endforeach; ?>

  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/resources/template/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<script>window.addEventListener('load', function() { hljs.highlightAll() });</script>

<?php include __DIR__ . '/inc/footer.php'; ?>
