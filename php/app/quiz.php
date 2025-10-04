<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quiz</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body class="has-bg" style="--bg-image: url('assets/<?= getBackgroundForLanguage() ?>');">
<div class="container">
  <div class="card quiz-card">
    <div class="header">
      <div class="logo">🎲</div>
      <h2>Quiz (<?= htmlspecialchars(currentLanguage()) ?>)</h2>
    </div>

<?php
$lang = currentLanguage();
if (isAllLanguages()) {
    $stmt = $pdo->query("SELECT * FROM vocab ORDER BY RAND() LIMIT 1");
} else {
    $stmt = $pdo->prepare("SELECT * FROM vocab WHERE language = ? ORDER BY RAND() LIMIT 1");
    $stmt->execute([$lang]);
}
$row = $stmt->fetch();

if (!$row) {
    echo "<p>Keine Vokabeln gefunden!</p><a class='btn' href='add.php'>Vokabel hinzufügen</a>";
} else {
    $frageTyp = rand(0, 1);
    $frage = $frageTyp === 0
        ? "Übersetze dieses Wort: <b class='quiz-word'>{$row['word']}</b>"
        : "Wie heißt das Fremdwort für: <b class='quiz-word'>{$row['translation']}</b>";
    $antwort = $frageTyp === 0 ? $row['translation'] : $row['word'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $ok = (strtolower(trim($_POST['user'])) === strtolower(trim($_POST['antwort'])));
        echo $ok
            ? "<div class='feedback ok'>🌟 Richtig!</div>"
            : "<div class='feedback bad'>❌ Falsch! Richtige Antwort: <b>{$_POST['antwort']}</b></div>";
    }

    echo "<p><span class='badge'>{$row['language']}</span> $frage</p>";
?>
    <form method="post" class="form-grid">
      <input type="hidden" name="antwort" value="<?= htmlspecialchars($antwort) ?>">
      <input type="text" name="user" placeholder="Antwort ..." required autofocus>
      <button class="btn ok" type="submit">Prüfen ✅</button>
      <a class="btn secondary" href="quiz.php">Neue Frage 🔄</a>
      <a class="btn accent" href="index.php">🏠 Start</a>
    </form>
<?php } ?>
  </div>
</div>
</body>
</html>
