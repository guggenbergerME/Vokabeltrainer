<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head><meta charset="UTF-8"><title>Liste</title></head>
<body>
<h2>Alle Vokabeln</h2>
<table border="1">
<tr><th>Fremdsprache</th><th>Deutsch</th></tr>
<?php
foreach ($pdo->query("SELECT word, translation FROM vocab") as $row) {
    echo "<tr><td>{$row['word']}</td><td>{$row['translation']}</td></tr>";
}
?>
</table>
<p><a href="index.php">Zurück</a></p>
</body>
</html>
