
<?php include __DIR__ . '/inc/header.php'; ?>

<div class="jumbotron">
  <div class="container">
    <h1 class="display-3">TypeSchema</h1>
    <p>TypeSchema is a JSON format to describe JSON structures. It helps to
    build schemas which are optimized for code generation. TypeSchema is
    compatible with JSON Schema and every TypeSchema is automatically a valid
    JSON Schema but not vice versa.</p>
    <p>
      <a class="btn btn-primary" href="<?php echo $router->getAbsolutePath(\App\Website\Specification::class); ?>" role="button">Specification</a>
      <a class="btn btn-secondary" href="<?php echo $router->getAbsolutePath(\App\Website\Generator::class); ?>" role="button">Generator</a>
    </p>
  </div>
</div>

<div class="container">
  <h2>Why</h2>

  <p>You might question: Why not use JSON Schema?</p>

  <p>For code generators it is difficult to work with JSON Schema. In JSON
  Schema you dont need to provide any keywords i.e. <code>{}</code> is a valid
  JSON Schema which basically allows every value and the defined keywords are
  applied based on the actual data. A code generator on the other hand needs to
  determine a concrete type of a schema without the actual data. Also JSON Schema
  has many keywords which contain logic like <code>dependencies</code>,
  <code>not</code>, <code>if/then/else</code> which are basically not needed for
  code generators and really complicate building them. We have also explained
  some pitfalls in our <a href="https://github.com/chriskapp/typeschema/blob/master/migration.md">migration document</a>.</p>

  <p>Because of the need for a better schema specification which is optimized
  for code generation we have developed TypeSchema. TypeSchema is an alternative
  to JSON Schema, basically it is a more stricter subset of JSON Schema which
  allows you to write clean schemas which can be easily turned into code. Every
  TypeSchema which you write is automatically also a valid JSON Schema bot not
  vice versa. Since this specification removes and restricts only keywords
  TypeSchema is compatible down to JSON Schema <code>draft-04</code>. Therefor
  all your tools will work with a TypeSchema. You can think of TypeSchema is to
  JSON Schema what TypeScript is to Javascript.</p>

  <h2>Who</h2>
  
  <p>We are developers coming from a classical OOP background. We have worked
  back in the days with WSDL/XSD and experienced the advantages of
  automatically generating client code. We think OpenAPI is a great replacement
  for WSDL but the schema definition part is not perfect yet. This project
  is a voice for all tool developers who like to have a more strict schema
  specification. If you want to support the project or want to provide feedback
  feel free to visit us on <a href="https://github.com/chriskapp/typeschema">GitHub</a>.</p>

  <h2>Overview</h2>

  <p>In TypeSchema you must define a <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#TypeSchema">Root</a>
  schema which must be of type <code>object</code>. This object must contain specific
  <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#Properties">Properties</a>.
  The <a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#Definitions">Definitions</a>
  keyword contains a list of schemas which can be reused.</p>

  <p>In TypeSchema every schema can be assigned to exactly one specific type
  based on the used keywords. The following list shows all available types:</p>

  <div class="psx-object">
    <h1><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#StructProperties">Struct</a></h1>
    <div class="psx-object-description">A struct contains a fix set of defined properties.</div>
    <pre><code class="json">{
  "type": "object",
  "properties": {
    "title": {
      "type": "string"
    },
    "createDate": {
      "type": "string",
      "format": "date-time"
    }
  }
}</code></pre>
  </div>

  <div class="psx-object">
    <h1><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#MapProperties">Map</a></h1>
    <div class="psx-object-description">A map contains variable key value entries of a specific type.</div>
    <pre><code class="json">{
  "type": "object",
  "additionalProperties": {
    "type": "string"
  }
}</code></pre>
  </div>

  <div class="psx-object">
    <h1><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#ArrayProperties">Array</a></h1>
    <div class="psx-object-description">An array contains an ordered list of a specific type.</div>
    <pre><code class="json">{
  "type": "array",
  "items": {
    "type": "string"
  }
}</code></pre>
  </div>

  <div class="psx-object">
    <h1><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#BooleanProperties">Boolean</a></h1>
    <div class="psx-object-description">Represents a boolean value.</div>
    <pre><code class="json">{
  "type": "boolean"
}</code></pre>
  </div>

  <div class="psx-object">
    <h1><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#NumberProperties">Number</a></h1>
    <div class="psx-object-description">Represents a number value (contains also integer).</div>
    <pre><code class="json">{
  "type": "number",
  "minimum": 12
}</code></pre>
  </div>

  <div class="psx-object">
    <h1><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#StringProperties">String</a></h1>
    <div class="psx-object-description">Represents a string value.</div>
    <pre><code class="json">{
  "type": "string",
  "minLength": 12
}</code></pre>
  </div>

  <div class="psx-object">
    <h1><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#AllOfProperties">Intersection</a></h1>
    <div class="psx-object-description">An intersection type combines multiple schemas into one.</div>
    <pre><code class="json">{
  "allOf": [{
    "$ref": "#/definitions/Person"
  }, {
    "$ref": "#/definitions/Student"
  }]
}</code></pre>
  </div>

  <div class="psx-object">
    <h1><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#OneOfProperties">Union</a></h1>
    <div class="psx-object-description">An union type can contain one of the provided schemas.</div>
    <pre><code class="json">{
  "oneOf": [{
    "$ref": "#/definitions/Car"
  }, {
    "$ref": "#/definitions/Train"
  }]
}</code></pre>
  </div>

  <div class="psx-object">
    <h1><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#ReferenceType">Reference</a></h1>
    <div class="psx-object-description">Represents a reference to another schema.</div>
    <pre><code class="json">{
  "$ref": "#/definitions/Car"
}</code></pre>
  </div>

  <div class="psx-object">
    <h1><a href="<?php echo $router->getAbsolutePath(App\Website\Specification::class); ?>#GenericType">Generic</a></h1>
    <div class="psx-object-description">
      <p>Represents a generic type.</p>
      <p><b>**NOTE: This is a TypeSchema specific feature which is not available in
      JSON Schema so use it only if you use a schema processor which supports
      TypeSchema**</b></p>
      <p>Through the <code>$generic</code> keyword it is possible to define a schema
      placeholder. I.e. if you want to reuse a collection schema with different
      entries:</p>
    </div>
    <pre><code class="json">{
  "type": "object",
  "properties": {
    "totalResults": {
      "type": "integer"
    },
    "itemsPerPage": {
      "type": "integer"
    },
    "entries": {
      "$generic": "T"
    }
  }
}</code></pre>
    <div class="psx-object-description">
      <p>Through the <code>$template</code> keyword it is possible to insert a
      concrete schema to the placeholder.</p>
    </div>
    <pre><code class="json">{
  "$ref": "#/definitions/Map",
  "$template": {
    "T": {
      "$ref": "#/definitions/News"
    }
  }
}</code></pre>
  </div>

</div>

<script>hljs.initHighlightingOnLoad();</script>

<?php include __DIR__ . '/inc/footer.php'; ?>
