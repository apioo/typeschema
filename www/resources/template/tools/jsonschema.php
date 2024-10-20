
<?php include __DIR__ . '/../inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / <a href="<?php echo $router->getAbsolutePath([\App\Controller\Tools::class, 'show']); ?>">Tools</a> / JSON Schema</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">JSON Schema</h1>
  <p class="lead">
    Through this form you can migrate an existing JSON Schema to a TypeSchema. If you see a name like i.e. <code>Inlinec650cd78</code>
    this means that there is an anonymous type in your schema, the migration makes this only visible and you should set
    a meaningful name for this type.
  </p>
  <hr>
  <div class="row">
    <div class="col-6">
      <form method="post">
        <div class="form-group">
          <label for="schema">Schema</label>
          <textarea id="schema" name="schema" rows="18" class="form-control"><?php echo htmlspecialchars($schema); ?></textarea>
        </div>
        <input type="submit" value="Migrate" class="btn btn-primary">
      </form>
    </div>
    <div class="col-6">
      <div><pre><code class="json"><?php echo isset($output) ? htmlspecialchars($output) : ''; ?></code></pre></div>
    </div>
  </div>
</div>

<script>window.addEventListener('load', function() { hljs.highlightAll() });</script>

<?php include __DIR__ . '/../inc/footer.php'; ?>
