
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Specification</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">Specification</h1>

  <h2>Table of Contents</h2>
  <ul>
    <li><a href="#Introduction">Introduction</a></li>
    <li><a href="#Design">Design</a></li>
    <li><a href="#Definition-Types">Definition-Types</a>
      <ul>
        <li><a href="#Definition-Type-Struct">Struct</a></li>
        <li><a href="#Definition-Type-Map">Map</a></li>
        <li><a href="#Definition-Type-Array">Array</a></li>
      </ul>
    </li>
    <li><a href="#Property-Types">Property-Types</a>
      <ul>
        <li><a href="#Property-Type-String">String</a></li>
        <li><a href="#Property-Type-Integer">Integer</a></li>
        <li><a href="#Property-Type-Number">Number</a></li>
        <li><a href="#Property-Type-Boolean">Boolean</a></li>
        <li><a href="#Property-Type-Map">Map</a></li>
        <li><a href="#Property-Type-Array">Array</a></li>
        <li><a href="#Property-Type-Generic">Generic</a></li>
        <li><a href="#Property-Type-Reference">Reference</a></li>
      </ul>
    </li>
    <li><a href="#Import">Import</a></li>
    <li><a href="#Root">Root</a></li>
  </ul>

  <hr>

  <a id="Introduction"></a>
  <h2>Introduction</h2>

  <p>This document describes the <a href="https://app.typehub.cloud/d/typehub/typeschema">TypeSchema specification</a>.
  TypeSchema is a JSON format to model data structures. It abstracts common OOP concepts like inheritance, polymorphism and generics
  into a simple and deterministic JSON format which can be transformed into code for many different programming languages.
  The main use case of TypeSchema is to describe data models, it is not designed to validate JSON structures. A data model
  described in TypeSchema can be used as single source of truth, which can be used across many different environments.</p>

  <hr>

  <a id="Design"></a>
  <h2>Design</h2>

  <p>TypeSchema distinguishes between two types, a <a href="#Definition-Types">Definition-Type</a> and a <a href="#Property-Types">Property-Type</a>.
  A Definition-Type is an entry under the <code>definitions</code> keyword and a Property-Type can only be used inside such a Definition-Type.
  The following example illustrates how the <a href="#Definition-Types">Definition-Types</a> and <a href="#Property-Types">Property-Types</a> are nested.</p>

  <pre class="json hljs">{
    "definitions": {
        "TypeA": {
            "type": "struct",
            "properties": {
                "PropertyA": { <a href="#Property-Types">Property-Type</a> }
            }
        },
        "TypeB": {
            "type": "map",
            "schema": { <a href="#Property-Types">Property-Type</a> }
        },
        "TypeC": { <a href="#Definition-Types">Definition-Type</a> }
    },
    "root": "TypeA"
}</pre>

  <a id="Definition-Types"></a>
  <h2>Definition Types</h2>
  <p></p>

  <a id="Definition-Type-Struct"></a>
  <h3>struct</h3>
  <p>A struct represents a class/structure with a fix set of defined properties.</p>
  <pre class="json hljs">{
    "type": "struct",
    "parent": { <a href="#Property-Type-Reference">Reference-Type</a> },
    "base": true,
    "properties": {
        "PropertyA": { <a href="#Property-Types">Property-Type</a> }
    },
    "discriminator": "type",
    "mapping": {
        "CatType": "cat",
        "DogType": "dog",
    }
}</pre>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-75">
    </colgroup>
    <thead>
    <tr>
      <th>Property</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>parent</td>
      <td>Defines a parent type for this structure. Some programming languages like Go do not support the concept of an <code>extends</code>, in this case the code
      generator simply copies all properties into this structure.</td>
    </tr>
    <tr>
      <td>base</td>
      <td>Indicates whether this is a base structure, default is <code>false</code>. If <code>true</code> the structure is used a base type, this means it is not possible
      to create an instance from this structure.</td>
    </tr>
    <tr>
      <td>properties</td>
      <td>Contains a map where they key is the property name and the value must be a <a href="#Property-Types">Property-Type</a>.</td>
    </tr>
    <tr>
      <td>discriminator</td>
      <td>Optional the property name of a discriminator property. This should be only used in case this is also a base structure.</td>
    </tr>
    <tr>
      <td>mapping</td>
      <td>In case a discriminator is configured it is required to configure a mapping. The mapping is a map where the key is the type name and the value the actual discriminator type value.</td>
    </tr>
    </tbody>
  </table>

  <hr>

  <a id="Definition-Type-Map"></a>
  <h3>map</h3>
  <p>A map represents a map/dictionary with variable key/value entries of the same type.</p>
  <pre class="json hljs">{
    "type": "map",
    "schema": { <a href="#Property-Types">Property-Type</a> }
}</pre>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-75">
    </colgroup>
    <thead>
    <tr>
      <th>Property</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>schema</td>
      <td>The <a href="#Property-Types">Property-Type</a> which defines the value of the map.</td>
    </tr>
    </tbody>
  </table>

  <hr>

  <a id="Definition-Type-Array"></a>
  <h3>array</h3>
  <p>An array represents an array/list with variable entries of the same type.</p>
  <pre class="json hljs">{
    "type": "array",
    "schema": { <a href="#Property-Types">Property-Type</a> }
}</pre>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-75">
    </colgroup>
    <thead>
    <tr>
      <th>Property</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>schema</td>
      <td>The <a href="#Property-Types">Property-Type</a> which defines the entry of the array.</td>
    </tr>
    </tbody>
  </table>

  <hr>

  <a id="Property-Types"></a>
  <h2>Property Types</h2>
  <p></p>

  <a id="Property-Type-String"></a>
  <h3>string</h3>
  <pre class="json hljs">{
    "type": "string",
    "format": "date-time"
}</pre>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-75">
    </colgroup>
    <thead>
    <tr>
      <th>Property</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>format</td>
      <td>Optional describes the format of the string. Supported are the following types: <code>date</code>, <code>date-time</code> and <code>time</code>.
      A code generator may use a fitting data type to represent such a format, if not supported it should fall back to a string.</td>
    </tr>
    </tbody>
  </table>

  <hr>

  <a id="Property-Type-Integer"></a>
  <h3>integer</h3>
  <pre class="json hljs">{
    "type": "integer"
}</pre>

  <hr>

  <a id="Property-Type-Number"></a>
  <h3>number</h3>
  <pre class="json hljs">{
    "type": "number"
}</pre>

  <hr>

  <a id="Property-Type-Boolean"></a>
  <h3>boolean</h3>
  <pre class="json hljs">{
    "type": "boolean"
}</pre>

  <hr>

  <a id="Property-Type-Map"></a>
  <h3>map</h3>
  <p>A map represents a map/dictionary with variable key/value entries of the same type.
  The code generator uses the native map/dictionary type of the programming language.</p>
  <pre class="json hljs">{
    "type": "map",
    "schema": { <a href="#Property-Types">Property-Type</a> }
}</pre>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-75">
    </colgroup>
    <thead>
    <tr>
      <th>Property</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>schema</td>
      <td>The <a href="#Property-Types">Property-Type</a> which defines the value of the map.</td>
    </tr>
    </tbody>
  </table>

  <hr>

  <a id="Property-Type-Array"></a>
  <h3>array</h3>
  <p>An array represents an array/list with variable entries of the same type.
  The code generator uses the native array/list type of the programming language.</p>
  <pre class="json hljs">{
    "type": "array",
    "schema": { <a href="#Property-Types">Property-Type</a> }
}</pre>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-75">
    </colgroup>
    <thead>
    <tr>
      <th>Property</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>schema</td>
      <td>The <a href="#Property-Types">Property-Type</a> which defines the entry of the array.</td>
    </tr>
    </tbody>
  </table>

  <hr>

  <a id="Property-Type-Generic"></a>
  <h3>generic</h3>
  <pre class="json hljs">{
    "type": "generic",
    "name": "T"
}</pre>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-75">
    </colgroup>
    <thead>
    <tr>
      <th>Property</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>name</td>
      <td>The name of the generic, it is recommended to use common generic names like <code>T</code> or <code>TValue</code>. These generics
      can then be replaced on usage with a concrete type through the <code>template</code> property at a <a href="#Property-Type-Reference">reference</a>.</td>
    </tr>
    </tbody>
  </table>

  <hr>

  <a id="Property-Type-Reference"></a>
  <h3>reference</h3>
  <pre class="json hljs">{
    "type": "reference",
    "target": "TypeB",
    "template": {
        "T": "TypeC"
    }
}</pre>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-75">
    </colgroup>
    <thead>
    <tr>
      <th>Property</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>target</td>
      <td>The target type, this must be a key which is available under the <code>definitions</code> keyword.</td>
    </tr>
    <tr>
      <td>template</td>
      <td>A map where the key is the name of the generic and the value must point to a key under the <code>definitions</code> keyword.
      This can be used in case the target points to a type which contains generics, then it is possible to replace those generics
      with a concrete type. </td>
    </tr>
    </tbody>
  </table>

  <hr>

  <a id="Import"></a>
  <h2>Import</h2>
  <p>Optional it is possible to import other TypeSchema documents through the <code>import</code> keyword. It contains a map
  where the key is the namespace and the value points to a remote document. The value is a URL and a code generator should
  support at least the following schemes: <code>file</code>, <code>http</code>, <code>https</code>.</p>

  <pre><code class="json">{
    "import": {
        "MyNamespace": "file:///my_schema.json"
    }
}</code></pre>

  <p>Inside a reference it is then possible to reuse all types under the namespace which are defined at the remote document i.e.:</p>

  <pre><code class="json">{
    "type": "reference",
    "target": "MyNamespace:MyType"
}</code></pre>

  <a id="Root"></a>
  <h2>Root</h2>
  <p>In some circumstances a parse needs to know the root type of your specification, through the <code>root</code>
    keyword it is possible to define such a root type.</p>

  <pre><code class="json">{
    "definitions": {
        "TypeA": { ... }
    },
    "root": "TypeA"
}</code></pre>

  <hr>

  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/resources/template/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<script>window.addEventListener('load', function() { hljs.highlightAll() });</script>

<?php include __DIR__ . '/inc/footer.php'; ?>
