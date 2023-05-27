
<?php include __DIR__ . '/../inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Generator / Schema</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">Schema</h1>
  <div class="alert alert-info" role="alert">
    Through this form you can transform an existing TypeSchema into a specific output.
  </div>
  <div class="row">
    <div class="col-6">
      <form method="post">
        <div class="form-group">
          <label for="type">Type</label>
          <select id="type" name="type" class="form-control">
            <?php foreach($types as $type): ?>
            <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="schema">Schema</label>
          <textarea id="schema" name="schema" rows="18" class="form-control"><?php echo htmlspecialchars($schema); ?></textarea>
        </div>
        <input type="submit" value="Generate" class="btn btn-primary">
      </form>
    </div>
    <div class="col-6">
      <div><pre><code class="<?php echo $type ?? ''; ?>"><?php echo isset($output) ? htmlspecialchars($output) : ''; ?></code></pre></div>
    </div>
  </div>
</div>

<script>window.addEventListener('load', function() { hljs.highlightAll() });</script>

<?php include __DIR__ . '/../inc/footer.php'; ?>
