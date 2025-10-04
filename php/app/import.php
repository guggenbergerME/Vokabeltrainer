<?php
include 'db.php';

/*
Fremdsprache;Deutsch;Sprache
aqua;Wasser;Latein
amicus;Freund;Latein

*/

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"]["tmp_name"];
    $handle = fopen($file, "r");
    $count = 0;
    while (($line = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if (count($line) >= 2) {
            $word = trim($line[0]);
            $translation = trim($line[1]);
            $language = $line[2] ?? currentLanguage();
            if ($word !== "" && $translation !== "") {
                $check = $pdo->prepare("SELECT COUNT(*) FROM vocab WHERE word = ? AND language = ?");
                $check->execute([$word, $language]);
                if (!$check->fetchColumn()) {
                    $stmt = $pdo->prepare("INSERT INTO vocab (word, translation, language) VALUES (?, ?, ?)");
                    $stmt->execute([$word, $translation, $language]);
                    $count++;
                }
            }
        }
    }
    fclose($handle);
    $message = "✅ $count Vokabeln importiert.";
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Vokabeln importieren</title>
<link rel="stylesheet" href="styles.css">
</head>
<body class="has-bg" style="--bg-image: url('assets/<?= getBackgroundForLanguage() ?>');">
<div class="container">
  <div class="card">
    <div class="header"><div class="logo">📥</div><h2>Vokabeln importieren</h2></div>
    <p>Sprache: <b><?= htmlspecialchars(currentLanguage()) ?></b></p>
    <?php if ($message): ?><div class="feedback ok"><?= $message ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <input type="file" name="file" accept=".csv" required>
      <button class="btn" type="submit">📂 Import starten</button>
    </form>
    <p>Erwartetes Format: <code>Fremdsprache;Deutsch;Sprache</code></p>
    <a class="btn secondary" href="index.php">🏠 Start</a>
  </div>
</div>
</body>
</html>
