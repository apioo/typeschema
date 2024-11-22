
<?php include __DIR__ . '/../inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / <a href="<?php echo $router->getAbsolutePath([\App\Controller\Integration::class, 'show']); ?>">Integration</a> / <?php echo $typeName; ?></li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4"><?php echo $typeName; ?> Integration</h1>
  <div class="mt-3 mb-3"><?php echo $description; ?></div>
  <div class="row">
    <div class="col-6">
      <div class="psx-object">
        <h1>DTO</h1>
        <div class="example-box"><pre><code class="<?php echo $type; ?>"><?php echo htmlspecialchars($dto); ?></code></pre></div>
      </div>
    </div>
    <div class="col-6">
      <div class="psx-object">
        <h1>Integration</h1>
        <div class="example-box"><pre><code class="<?php echo $type; ?>"><?php echo htmlspecialchars($integration); ?></code></pre></div>
      </div>
    </div>
  </div>
</div>

<script>window.addEventListener('load', function() { hljs.highlightAll() });</script>

<?php include __DIR__ . '/../inc/footer.php'; ?>
