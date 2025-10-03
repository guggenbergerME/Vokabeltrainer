<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Vokabelliste – Vokabel-Abenteuer</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">
</head>
<body class="has-bg" style="--bg-image: url('assets/bg_rome.jpg');">
  <div class="container">
    <div class="card">
      <div class="header">
        <div class="logo">📚</div>
        <h2>Deine Vokabelliste</h2>
      </div>

      <div class="search-row">
        <label for="search">🔎 Suchen:</label>
        <input type="text" id="search" placeholder="Wort oder Übersetzung …">
        <a class="btn secondary" href="add.php">➕ Neue Vokabel</a>
        <a class="btn accent" href="quiz.php">🎲 Quiz</a>
      </div>

      <table id="vocab-table">
        <thead>
          <tr><th>Fremdsprache</th><th>Deutsch</th></tr>
        </thead>
        <tbody>
          <?php
          foreach ($pdo->query("SELECT word, translation FROM vocab ORDER BY word ASC") as $row) {
              $w = htmlspecialchars($row['word'], ENT_QUOTES, 'UTF-8');
              $t = htmlspecialchars($row['translation'], ENT_QUOTES, 'UTF-8');
              echo "<tr><td>$w</td><td>$t</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <p class="footer-note">Tipp: Tippe in die Suche, um die Liste zu filtern.</p>
      <div class="nav">
        <a class="btn" href="index.php">🏠 Start</a>
      </div>
    </div>
  </div>

  <script>
    const search = document.getElementById('search');
    const rows = Array.from(document.querySelectorAll('#vocab-table tbody tr'));
    search.addEventListener('input', () => {
      const q = search.value.toLowerCase();
      rows.forEach(tr => {
        const text = tr.innerText.toLowerCase();
        tr.style.display = text.includes(q) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
