<?php
require_once __DIR__.'/lib/db.php';
$id = (int)($_GET['id'] ?? 0);
$pdo = db();
$stmt = $pdo->prepare("SELECT * FROM templates WHERE id=?");
$stmt->execute([$id]);
$tpl = $stmt->fetch();
if (!$tpl) die("Not found");

$zipPath = __DIR__."/data/template_$id.zip";
$zip = new ZipArchive();
$zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

$html = '<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Template '.$id.'</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="public/style.css">
  </head>
  <body class="bg-body-tertiary">'.$tpl['html'].'</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>';

$zip->addFromString("index.html", $html);
$zip->addFromString("styles.css", $tpl['css']);
$zip->close();

header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename=template_$id.zip");
readfile($zipPath);
