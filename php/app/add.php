<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Neue Vokabel</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body class="has-bg" style="--bg-image: url('assets/<?= getBackgroundForLanguage() ?>');">
<div class="container">
  <div class="card">
    <div class="header">
      <div class="logo">📜</div>
      <h2>Neue Vokabel hinzufügen</h2>
    </div>
    <p>Aktuelle Sprache: <b><?= htmlspecialchars(currentLanguage()) ?></b></p>
    <form method="post" class="form-grid">
      <div>
        <label>Fremdsprache</label>
        <input type="text" name="word" required>
      </div>
      <div>
        <label>Deutsch</label>
        <input type="text" name="translation" required>
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
    $lang = currentLanguage();

    $check = $pdo->prepare("SELECT COUNT(*) FROM vocab WHERE word = ? AND language = ?");
    $check->execute([$word, $lang]);
    $exists = $check->fetchColumn();

    if ($exists > 0) {
        echo "<div class='feedback bad'>❌ Die Vokabel <b>$word</b> gibt es in <b>$lang</b> schon!</div>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO vocab (word, translation, language) VALUES (?, ?, ?)");
        $stmt->execute([$word, $translation, $lang]);
        echo "<div class='feedback ok'>🎉 Gespeichert in <b>$lang</b>!</div>";
    }
}
?>
  </div>
</div>
</body>
</html>
