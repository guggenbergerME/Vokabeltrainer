<?php
$host = getenv("MYSQL_HOST") ?: "db";
$db   = getenv("MYSQL_DATABASE") ?: "vokabeltrainer";
$user = getenv("MYSQL_USER") ?: "vokabel";
$pass = getenv("MYSQL_PASSWORD") ?: "geheim";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("DB-Verbindung fehlgeschlagen: " . $e->getMessage());
}
?>
