<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vokabelliste</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body class="has-bg" style="--bg-image: url('assets/<?= getBackgroundForLanguage() ?>');">
<div class="container">
  <div class="card">
    <div class="header">
      <div class="logo">📚</div>
      <h2>Vokabelliste (<?= htmlspecialchars(currentLanguage()) ?>)</h2>
    </div>

<?php
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $pdo->prepare("DELETE FROM vocab WHERE id=?")->execute([$id]);
    header("Location: list.php");
    exit;
}

$lang = currentLanguage();
if (isAllLanguages()) {
    $stmt = $pdo->query("SELECT id, word, translation, language FROM vocab ORDER BY language, word");
} else {
    $stmt = $pdo->prepare("SELECT id, word, translation, language FROM vocab WHERE language = ? ORDER BY word");
    $stmt->execute([$lang]);
}
?>

    <table id="vocab-table">
      <thead>
        <tr><th>Sprache</th><th>Fremdsprache</th><th>Deutsch</th><th>Aktion</th></tr>
      </thead>
      <tbody>
<?php foreach ($stmt as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['language']) ?></td>
          <td><?= htmlspecialchars($row['word']) ?></td>
          <td><?= htmlspecialchars($row['translation']) ?></td>
          <td><a class="btn bad small" href="list.php?delete=<?= $row['id'] ?>" onclick="return confirm('Willst du <?= htmlspecialchars($row['word']) ?> wirklich löschen?')">❌</a></td>
        </tr>
<?php endforeach; ?>
      </tbody>
    </table>

    <div class="nav">
      <a class="btn secondary" href="add.php">➕ Neue Vokabel</a>
      <a class="btn accent" href="index.php">🏠 Start</a>
    </div>
  </div>
</div>
</body>
</html>
