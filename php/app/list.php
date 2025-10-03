<?php 
include 'db.php';

// Prüfen ob eine Lösch-Aktion angefordert wurde
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM vocab WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Vokabelliste – Vokabel-Abenteuer</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">
  <style>
    /* Popup Overlay */
    .overlay {
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.6);
      display: flex; justify-content:center; align-items:center;
      visibility: hidden; opacity:0;
      transition: opacity .2s ease;
      z-index: 1000;
    }
    .overlay.show { visibility: visible; opacity:1; }
    .popup {
      background: white; border-radius: 20px; padding: 20px;
      max-width: 320px; text-align:center;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      animation: pop .2s ease;
    }
    @keyframes pop { from{ transform:scale(.8)} to{transform:scale(1)} }
    .popup h3 { margin: 0 0 12px }
    .popup .btn { margin: 6px }
  </style>
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
          <tr>
            <th>Fremdsprache</th>
            <th>Deutsch</th>
            <th>Aktion</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($pdo->query("SELECT id, word, translation FROM vocab ORDER BY word ASC") as $row) {
              $id = (int)$row['id'];
              $w = htmlspecialchars($row['word'], ENT_QUOTES, 'UTF-8');
              $t = htmlspecialchars($row['translation'], ENT_QUOTES, 'UTF-8');
              echo "<tr>
                      <td>$w</td>
                      <td>$t</td>
                      <td>
                        <button class='btn bad small delete-btn' data-id='$id' data-word='$w'>❌ Löschen</button>
                      </td>
                    </tr>";
          }
          ?>
        </tbody>
      </table>

      <p class="footer-note">Tipp: Tippe in die Suche, um die Liste zu filtern. Einzelne Vokabeln kannst du mit ❌ entfernen.</p>
      <div class="nav">
        <a class="btn" href="index.php">🏠 Start</a>
      </div>
    </div>
  </div>

  <!-- Popup Overlay -->
  <div class="overlay" id="overlay">
    <div class="popup">
      <h3 id="popup-text">Soll diese Vokabel gelöscht werden?</h3>
      <div>
        <a href="#" id="confirm-delete" class="btn bad">Ja, löschen</a>
        <button id="cancel" class="btn secondary">Abbrechen</button>
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

    // Popup-Logik
    const overlay = document.getElementById('overlay');
    const popupText = document.getElementById('popup-text');
    const confirmLink = document.getElementById('confirm-delete');
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        const word = btn.dataset.word;
        popupText.innerHTML = "Willst du <b>" + word + "</b> wirklich löschen?";
        confirmLink.href = "list.php?delete=" + id;
        overlay.classList.add('show');
      });
    });
    document.getElementById('cancel').addEventListener('click', () => {
      overlay.classList.remove('show');
    });
  </script>
</body>
</html>
