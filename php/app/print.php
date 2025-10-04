<?php
include 'db.php';
$lang = currentLanguage();

if (isAllLanguages()) {
    $stmt = $pdo->query("SELECT word, translation, language FROM vocab ORDER BY language, word");
} else {
    $stmt = $pdo->prepare("SELECT word, translation, language FROM vocab WHERE language = ? ORDER BY word");
    $stmt->execute([$lang]);
}
$vocabList = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Vokabeln drucken – <?= htmlspecialchars($lang) ?></title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Crimson+Text&display=swap');
  body {
    font-family: "Crimson Text", serif;
    background: url('assets/pergament.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #3b2f1e;
    margin: 40px;
  }
  h1 {
    text-align: center;
    font-family: "Cinzel", serif;
    color: #4a3b24;
    border-bottom: 3px double #a67c00;
    padding-bottom: 8px;
    margin-bottom: 20px;
  }
  table {
    border-collapse: collapse;
    width: 100%;
    font-size: 18px;
  }
  th, td {
    border: 2px solid #a67c00;
    padding: 8px 12px;
  }
  th {
    background: rgba(255,245,200,0.8);
    font-family: "Cinzel", serif;
  }
  tr:nth-child(even) {
    background: rgba(255,255,240,0.6);
  }
  .noprint {
    text-align: center;
    margin-bottom: 20px;
  }
  button {
    background: #a67c00;
    color: white;
    font-size: 16px;
    padding: 8px 18px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
  }
  @media print { .noprint { display: none; } }
</style>
</head>
<body>
<div class="noprint">
  <button onclick="window.print()">🖨️ Jetzt drucken</button>
  <a href="list.php" style="margin-left:10px;">⬅️ Zurück</a>
</div>

<h1>📜 Vokabeln – <?= htmlspecialchars($lang === 'Alle' ? 'Alle Sprachen' : $lang) ?></h1>
<table>
  <thead>
    <tr>
      <th>Sprache</th><th>Fremdsprache</th><th>Deutsch</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!$vocabList): ?>
      <tr><td colspan="3">Keine Vokabeln gefunden.</td></tr>
    <?php else: ?>
      <?php foreach ($vocabList as $row): ?>
      <tr>
        <td><?= htmlspecialchars($row['language']) ?></td>
        <td><?= htmlspecialchars($row['word']) ?></td>
        <td><?= htmlspecialchars($row['translation']) ?></td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
</body>
</html>
