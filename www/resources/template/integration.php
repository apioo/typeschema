
<?php include __DIR__ . '/inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Integration</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">Integration</h1>
  <p class="lead">This list provides examples how you can work with the generated DTOs, it shows how you can read raw JSON data
    into a DTO and transform the DTO back into raw JSON data. Since the generator uses mostly standard or well-known libraries
    most developers should be familiar with this process.
  </p>
  <div class="row">
      <?php foreach ($types as $chunk): ?>
        <div class="col-6">
          <div class="list-group">
              <?php foreach ($chunk as $type => $typeTitle): ?>
                <a href="<?php echo $router->getAbsolutePath([\App\Controller\Integration::class, 'showType'], ['type' => $type]); ?>" class="list-group-item list-group-item-action"><?php echo $typeTitle; ?></a>
              <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
  </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
