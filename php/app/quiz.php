<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Quiz – Vokabel-Abenteuer</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">
</head>
<body class="has-bg" style="--bg-image: url('assets/bg_greece.jpg');">
  <div class="container">
    <div class="card quiz-card">
      <div class="header">
        <div class="logo">🎲</div>
        <h2>Quiz – Übersetze wie ein Gelehrter!</h2>
      </div>

      <?php
      // neue Frage vorbereiten (immer, auch wenn POST -> Ergebnis anzeigen + neue Frage)
      $row = $pdo->query("SELECT * FROM vocab ORDER BY RAND() LIMIT 1")->fetch(PDO::FETCH_ASSOC);
      if (!$row) {
          echo "<p>😅 Noch keine Vokabeln vorhanden. Lege welche an!</p><a class='btn' href='add.php'>➕ Vokabel eingeben</a>";
      } else {
          $frageTyp = rand(0, 1);
          $frage = $frageTyp === 0
              ? "Übersetze dieses Wort: <b class='quiz-word'>".htmlspecialchars($row['word'])."</b>"
              : "Wie heißt das Fremdwort für: <b class='quiz-word'>".htmlspecialchars($row['translation'])."</b>";
          $antwort = $frageTyp === 0 ? $row['translation'] : $row['word'];
      ?>

      <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <?php
          $ok = (mb_strtolower(trim($_POST['user'] ?? "")) === mb_strtolower(trim($_POST['antwort'] ?? "")));
          if ($ok) {
            echo "<div class='feedback ok'>🌟 Richtig! Weiter so, Sprach-Heldin/Sprach-Held!</div>";
          } else {
            $corr = htmlspecialchars($_POST['antwort'] ?? "", ENT_QUOTES, 'UTF-8');
            echo "<div class='feedback bad'>❌ Fast! Richtig wäre: <b>$corr</b></div>";
          }
        ?>
      <?php endif; ?>

      <p><?= $frage ?></p>

      <form method="post" class="form-grid" autocomplete="off">
        <input type="hidden" name="antwort" value="<?= htmlspecialchars($antwort, ENT_QUOTES, 'UTF-8') ?>">
        <div>
          <label for="user">Deine Antwort</label>
          <input type="text" id="user" name="user" placeholder="Tippe hier …" required autofocus>
        </div>
        <div>
          <button class="btn ok" type="submit">Prüfen ✅</button>
          <a class="btn secondary" href="quiz.php">Neue Frage 🔄</a>
          <a class="btn accent" href="index.php">🏠 Start</a>
        </div>
      </form>

      <p class="footer-note">Tipp: Groß/Kleinschreibung egal. Versuche es schnell! ⏱️</p>

      <?php } // endif row ?>
    </div>
  </div>
</body>
</html>
