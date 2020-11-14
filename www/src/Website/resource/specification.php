
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Specification</li>
  </ol>
</nav>

<div class="container">

  <h1>Specification</h1>

  <p>In TypeSchema our main specification is the <a href="https://github.com/apioo/typeschema/blob/master/schema/schema.json">TypeSchema</a>
  meta schema which describes itself. This is a HTML representation which we
  automatically generate from this meta schema. There is also a <a href="https://github.com/apioo/typeschema/blob/master/schema/schema.ts">TypeScript</a>
  version of the specification.</p>

  <hr>

  <?php echo $spec; ?>

</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
