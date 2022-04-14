
<?php include __DIR__ . '/../inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Migration / JSON Schema</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">JSON</h1>
  <div class="alert alert-info" role="alert">
    Through this form you can generate a schema from existing JSON data. It contains also a logic to detect objects of
    the same type. You should see this as a starting point since you need to add proper names to each type.
  </div>
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

<script>hljs.initHighlightingOnLoad();</script>

<?php include __DIR__ . '/../inc/footer.php'; ?>
