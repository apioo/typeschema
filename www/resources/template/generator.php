
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / <a href="<?php echo $router->getAbsolutePath([\App\Controller\Generator::class, 'show']); ?>">Generator</a> / <?php echo $typeName; ?></li>
  </ol>
</nav>

<div class="container-fluid">
  <h1 class="display-4"><?php echo $typeName; ?> DTO Generator</h1>
  <div class="row">
    <div class="col-6">
      <form method="post" action="<?php echo $router->getAbsolutePath([\App\Controller\Generator::class, 'generate'], ['type' => $type]); ?>">
        <div class="form-group">
          <input id="namespace" name="namespace" placeholder="Optional a namespace" value="<?php echo htmlspecialchars($namespace ?? ''); ?>" class="form-control">
        </div>
        <div class="form-group">
          <textarea id="schema" name="schema" rows="24" class="form-control"><?php echo htmlspecialchars($schema); ?></textarea>
        </div>
        <input type="submit" value="Generate" class="btn btn-primary">
      </form>
    </div>
    <div class="col-6">
      <?php if(isset($output)): ?>
      <form method="post" action="<?php echo $router->getAbsolutePath([\App\Controller\Generator::class, 'download'], ['type' => $type]); ?>">
        <input type="hidden" name="namespace" value="<?php echo htmlspecialchars($namespace ?? ''); ?>">
        <input type="hidden" name="schema" value="<?php echo htmlspecialchars($schema); ?>">
        <input type="submit" value="Download" class="btn btn-primary">
      </form>
      <hr>
      <?php if ($output instanceof stdClass): ?>
        <?php foreach ($output as $fileName => $chunk): ?>
        <div class="psx-object">
          <h1><?php echo $fileName; ?></h1>
          <div class="example-box"><pre><code class="<?php echo $type; ?>"><?php echo htmlspecialchars($chunk); ?></code></pre></div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
      <div class="psx-object">
        <h1>Output</h1>
        <div class="example-box"><pre><code class="<?php echo $type; ?>"><?php echo htmlspecialchars($output); ?></code></pre></div>
      </div>
      <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>window.addEventListener('load', function() { hljs.highlightAll() });</script>

<?php include __DIR__ . '/inc/footer.php'; ?>
