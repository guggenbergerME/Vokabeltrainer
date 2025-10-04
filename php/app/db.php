<?php
/**
 * db.php – zentrale Datenbankverbindung & Sprachsteuerung
 */

session_start();

/* Sprachwahl ------------------------------------------------------ */
if (isset($_GET['lang'])) {
    $_SESSION['language'] = $_GET['lang'];
}
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'Latein';
}

/* Datenbankverbindung --------------------------------------------- */
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
    die("<h2 style='color:red;font-family:monospace'>
        DB-Verbindung fehlgeschlagen:<br>"
        . htmlspecialchars($e->getMessage()) .
        "</h2>");
}

/* Hilfsfunktionen ------------------------------------------------- */
function currentLanguage(): string {
    return $_SESSION['language'] ?? 'Latein';
}
function isAllLanguages(): bool {
    return ($_SESSION['language'] ?? '') === 'Alle';
}
function getBackgroundForLanguage(): string {
    return match (currentLanguage()) {
        'Latein' => 'bg_rome.jpg',
        'Griechisch' => 'bg_greece.jpg',
        'Italienisch' => 'bg_italy.jpg',
        'Englisch' => 'bg_london.jpg',
        default => 'bg_welt.jpg',
    };
}
?>
