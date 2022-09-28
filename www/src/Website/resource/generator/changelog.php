
<?php include __DIR__ . '/../inc/header.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>">TypeSchema</a> / Changelog</li>
  </ol>
</nav>

<div class="container">
  <h1 class="display-4">Changelog</h1>
  <div class="alert alert-info" role="alert">
    Through this form you can generate a changelog between two TypeSchema versions
  </div>
  <form method="post">
  <div class="row">
    <div class="col-6">
      <div class="form-group">
        <label for="left">Left</label>
        <textarea id="left" name="left" rows="18" class="form-control"><?php echo htmlspecialchars($left); ?></textarea>
      </div>
    </div>
    <div class="col-6">
      <div class="form-group">
        <label for="right">Right</label>
        <textarea id="right" name="right" rows="18" class="form-control"><?php echo htmlspecialchars($right); ?></textarea>
      </div>
    </div>
  </div>
  <input type="submit" value="Generate" class="btn btn-primary">
  </form>
  <div class="row">
    <div class="col-12">
      <br>
      <div class="alert alert-primary">
      <ul>
        <?php foreach ($messages as $row): ?>
        <?php if ($row[0] === \PSX\Schema\Inspector\SemVer::MAJOR): ?>
        <li>[MAJOR]: <?php echo $row[1]; ?></li>
        <?php elseif ($row[0] === \PSX\Schema\Inspector\SemVer::MINOR): ?>
        <li>[MINOR]: <?php echo $row[1]; ?></li>
        <?php elseif ($row[0] === \PSX\Schema\Inspector\SemVer::PATCH): ?>
        <li>[PATCH]: <?php echo $row[1]; ?></li>
        <?php endif; ?>
        <?php endforeach; ?>
      </ul>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
