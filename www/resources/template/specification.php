
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Specification</li>
  </ol>
</nav>

<div class="container">

  <h1 class="display-4">Specification</h1>

  <hr>

  <h2>Table of Contents</h2>
  <ul>
    <li><a href="#Introduction">Introduction</a></li>
    <li><a href="#Root">Root</a>
      <ul>
        <li><a href="#Import">Import</a></li>
      </ul>
    </li>
    <li><a href="#Types">Types</a>
      <ul>
        <li><a href="#Struct">Struct</a></li>
        <li><a href="#Map">Map</a></li>
        <li><a href="#Array">Array</a></li>
        <li><a href="#Boolean">Boolean</a></li>
        <li><a href="#Number">Number</a></li>
        <li><a href="#String">String</a></li>
        <li><a href="#Intersection">Intersection</a></li>
        <li><a href="#Union">Union</a></li>
        <li><a href="#Reference">Reference</a></li>
        <li><a href="#Generic">Generic</a></li>
      </ul>
    </li>
    <li><a href="#Structure">Structure</a></li>
    <li><a href="#Generator">Generator</a></li>
    <li><a href="#Appendix">Appendix</a></li>
  </ul>

  <hr>

  <a id="Introduction"></a>
  <h2>Introduction</h2>

  <p>This document describes the TypeSchema specification. TypeSchema is a JSON format to model data structures. It
  abstracts OOP concepts into a simple and deterministic JSON format which can be turned into code for many different
  target languages. The main use case of TypeSchema is to describe a data model, it is not designed to validate JSON
  structures. A data model described in TypeSchema can be used as single source of truth which can be reused in many
  different environments.</p>

  <hr>

  <a id="Root"></a>
  <h2>Root</h2>

  <p>Every TypeSchema has a <a href="#TypeSchema">Root</a> definition. The Root must contain at least the
  <code>definitions</code> keyword i.e.:</p>
  <pre class="json hljs">{
    "definitions": {
        "TypeA": { ... },
        "TypeB": { ... }
    }
}</pre>

  <p>The <code>definitions</code> keyword contains simply a map containing <a href="#StructType">Struct</a>,
  <a href="#MapType">Map</a> and <a href="#ReferenceType">Reference</a> types.</p>

  <p>Optional it is possible to include a <code>$ref</code> keyword which points to the default type.</p>

  <hr>

  <a id="Import"></a>
  <h3>Import</h3>

  <p>Optional it is possible to import other documents through the <code>$import</code> keyword. It contains a map
  where the key is the namespace and the value points to a remote document. The value is a URN and the supported
  schemes i.e. <code>file</code>, <code>http</code>, <code>https</code> etc. are out of bound of this specification.</p>

  <pre><code class="json">{
    "$import": {
        "MyNamespace": "file:///my_schema.json"
    }
}</code></pre>

  <p>Inside a reference it is then possible to reuse all types under the namespace which are defined at the remote
  document i.e.:</p>

  <pre><code class="json">{
    "$ref": "MyNamespace:MyType"
}</code></pre>

  <hr>

  <a id="Types"></a>
  <h2>Types</h2>

  <p>At TypeSchema every type can be determined based on the used keywords. The following list describes every type
  and how to use them.</p>

  <hr>

  <a id="Struct"></a>
  <h3>Struct</h3>

  <p>Represents a struct type. A struct type contains a fix set of defined properties. A struct type must have a
  <code>type</code> and <code>properties</code> keyword. The type must be <code>object</code>.</p>

  <pre><code class="json">{
    "type": "object",
    "properties": {
        "PropertyA": { ... },
        "PropertyB": { ... }
    }
}</code></pre>

  <p>All allowed properties are described at the <a href="#StructType">Appendix</a>.</p>

  <hr>

  <a id="Map"></a>
  <h3>Map</h3>

  <p>Represents a map type. A map type contains variable key value entries of a specific type. A map type must have a
  <code>type</code> and <code>additionalProperties</code> keyword. The type must be <code>object</code>.</p>

  <pre><code class="json">{
    "type": "object",
    "additionalProperties": { ... }
}</code></pre>

  <p>All allowed properties are described at the <a href="#MapType">Appendix</a>.</p>

  <hr>

  <a id="Array"></a>
  <h3>Array</h3>

  <p>Represents an array type. An array type contains an ordered list of a specific type. An array type must have a
  <code>type</code> and <code>items</code> keyword. The type must be <code>array</code>.</p>

  <pre><code class="json">{
    "type": "array",
    "items": { ... }
}</code></pre>

  <p>All allowed properties are described at the <a href="#ArrayType">Appendix</a>.</p>

  <hr>

  <a id="Boolean"></a>
  <h3>Boolean</h3>

  <p>Represents a boolean type. A boolean type must have a <code>type</code> keyword and the type must be
  <code>boolean</code>.</p>

  <pre><code class="json">{
    "type": "boolean"
}</code></pre>

  <p>All allowed properties are described at the <a href="#BooleanType">Appendix</a>.</p>

  <hr>

  <a id="Number"></a>
  <h3>Number</h3>

  <p>Represents a number type (contains also integer). A number type must have a <code>type</code> keyword and the type
  must be <code>number</code> or <code>integer</code>.</p>

  <pre><code class="json">{
    "type": "number"
}</code></pre>

  <p>All allowed properties are described at the <a href="#NumberType">Appendix</a>.</p>

  <hr>

  <a id="String"></a>
  <h3>String</h3>

  <p>Represents a string type. A string type must have a <code>type</code> keyword and the type must
  be <code>string</code>.</p>

  <pre><code class="json">{
    "type": "string"
}</code></pre>

  <p>All allowed properties are described at the <a href="#StringType">Appendix</a>.</p>

  <hr>

  <a id="Intersection"></a>
  <h3>Intersection</h3>

  <p>Represents an intersection type. An intersection type must have an <code>allOf</code> keyword.</p>

  <pre><code class="json">{
    "allOf": [{ ... }, { ... }]
}</code></pre>

  <p>All allowed properties are described at the <a href="#IntersectionType">Appendix</a>.</p>

  <hr>

  <a id="Union"></a>
  <h3>Union</h3>

  <p>Represents a union type. A union type must have an <code>oneOf</code> keyword.</p>

  <pre><code class="json">{
    "oneOf": [{ ... }, { ... }]
}</code></pre>

  <p>All allowed properties are described at the <a href="#UnionType">Appendix</a>.</p>

  <hr>

  <a id="Reference"></a>
  <h3>Reference</h3>

  <p>Represents a reference type. A reference type points to a specific type at the definitions map. A reference type
  must have a <code>$ref</code> keyword.</p>

  <pre><code class="json">{
    "$ref": "MyType"
}</code></pre>

  <p>All allowed properties are described at the <a href="#ReferenceType">Appendix</a>.</p>

  <hr>

  <a id="Generic"></a>
  <h3>Generic</h3>

  <p>Represents a generic type. A generic type represents a type which can be replaced if you reference a specific type.
  A generic type must have a <code>$generic</code> keyword.</p>

  <pre><code class="json">{
    "$generic": "T"
}</code></pre>

  <p>All allowed properties are described at the <a href="#GenericType">Appendix</a>.</p>

  <p>I.e. if we reference a specific type and this type contains a generic type then we can define which type should
  be inserted at the generic type.</p>

  <pre><code class="json">{
    "$ref": "MyType",
    "$template": {
        "T": "AnotherType"
    }
}</code></pre>

  <hr>

  <a id="Structure"></a>
  <h3>Structure</h3>

  <p>The following image shows how the types can be nested.</p>

  <a href="<?php echo $base; ?>/img/typeschema_structure.png"><img src="<?php echo $base; ?>/img/typeschema_structure.png" class="img-fluid" alt="TypeSchema structure"></a>

  <hr>

  <a id="Appendix"></a>
  <h2>Appendix</h2>

  <p>The single source of truth of TypeSchema is the TypeSchema meta schema which describes itself. You can find the
  current TypeSchema at our <a href="https://github.com/apioo/typeschema/blob/master/schema/schema.json">repository</a>.
  The following section contains a HTML representation which we automatically generate from this meta schema.</p>

  <?php echo $spec; ?>

  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/src/Website/resource/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<script>window.addEventListener('load', function() { hljs.highlightAll() });</script>

<script>
  const links = document.querySelectorAll('a.psx-type-link');
  links.forEach((link) => {
    link.setAttribute('href', '#' + link.dataset.name);
  });
</script>

<?php include __DIR__ . '/inc/footer.php'; ?>
