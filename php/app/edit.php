<?php
include 'db.php';

// ID aus der URL holen
$id = intval($_GET['id'] ?? 0);

// Vokabel abrufen
$stmt = $pdo->prepare("SELECT * FROM vocab WHERE id = ?");
$stmt->execute([$id]);
$vocab = $stmt->fetch();

if (!$vocab) {
    die("<h2 style='color:red; font-family:sans-serif;'>❌ Vokabel nicht gefunden.</h2>");
}

$msg = "";

// ✅ Nur ausführen, wenn das Formular tatsächlich gesendet wurde
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['word'], $_POST['translation'], $_POST['language'])) {

    $word = trim((string)$_POST['word']);
    $translation = trim((string)$_POST['translation']);
    $language = trim((string)$_POST['language']);

    // Prüfen, ob diese Kombination schon existiert
    $check = $pdo->prepare("SELECT COUNT(*) FROM vocab WHERE word = ? AND language = ? AND id != ?");
    $check->execute([$word, $language, $id]);
    if ($check->fetchColumn() > 0) {
        $msg = "❌ Diese Vokabel existiert in dieser Sprache bereits.";
    } else {
        $upd = $pdo->prepare("UPDATE vocab SET word=?, translation=?, language=? WHERE id=?");
        $upd->execute([$word, $translation, $language, $id]);
        header("Location: list.php?updated=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Vokabel bearbeiten</title>
<link rel="stylesheet" href="styles.css">
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">
</head>
<body class="has-bg" style="--bg-image: url('assets/<?= getBackgroundForLanguage() ?>');">

<div class="container">
  <div class="card">
    <div class="header">
      <div class="logo">✏️</div>
      <h2>Vokabel bearbeiten</h2>
    </div>

    <?php if ($msg): ?>
      <div class="feedback bad"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form method="post" class="form-grid">

      <div>
        <label for="language">🌍 Sprache</label>
        <select name="language" id="language" required>
          <?php
          $languages = ["Latein", "Italienisch", "Griechisch", "Englisch"];
          foreach ($languages as $langOption) {
              $sel = ($vocab['language'] === $langOption) ? "selected" : "";
              echo "<option value='$langOption' $sel>$langOption</option>";
          }
          ?>
        </select>
      </div>

      <div>
        <label for="word">📖 Fremdsprache</label>
        <input type="text" name="word" id="word" value="<?= htmlspecialchars($vocab['word']) ?>" required>
      </div>

      <div>
        <label for="translation">🇩🇪 Deutsch</label>
        <input type="text" name="translation" id="translation" value="<?= htmlspecialchars($vocab['translation']) ?>" required>
      </div>

      <div style="margin-top:15px;">
        <button class="btn ok" type="submit">💾 Änderungen speichern</button>
        <a class="btn secondary" href="list.php">⬅️ Zurück zur Liste</a>
      </div>

    </form>
  </div>
</div>
</body>
</html>
