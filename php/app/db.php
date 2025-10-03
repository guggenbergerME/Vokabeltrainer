<?php
$host = getenv("MYSQL_HOST") ?: "db";
$db   = getenv("MYSQL_DATABASE") ?: "vokabeltrainer";
$user = getenv("MYSQL_USER") ?: "vokabel";
$pass = getenv("MYSQL_PASSWORD") ?: "geheim";
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    die("DB-Verbindung fehlgeschlagen: " . htmlspecialchars($e->getMessage()));
}
