<?php
require_once __DIR__.'/lib/db.php';
require_once __DIR__.'/lib/util.php';
$pdo = db();

if (isset($_GET['id'])) {
  $stmt = $pdo->prepare("SELECT * FROM templates WHERE id=?");
  $stmt->execute([$_GET['id']]);
  $tpl = $stmt->fetch();
  if (!$tpl) { echo "Not found."; exit; }

  echo '<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Saved #'.(int)$tpl['id'].'</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <style>'.$tpl['css'].'</style></head><body class="bg-body-tertiary">';
  echo '<div class="container py-3 d-flex gap-2">
          <a class="btn btn-outline-secondary" href="view.php">&larr; Back</a>
          <a class="btn btn-outline-primary" href="export.php?id='.$tpl['id'].'">Download .zip</a>
        </div>';
  echo $tpl['html'];
  echo '
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>';
  exit;
}

$list = $pdo->query("SELECT id, created_at, JSON_EXTRACT(prompt,'$.site_type') AS st FROM templates ORDER BY id DESC")->fetchAll();
?>
'<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Saved Templates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="public/style.css">
</head>
<body class="bg-body-tertiary">
<div class="container py-4">
  <h1>Saved Templates</h1>
  <a class="btn btn-outline-secondary mb-3" href="index.php">&larr; Back</a>
  <table class="table table-striped bg-white">
    <thead><tr><th>ID</th><th>Site Type</th><th>Created</th><th></th></tr></thead>
    <tbody>
      <?php foreach($list as $row): ?>
      <tr>
        <td><?= (int)$row['id'] ?></td>
        <td><?= e(trim($row['st'], '"')) ?></td>
        <td><?= e($row['created_at']) ?></td>
        <td><a class="btn btn-sm btn-primary" href="view.php?id=<?= (int)$row['id'] ?>">Open</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>';
