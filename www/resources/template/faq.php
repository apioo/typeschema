
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / FAQ</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">FAQ</h1>

  <hr>
  <h3>What is the history?</h3>
  <p>We are the developers behind <a href="https://github.com/apioo/fusio">Fusio</a> an open source API management
  system. We wanted to build an SDK generator for different languages, which builds an SDK based on the
  available schema. During this we have experienced the limitations of JSON Schema for code generators. Because of this
  we have started to develop TypeSchema. A JSON format which can be easily transformed into code and also other
  specification formats.</p>

  <hr>
  <h3>What is your vision?</h3>
  <p>We envision a future where the code generation ecosystem just works. That means a user gets an TypeAPI document and
  he is able to use this document to generate high quality code for either client or server implementations.</p>

  <hr>
  <h3>How does the website work?</h3>
  <p>The complete website is also opensource, you can check out our <a href="https://github.com/apioo/typeschema">repository</a>
  and take a look at the www folder, there is all code related to the website placed. If you want to take a look at the
  code generator you can check out the <a href="https://github.com/apioo/typeschema-generator">generator repository</a>.</p>

  <hr>
  <h3>I have a question regarding the project?</h3>
  <p>You can <a href="https://www.apioo.de/en/contact">contact us</a> directly in case you have a question regarding
  the project, or you can also take a look at our <a href="https://github.com/apioo/typeschema">repository</a>.</p>

  <hr>
  <h3>Where can I get more information?</h3>
  <p>In our mission to improve code generation we write articles explaining our thoughts and background regarding
  TypeSchema and the hole API and code generation ecosystem. If you are interested you can take a look at the following
  articles:</p>
  <ul>
    <li><a href="https://chriskapp.medium.com/typeschema-code-generation-explained-82ac90e5bd4e">TypeSchema code generation explained</a></li>
    <li><a href="https://chriskapp.medium.com/the-benefits-of-code-generation-and-the-problems-of-the-openapi-spec-ec8d75669e04">The benefits of code generation and the problems of the OpenAPI spec</a></li>
    <li><a href="https://chriskapp.medium.com/discussion-about-json-payloads-and-code-generation-8d60bc8fd94e">Discussion about JSON payloads and code generation</a></li>
    <li><a href="https://chriskapp.medium.com/typeschema-an-alternative-to-jsonschema-bdc99f3e3f43">TypeSchema an alternative to JsonSchema</a></li>
  </ul>

  <hr>
  <h3>What is the difference to JSON Schema?</h3>

  <p>JSON Schema is a <a href="https://modern-json-schema.com/json-schema-is-a-constraint-system">constraint system</a>
  which is designed to validate JSON data. Such a constraint system is not great for code generation, with TypeSchema
  our focus is to model data to be able to generate high quality code.</p>

  <p>For code generators it is difficult to work with JSON Schema since it is designed to validate JSON data. In JSON
  Schema you dont need to provide any keywords i.e. <code>{}</code> is a valid JSON Schema which basically allows every
  value and the defined keywords are applied based on the actual data. This means you can interpret a schema only if you
  have also the actual data. A code generator on the other hand needs to determine a concrete type of a schema without
  the actual data.</p>
    
  <p>JSON Schema has many keywords which contain logic like <code>dependencies</code>, <code>not</code>,
  <code>if/then/else</code> which are basically not needed for code generators and really complicates building them. We
  have also explained some pitfalls in our
  <a href="https://github.com/apioo/typeschema/blob/master/migration.md">migration document</a>.</p>

  <p>TypeSchema does not work with JSON pointer. In TypeSchema you reference every type simply by the name i.e.
  <code>Student</code>. In JSON Schema you need to provide the path i.e. <code>#/definitions/Student</code> to the
  schema. In TypeSchema you can also reference only local types. If you want to import a remote schema you need to
  explicit declare it via <code>$import</code>.</p>

  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/resources/template/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
