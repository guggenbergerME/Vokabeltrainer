<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Vokabel hinzufügen – Vokabel-Abenteuer</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">
</head>
<body class="has-bg" style="--bg-image: url('assets/bg_greece.jpg');">
  <div class="container">
    <div class="card">
      <div class="header">
        <div class="logo">📜</div>
        <h2>Neue Vokabel eintragen</h2>
      </div>

      <form method="post" class="form-grid" autocomplete="off">
        <div>
          <label for="word">Fremdsprache</label>
          <input type="text" id="word" name="word" placeholder="z. B. <hello>" required>
        </div>
        <div>
          <label for="translation">Deutsch</label>
          <input type="text" id="translation" name="translation" placeholder="z. B. Hallo" required>
        </div>
        <div>
          <button class="btn" type="submit">✅ Speichern</button>
          <a class="btn secondary" href="index.php">🏠 Start</a>
        </div>
      </form>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $word = trim($_POST['word']);
    $translation = trim($_POST['translation']);

    // Prüfen ob die Vokabel schon existiert
    $check = $pdo->prepare("SELECT COUNT(*) FROM vocab WHERE word = ?");
    $check->execute([$word]);
    $exists = $check->fetchColumn();

    if ($exists > 0) {
        echo "<div class='feedback bad'>❌ Die Vokabel <b>" . htmlspecialchars($word) . "</b> gibt es schon!</div>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO vocab (word, translation) VALUES (?, ?)");
        $stmt->execute([$word, $translation]);
        echo "<div class='feedback ok'>🎉 Gespeichert! Füge gleich noch eine Vokabel hinzu.</div>";
    }
}
?>

 
    </div>
  </div>
</body>
</html>
