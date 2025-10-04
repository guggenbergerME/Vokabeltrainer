<?php
include 'db.php';
header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="vokabel_backup_' . date("Y-m-d_H-i-s") . '.sql"');

echo "-- Vokabeltrainer Backup\n";
echo "-- Export-Datum: " . date("Y-m-d H:i:s") . "\n\n";

$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
foreach ($tables as $table) {
    echo "-- Struktur für Tabelle `$table`\n";
    $stmt = $pdo->query("SHOW CREATE TABLE `$table`");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $row['Create Table'] . ";\n\n";
    echo "-- Daten für Tabelle `$table`\n";
    $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $data) {
        $vals = array_map(fn($v) => $v === null ? "NULL" : $pdo->quote($v), array_values($data));
        echo "INSERT INTO `$table` VALUES(" . implode(",", $vals) . ");\n";
    }
    echo "\n\n";
}
