
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Ecosystem</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">Ecosystem</h1>
  <p class="lead">The following page lists libraries, integrations and other projects related to TypeSchema.</p>

  <h2>Model</h2>
  <p>We provide auto-generated models of the TypeSchema meta specification which describes itself.
    These models can be used to parse or generate a TypeSchema specification.</p>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-25">
      <col class="w-25">
    </colgroup>
    <thead>
    <tr>
      <th>Language</th>
      <th>GitHub</th>
      <th>Package</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>C#</td>
      <td><a href="https://github.com/apioo/typeschema-model-csharp">GitHub</a></td>
      <td><a href="https://www.nuget.org/packages/TypeSchema.Model/">Nuget</a></td>
    </tr>
    <tr>
      <td>Go</td>
      <td><a href="https://github.com/apioo/typeschema-model-go">GitHub</a></td>
      <td></td>
    </tr>
    <tr>
      <td>Java</td>
      <td><a href="https://github.com/apioo/typeschema-model-java">GitHub</a></td>
      <td><a href="https://central.sonatype.com/artifact/org.typeschema/model">Maven</a></td>
    </tr>
    <tr>
      <td>JavaScript</td>
      <td><a href="https://github.com/apioo/typeschema-model-javascript">GitHub</a></td>
      <td><a href="https://www.npmjs.com/package/typeschema-model">NPM</a></td>
    </tr>
    <tr>
      <td>PHP</td>
      <td><a href="https://github.com/apioo/typeschema-model-php">GitHub</a></td>
      <td><a href="https://packagist.org/packages/typeschema/model">Packagist</a></td>
    </tr>
    <tr>
      <td>Python</td>
      <td><a href="https://github.com/apioo/typeschema-model-python">GitHub</a></td>
      <td><a href="https://pypi.org/project/typeschema-model/">PyPI</a></td>
    </tr>
    </tbody>
  </table>

  <h2>Reflection</h2>
  <p>The reflection libraries help to automatically generate a TypeSchema specification based on a class.
    These libraries use the reflection mechanism of each language to inspect the class and create the fitting
    specification.</p>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-25">
      <col class="w-25">
    </colgroup>
    <thead>
    <tr>
      <th>Language</th>
      <th>GitHub</th>
      <th>Package</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Java</td>
      <td><a href="https://github.com/apioo/typeschema-reflection-java">GitHub</a></td>
      <td><a href="https://central.sonatype.com/artifact/org.typeschema/reflection">Maven</a></td>
    </tr>
    <tr>
      <td>PHP</td>
      <td><a href="https://github.com/apioo/typeschema-reflection-php">GitHub</a></td>
      <td><a href="https://packagist.org/packages/typeschema/reflection">Packagist</a></td>
    </tr>
    </tbody>
  </table>

  <h2>Integration</h2>
  <p>To integrate the code generator you can take a look at the following options. For more advanced
    integration options you can also take a look at the <a href="https://sdkgen.app/">SDKgen</a> project.</p>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-25">
      <col class="w-25">
    </colgroup>
    <thead>
    <tr>
      <th>Name</th>
      <th>GitHub</th>
      <th>Link</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Docker</td>
      <td><a href="https://github.com/apioo/typeschema-generator">GitHub</a></td>
      <td><a href="https://hub.docker.com/r/fusio/typeschema-generator">Docker</a></td>
    </tr>
    <tr>
      <td>GitHub Action</td>
      <td><a href="https://github.com/apioo/typeschema-generator-action">GitHub</a></td>
      <td><a href="https://github.com/marketplace/actions/typeschema-code-generator">Marketplace</a></td>
    </tr>
    </tbody>
  </table>

  <h2>Frontend</h2>
  <p></p>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-50">
    </colgroup>
    <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td><a href="https://www.npmjs.com/package/ngx-typeschema-editor">ngx-typeschema-editor</a></td>
      <td>An Angular component to visual edit a TypeSchema</td>
    </tr>
    </tbody>
  </table>

  <h2>Project</h2>
  <p></p>
  <table class="table table-striped">
    <colgroup>
      <col class="w-25">
      <col class="w-50">
    </colgroup>
    <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td><a href="https://typehub.cloud/">TypeHub</a></td>
      <td>A service to manage and share TypeSchema specifications</td>
    </tr>
    <tr>
      <td><a href="https://typehub.cloud/">TypeAPI</a></td>
      <td>An OpenAPI alternative to describe REST APIs for type-safe code generation</td>
    </tr>
    <tr>
      <td><a href="https://sdkgen.app/">SDKgen</a></td>
      <td>A service to generate client SDKs</td>
    </tr>
    </tbody>
  </table>

  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/resources/template/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
