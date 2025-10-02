<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head><meta charset="UTF-8"><title>Quiz</title></head>
<body>
<h2>Zufallsabfrage</h2>
<?php
$row = $pdo->query("SELECT * FROM vocab ORDER BY RAND() LIMIT 1")->fetch();
$frageTyp = rand(0, 1);

if ($frageTyp === 0) {
    echo "<p>Übersetze dieses Wort: <b>{$row['word']}</b></p>";
    $antwort = $row['translation'];
} else {
    echo "<p>Wie lautet das Fremdwort für: <b>{$row['translation']}</b></p>";
    $antwort = $row['word'];
}
?>
<form method="post">
  <input type="hidden" name="antwort" value="<?= htmlspecialchars($antwort) ?>">
  Deine Antwort: <input type="text" name="user" required>
  <input type="submit" value="Prüfen">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (strtolower(trim($_POST['user'])) === strtolower(trim($_POST['antwort']))) {
        echo "<p style='color:green'>Richtig!</p>";
    } else {
        echo "<p style='color:red'>Falsch. Richtig wäre: <b>{$_POST['antwort']}</b></p>";
    }
}
?>
<p><a href="index.php">Zurück</a></p>
</body>
</html>
