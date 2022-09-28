
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Ecosystem</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">Ecosystem</h1>
  <p>The following page should list services and libraries which are working with TypeSchema.</p>
  <h3>Services</h3>
  <ul>
    <li><a href="https://typehub.cloud/">TypeHub</a> - a service to manage and share TypeSchema specifications</li>
    <li><a href="https://sdkgen.app/">SDKgen</a> - a service to generate client SDKs</li>
    <li><a href="https://www.fusio-project.org/">Fusio</a> - an open source API management system</li>
  </ul>
  <h3>Libraries</h3>
  <ul>
    <li><a href="https://www.npmjs.com/package/ngx-typeschema-editor">ngx-typeschema-editor</a> - an Angular component to visual edit a TypeSchema</li>
    <li><a href="https://github.com/apioo/psx-schema">psx-schema</a> - a PHP library to parse and validate TypeSchema specifications</li>
  </ul>

  <div class="typeschema-edit">
    <a href="https://github.com/apioo/typeschema/blob/master/www/src/Website/resource/<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>"><i class="bi bi-pencil"></i> Edit this page</a>
  </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
