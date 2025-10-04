<?php
include 'db.php';

/* -----------------------------------------------------------
   Vokabelstatistik abrufen
------------------------------------------------------------ */
try {
    $stmt = $pdo->query("
        SELECT language, COUNT(*) AS count
        FROM vocab
        GROUP BY language
        ORDER BY language
    ");
    $counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // z.B. ['Latein' => 25, 'Englisch' => 40, ...]
    $total = array_sum($counts);
} catch (Exception $e) {
    $counts = [];
    $total = 0;
}
?>
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
        <a class="btn" href="import.php">📥 Vokabeln importieren</a>
        <a class="btn" href="print.php" target="_blank">🖨️ Drucken</a>
      </div>

      <!-- 🧾 Statistik -->
      <div class="stats">
        <h3>📊 Aktuelle Vokabelstatistik</h3>
        <table class="stats-table">
          <thead>
            <tr><th>Sprache</th><th>Anzahl</th></tr>
          </thead>
          <tbody>
          <?php if (empty($counts)): ?>
            <tr><td colspan="2">Noch keine Vokabeln gespeichert.</td></tr>
          <?php else: ?>
            <?php foreach ($counts as $lang => $cnt): ?>
              <tr>
                <td><?= htmlspecialchars($lang) ?></td>
                <td><?= htmlspecialchars($cnt) ?></td>
              </tr>
            <?php endforeach; ?>
            <tr class="total-row">
              <td><b>Gesamt</b></td>
              <td><b><?= htmlspecialchars($total) ?></b></td>
            </tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <style>
    .stats {
      margin-top: 20px;
      text-align: center;
    }
    .stats-table {
      margin: 10px auto;
      border-collapse: collapse;
      width: 70%;
      font-size: 1.1em;
      background: rgba(255, 255, 255, 0.85);
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .stats-table th, .stats-table td {
      padding: 8px 12px;
      border-bottom: 1px solid #ddd;
    }
    .stats-table th {
      background: #ffeabf;
    }
    .stats-table tr:nth-child(even) {
      background: #fffdf5;
    }
    .total-row td {
      border-top: 2px solid #a67c00;
      background: #fff5d6;
    }
  </style>
</body>
</html>
