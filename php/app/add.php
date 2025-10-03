<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $word = trim($_POST['word']);
    $translation = trim($_POST['translation']);

    // Prüfen ob die Vokabel schon existiert
    $check = $pdo->prepare("SELECT COUNT(*) FROM vocab WHERE word = ?");
    $check->execute([$word]);
    $exists = $check->fetchColumn();

    if ($exists > 0) {
        echo "<div class='feedback bad'>❌ Die Vokabel <b>" . htmlspecialchars($word) . "</b> gibt es schon!</div>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO vocab (word, translation) VALUES (?, ?)");
        $stmt->execute([$word, $translation]);
        echo "<div class='feedback ok'>🎉 Gespeichert! Füge gleich noch eine Vokabel hinzu.</div>";
    }
}
?>
