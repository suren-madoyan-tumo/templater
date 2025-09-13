<?php
// lib/db.php
function db() {
	static $pdo = null;
	if ($pdo) return $pdo;

	$host = '127.0.0.1';
	$port = '8889';         // MAMP default (check yours!)
	$db   = 'aitemplates';
	$user = 'root';
	$pass = 'root';
	$dsn  = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

	$pdo = new PDO($dsn, $user, $pass, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	]);
	return $pdo;
}
