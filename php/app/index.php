<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vokabel-Abenteuer</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">
</head>
<body class="has-bg" style="--bg-image: url('assets/<?= getBackgroundForLanguage() ?>');">
  <div class="container">
    <div class="card">
      <div class="header">
        <div class="logo">🏛️</div>
        <h1>Vokabel-Abenteuer</h1>
      </div>

      <h2>Wähle deine Sprache:</h2>
      <div class="nav">
        <a class="btn" href="?lang=Latein">🇱🇦 Latein</a>
        <a class="btn" href="?lang=Italienisch">🇮🇹 Italienisch</a>
        <a class="btn" href="?lang=Griechisch">🇬🇷 Griechisch</a>
        <a class="btn" href="?lang=Englisch">🇬🇧 Englisch</a>
        <a class="btn accent" href="?lang=Alle">🌍 Alle Sprachen</a>
      </div>

      <p>Aktuelle Sprache: <b><?= htmlspecialchars(currentLanguage()) ?></b></p>

      <div class="nav">
        <a class="btn secondary" href="add.php">➕ Neue Vokabel</a>
        <a class="btn accent" href="list.php">📚 Vokabelliste</a>
        <a class="btn" href="quiz.php">🎲 Quiz starten</a>
        <a class="btn" href="export.php">💾 Backup herunterladen</a>
        <a class="btn" href="import.php">📥 Vokabeln importieren</a>
      </div>
    </div>
  </div>
</body>
</html>
