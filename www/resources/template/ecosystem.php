
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Ecosystem</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">Ecosystem</h1>
  <p class="lead">The following page lists integrations, libraries and other projects related to TypeSchema.</p>

  <!--
  <h2>Model</h2>
  <p>We provide auto-generated models of the TypeSchema specification which can be used to parse or generate a JSON TypeSchema specification.</p>
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
      <td><a href="">Nuget</a></td>
    </tr>
    <tr>
      <td>Java</td>
      <td><a href="https://github.com/apioo/typeschema-model-java">GitHub</a></td>
      <td><a href="">Maven</a></td>
    </tr>
    <tr>
      <td>PHP</td>
      <td><a href="https://github.com/apioo/typeschema-model-php">GitHub</a></td>
      <td><a href="">Packagist</a></td>
    </tr>
    <tr>
      <td>Python</td>
      <td><a href="https://github.com/apioo/typeschema-model-python">GitHub</a></td>
      <td><a href="">PyPI</a></td>
    </tr>
    <tr>
      <td>TypeScript</td>
      <td><a href="https://github.com/apioo/typeschema-model-typescript">GitHub</a></td>
      <td><a href="">NPM</a></td>
    </tr>
    </tbody>
  </table>
  -->

  <h2>Integration</h2>
  <p></p>
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

  <h2>Library</h2>
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
      <td><a href="https://github.com/apioo/psx-schema">psx-schema</a></td>
      <td>A PHP library to parse and validate TypeSchema specifications</td>
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
