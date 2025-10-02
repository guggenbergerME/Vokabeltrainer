<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head><meta charset="UTF-8"><title>Vokabel hinzufügen</title></head>
<body>
<h2>Neue Vokabel eingeben</h2>
<form method="post">
  Fremdsprache: <input type="text" name="word" required><br>
  Deutsch: <input type="text" name="translation" required><br>
  <input type="submit" value="Speichern">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("INSERT INTO vocab (word, translation) VALUES (?, ?)");
    $stmt->execute([$_POST['word'], $_POST['translation']]);
    echo "<p>Vokabel gespeichert!</p>";
}
?>
<p><a href="index.php">Zurück</a></p>
</body>
</html>
