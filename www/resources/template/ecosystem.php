
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Ecosystem</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">Ecosystem</h1>
  <p>The following page lists integrations, projects and libraries related to TypeSchema.</p>
  <h3>Integration</h3>
  <ul>
    <li><a href="https://github.com/apioo/typeschema-generator">Docker</a> - The TypeSchema code generator provided as Docker-Image</li>
    <li><a href="https://github.com/apioo/typeschema-generator-action">GitHub Action</a> - The TypeSchema code generator provided as GitHub action</li>
  </ul>
  <h3>Project</h3>
  <ul>
    <li><a href="https://typeapi.org/">TypeAPI</a> - An OpenAPI alternative to describe REST APIs for type-safe code generation</li>
    <li><a href="https://typehub.cloud/">TypeHub</a> - A service to manage and share TypeSchema specifications</li>
    <li><a href="https://sdkgen.app/">SDKgen</a> - A service to generate client SDKs</li>
    <li><a href="https://www.fusio-project.org/">Fusio</a> - An open source API management system</li>
    <li><a href="https://phpsx.org/">PSX</a> - An innovative PHP framework dedicated to build fully typed REST APIs</li>
  </ul>
  <h3>Library</h3>
  <ul>
    <li><a href="https://www.npmjs.com/package/ngx-typeschema-editor">ngx-typeschema-editor</a> - an Angular component to visual edit a TypeSchema</li>
    <li><a href="https://github.com/apioo/psx-schema">psx-schema</a> - a PHP library to parse and validate TypeSchema specifications</li>
  </ul>

  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/resources/template/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
