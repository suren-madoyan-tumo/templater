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

$html = "<!doctype html><html><head><meta charset='utf-8'>
<link href='https://cdn.jsdelivr.net/npm/[email protected]/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='styles.css' rel='stylesheet'>
<title>Template $id</title></head><body class='bg-body-tertiary'>".$tpl['html']."</body></html>";

$zip->addFromString("index.html", $html);
$zip->addFromString("styles.css", $tpl['css']);
$zip->close();

header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename=template_$id.zip");
readfile($zipPath);
