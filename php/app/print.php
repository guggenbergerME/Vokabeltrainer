<?php
include 'db.php';

$lang = currentLanguage();

// Daten abrufen
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
  body {
    font-family: "Arial", sans-serif;
    margin: 40px;
    background: #fff;
    color: #222;
  }
  h1 {
    text-align: center;
    margin-bottom: 20px;
  }
  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
  }
  th, td {
    border: 1px solid #ccc;
    padding: 8px 12px;
    text-align: left;
  }
  th {
    background: #f2f2f2;
  }
  tr:nth-child(even) {
    background: #fafafa;
  }
  .noprint {
    text-align: center;
    margin-bottom: 20px;
  }
  @media print {
    .noprint { display: none; }
  }
</style>
</head>
<body>
  <div class="noprint">
    <button onclick="window.print()" style="padding:10px 20px;font-size:16px;">🖨️ Jetzt drucken</button>
    <a href="list.php" style="margin-left:10px;">⬅️ Zurück zur Liste</a>
  </div>

  <h1>Vokabeln – <?= htmlspecialchars($lang === 'Alle' ? 'Alle Sprachen' : $lang) ?></h1>

  <table>
    <thead>
      <tr>
        <th>Sprache</th>
        <th>Fremdsprache</th>
        <th>Deutsch</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($vocabList) === 0): ?>
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
