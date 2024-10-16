
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / History</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">History</h1>
  <p class="lead">TypeSchema has evolved out of the need to build a solid code generator for a Swagger/OpenAPI specification.
    During this development process we have <a href="https://chriskapp.medium.com/the-benefits-of-code-generation-and-the-problems-of-the-openapi-spec-ec8d75669e04">experienced</a> <a href="https://chriskapp.medium.com/discussion-about-json-payloads-and-code-generation-8d60bc8fd94e">problems</a>
    and tried to find a way to solve them. At the beginning we had only defined some "stricter" rules for a JSON Schema to make it easier
    for code generators but over time this has evolved into a complete separate specification. TypeSchema provides a solid way
    to model JSON payload and a great code generator to automatically generate <abbr class="Data-Transfer-Objects">DTOs</abbr>
    to represent this JSON data.</p>

  <figure class="text-center">
    <blockquote class="blockquote">
      <p>If you ask yourself, why do I need a specification to model my JSON payload,<br>then there is only a simple answer: type-safety.</p>
    </blockquote>
  </figure>

  <p>If we look at the history of programming </p>

  <h2>Thought model</h2>
  <p>TypeSchema has a specific thought model which fits perfectly with classical OOP languages like Java, C#, PHP or TypeScript.
    But it supports also languages like Go, which have a different approach. In this case the generator will try to apply these concepts on
  generation so that you can still use them at the specification. For example Go does not support inheritance, in this case the code generator
  copies all inherited properties into the structure.</p>

  <ul>
    <li>TypeSchema is designed to model data structures</li>
    <li>TypeSchema abstracts OOP concepts like inheritance, polymorphism and generics</li>
    <li>TypeSchema is code-first, this means it is easy possible to generate a TypeSchema through reflection without additional annotations</li>
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
