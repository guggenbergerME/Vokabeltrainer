<?php
// optional: wähle hier, welches Hintergrundbild genutzt wird:
$bg = "rome"; // "rome" | "greece" | "" (leer für kein Bild)
$bgCss = "";
if ($bg === "rome")  $bgCss = "--bg-image: url('assets/bg_rome.jpg');";
if ($bg === "greece")$bgCss = "--bg-image: url('assets/bg_greece.jpg');";
$bodyClass = $bg ? "has-bg" : "";
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Vokabel-Abenteuer</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">
  <style>:root{<?= $bgCss ?>}</style>
</head>
<body class="<?= $bodyClass ?>">
  <div class="container">
    <div class="card">
      <div class="header">
        <div class="logo">🏛️</div>
        <div>
          <h1>Vokabel-Abenteuer</h1>
          <div class="small">Lerne wie die Gelehrten im alten Rom & Griechenland!</div>
        </div>
      </div>

      <div class="nav">
        <a class="btn" href="quiz.php">🎲 Quiz starten</a>
        <a class="btn secondary" href="add.php">➕ Vokabel eingeben</a>
        <a class="btn accent" href="list.php">📚 Vokabelliste</a>
      </div>

      <p style="margin-top:12px">Tipp: Spiele jeden Tag 5 Minuten. Sammle <span class="badge">richtige Antworten</span> wie Lorbeerkränze! 🏅</p>
    </div>

    <p class="footer-note">Hinweis für Lehrkräfte/Eltern: kindgerechte Schriften, hohe Kontraste, große Touch-Ziele.</p>
    <li><a href="export.php" class="btn accent">💾 Backup herunterladen</a></li>
  </div>
</body>
</html>
