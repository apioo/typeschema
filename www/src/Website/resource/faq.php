
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / FAQ</li>
  </ol>
</nav>

<div class="container">
  <h1>FAQ</h1>

  <h3>What is the history?</h3>

  <p>We are the developers behind <a href="https://github.com/apioo/fusio">Fusio</a>
  which is an open source API management system. We wanted to build an SDK generator
  for different languages, which builds an SDK based on the available schema.
  During this we have experienced the limitations of JSON Schema for code generators.
  Because of this we have started to develop TypeSchema. A JSON format which can
  be easily transformed into code and also other specification formats. This means
  we can also reuse any TypeSchema at an OpenAPI specification.</p>

  <h3>What is the difference to JSON Schema?</h3>

  <p>TypeSchema is not designed to validate JSON data. This means our goal is not
  to introduce many keywords to be able to validate all possible JSON data.
  Instead we focusing on describing data in an elegant and simple way.</p>

  <p>For code generators it is difficult to work with JSON Schema since it is
  designed to validate JSON data. In JSON Schema you dont need to provide any
  keywords i.e. <code>{}</code> is a valid JSON Schema which basically allows
  every value and the defined keywords are applied based on the actual data. This
  means you can interpret a schema only if you have also the actual data. A
  code generator on the other hand needs to determine a concrete type of a
  schema without the actual data.</p>
    
  <p>JSON Schema has many keywords which contain logic like
  <code>dependencies</code>, <code>not</code>, <code>if/then/else</code> which
  are basically not needed for code generators and really complicates building
  them. We have also explained some pitfalls in our
  <a href="https://github.com/apioo/typeschema/blob/master/migration.md">migration document</a>.</p>

  <p>TypeSchema does not work with JSON pointer. In TypeSchema you reference
  every type simply by the name i.e. <code>Student</code>. In JSON Schema you
  need to provide the path i.e. <code>#/definitions/Student</code> to the schema.
  In TypeSchema you can also reference only local types. If you want to import a
  remote schema you need to explicit declare it via <code>$import</code>.</p>

</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
