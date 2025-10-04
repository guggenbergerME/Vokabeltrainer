<?php
include 'db.php';

/* ---------------------------------------------------------
   1️⃣ Löschaktion (immer ganz oben, bevor HTML beginnt)
---------------------------------------------------------- */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $pdo->prepare("DELETE FROM vocab WHERE id=?")->execute([$id]);
    }
    header("Location: list.php");
    exit;
}

/* ---------------------------------------------------------
   2️⃣ Daten abrufen
---------------------------------------------------------- */
$lang = currentLanguage();
if (isAllLanguages()) {
    $stmt = $pdo->query("SELECT id, word, translation, language FROM vocab ORDER BY language, word");
} else {
    $stmt = $pdo->prepare("SELECT id, word, translation, language FROM vocab WHERE language = ? ORDER BY word");
    $stmt->execute([$lang]);
}
$vocabList = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vokabelliste</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">
  <script>
    // 🔍 Clientseitige Suchfunktion (JavaScript)
    document.addEventListener("DOMContentLoaded", () => {
      const searchInput = document.getElementById("search");
      const rows = document.querySelectorAll("#vocab-table tbody tr");

      searchInput.addEventListener("input", () => {
        const q = searchInput.value.toLowerCase();
        rows.forEach(tr => {
          const text = tr.innerText.toLowerCase();
          tr.style.display = text.includes(q) ? "" : "none";
        });
      });
    });
  </script>
</head>
<body class="has-bg" style="--bg-image: url('assets/<?= getBackgroundForLanguage() ?>');">
  <div class="container">
    <div class="card">
      <div class="header">
        <div class="logo">📚</div>
        <h2>Vokabelliste (<?= htmlspecialchars(currentLanguage()) ?>)</h2>
      </div>

      <!-- Suchfeld -->
      <div class="search-row">
        <label for="search">🔎 Suche:</label>
        <input type="text" id="search" placeholder="Wort oder Übersetzung …">
        <a class="btn secondary" href="add.php">➕ Neue Vokabel</a>
        <a class="btn accent" href="quiz.php">🎲 Quiz</a>
        <a class="btn" href="print.php" target="_blank">🖨️ Drucken</a>
        <a class="btn" href="index.php">🏠 Start</a>
      </div>

      <!-- Tabelle -->
      <table id="vocab-table">
        <thead>
          <tr>
            <th>Sprache</th>
            <th>Fremdsprache</th>
            <th>Deutsch</th>
            <th>Aktion</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($vocabList) === 0): ?>
            <tr><td colspan="4">😅 Keine Vokabeln gefunden.</td></tr>
          <?php else: ?>
            <?php foreach ($vocabList as $row): ?>
              <tr>
                <td><?= htmlspecialchars($row['language']) ?></td>
                <td><?= htmlspecialchars($row['word']) ?></td>
                <td><?= htmlspecialchars($row['translation']) ?></td>
                <td>
                  <a class="btn small" href="edit.php?id=<?= $row['id'] ?>">✏️</a>
                  <a class="btn bad small"
                     href="list.php?delete=<?= $row['id'] ?>"
                     onclick="return confirm('Willst du <?= htmlspecialchars($row['word']) ?> wirklich löschen?')">❌</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>

      <p class="footer-note">Tipp: Tippe in die Suche, um die Liste zu filtern.</p>
    </div>
  </div>
</body>
</html>
