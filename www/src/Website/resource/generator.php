
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Generator</li>
  </ol>
</nav>

<div class="container">
  <h1>Generator</h1>
  <div class="row">
    <div class="col-6">
      <form method="post">
        <div class="form-group">
          <label for="type">Type</label>
          <select id="type" name="type" class="form-control">
            <option value="csharp">csharp</option>
            <option value="go">go</option>
            <option value="html">html</option>
            <option value="java">java</option>
            <option value="jsonschema">jsonschema</option>
            <option value="markdown">markdown</option>
            <option value="php">php</option>
            <option value="protobuf">protobuf</option>
            <option value="typescript">typescript</option>
          </select>
        </div>
        <div class="form-group">
          <label for="schema">Schema</label>
          <textarea id="schema" name="schema" rows="18" class="form-control">{
  "title": "Student",
  "type": "object",
  "properties": {
    "firstName": {
      "type": "string"
    },
    "lastName": {
      "type": "string"
    }
  }
}</textarea>
        </div>
        <input type="submit" value="Generate" class="btn btn-primary">
      </form>
    </div>
    <div class="col-6">
      <div><pre><code class="<?php echo $type ?? ''; ?>"><?php echo isset($output) ? htmlspecialchars($output) : ''; ?></code></pre></div>
    </div>
  </div>
</div>

<script>hljs.initHighlightingOnLoad();</script>

<?php include __DIR__ . '/inc/footer.php'; ?>
