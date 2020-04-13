
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Example</li>
  </ol>
</nav>

<div class="container">

  <h1>Example</h1>

  <p>The following page shows some TypeSchema examples.</p>

  <div class="psx-object">
    <h1>Advanced OOP example</h1>
    <pre><code class="json">{
  "$import": {
    "my_lib": "https://acme.com/schema/common.json"
  },
  "definitions": {
    "Student": {
      "$extends": "my_lib:Human",
      "type": "object",
      "properties": {
        "matricleNumber": {
          "type": "integer"
        }
      }
    },
    "StudentMap": {
      "$ref": "Map",
      "$template": {
        "T": {
          "$ref": "Student"
        }
      }
    },
    "Map": {
      "type": "object",
      "properties": {
        "totalResults": {
          "type": "integer"
        },
        "entries": {
          "type": "array",
          "items": {
            "$generic": "T"
          }
        }
      }
    }
  }
}</code></pre>
  </div>

</div>

<script>hljs.initHighlightingOnLoad();</script>

<?php include __DIR__ . '/inc/footer.php'; ?>
