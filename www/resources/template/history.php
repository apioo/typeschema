
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / History</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">History</h1>
  <p class="lead">TypeSchema has evolved while developing a new Swagger/OpenAPI code generator.
    During this development process we have noticed many <a href="https://chriskapp.medium.com/discussion-about-json-payloads-and-code-generation-8d60bc8fd94e">problems</a>
    which a <a href="https://chriskapp.medium.com/the-benefits-of-code-generation-and-the-problems-of-the-openapi-spec-ec8d75669e04">code generator</a> needs to solve in
    order to generate clean code. We have tried to solve those problems and over time TypeSchema has evolved into a separate specification which describes JSON payloads
    and is optimized for code generation.</p>

  <h2>Type-safe programming languages</h2>
  <p>If we look at the history of programming languages we see a trend towards type-safety. Besides strongly typed programming languages
  like Java, C# and Go which are automatically type-safe also weakly typed languages have added support for more type-safety, like i.e.
  PHP, Python and even Ruby which have all improved and added support for type-hints, for JavaScript Microsoft has even developed
  <a href="https://www.typescriptlang.org/">TypeScript</a> which adds type-safety to JavaScript.</p>

  <p>A big reason for this trend is that type-safe applications make it easier to find or prevent bugs.
  Since at you code you always have explicit properties which you can access and in case the schema changes your will directly
  get an error, that the property no longer exist.</p>

  <p>TypeSchema can help you to build those type-safe applications by automatically generating clean DTOs to represent JSON payload.</p>

  <h2>Thought model</h2>
  <p>TypeSchema has a specific thought model which fits perfectly with classical OOP languages like Java, C#, PHP or TypeScript.
    But it supports also languages like Go, which have a different approach. In this case the generator will try to apply these concepts on
  generation so that you can still use them at the specification. For example Go does not support inheritance, in this case the code generator
  copies all inherited properties into the structure.</p>

  <ul>
    <li>TypeSchema is designed to model data structures</li>
    <li>TypeSchema abstracts OOP concepts like inheritance, polymorphism and generics</li>
    <li>TypeSchema encourages code-first, this means it is easy possible to generate a TypeSchema through reflection without additional annotations</li>
    <li>TypeSchema has no keywords to validate data</li>
  </ul>

  <h2>What is the difference to JSON Schema?</h2>
  <p>JSON Schema is a <a href="https://modern-json-schema.com/json-schema-is-a-constraint-system">constraint system</a>
    which is designed to validate JSON data. Such a constraint system is not great for code generation, with TypeSchema
    our focus is to model data to be able to generate high quality code.</p>

  <p>For code generators it is difficult to work with JSON Schema since it is designed to validate JSON data. In JSON
    Schema you dont need to provide any keywords i.e. <code>{}</code> is a valid JSON Schema which basically allows every
    value and the defined keywords are applied based on the actual data. This means you can interpret a schema only if you
    have also the actual data. A code generator on the other hand needs to determine a concrete type of a schema without
    the actual data.</p>

  <p>JSON Schema has many keywords which contain logic like <code>dependencies</code>, <code>not</code>,
    <code>if/then/else</code> which are basically not needed for code generators and really complicates building them.</p>

  <p>TypeSchema does not work with JSON pointer. In TypeSchema you reference every type simply by the name i.e.
    <code>Student</code>. In JSON Schema you need to provide the path i.e. <code>#/definitions/Student</code> to the
    schema. In TypeSchema you can also reference only local types. If you want to import a remote schema you need to
    explicit declare it via <code>import</code>.</p>

  <h2>I have a problem with the generated code?</h2>
  <p>In case there are problems with the generated code you can always create an issue at our <a href="https://github.com/apioo/typeschema">repository</a>.</p>

  <h2>I have a question regarding the project?</h2>
  <p>You can <a href="https://www.apioo.de/en/contact">contact us</a> directly in case you have a question regarding
  the project, or you can also take a look at our <a href="https://github.com/apioo/typeschema">repository</a>.</p>

  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/resources/template/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
