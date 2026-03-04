<?php
// --- 1. LOGIQUE (PHP) ---
session_start();
require '../config/db.php';
// Sécurité : Accès Admin uniquement
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit();
}

// Récupération et validation de l'ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: admin.php');
    exit();
}

// TRAITEMENT DU FORMULAIRE (Mise à jour)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On utilise 'image' pour correspondre à ta structure de BDD actuelle
    $stmt = $pdo->prepare("UPDATE games SET name=?, type=?, description=?, image=? WHERE id=?");
    $stmt->execute([
            $_POST['name'],
            $_POST['type'],
            $_POST['description'],
            $_POST['image_url'], // On garde le nom du champ POST pour la cohérence
            $id
    ]);

    header('Location: admin.php');
    exit();
}

// RÉCUPÉRATION DES DONNÉES ACTUELLES
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch();

if (!$game) {
    header('Location: admin.php');
    exit();
}

// Configuration du template
$page_title = "Modifier Mission : " . htmlspecialchars($game['name']);
$page_css = "admin";

include '../templates/header.php';?>

    <div class="add-container">
        <div class="form-card">
            <span class="subtitle">// PROTOCOLE DE MODIFICATION</span>
            <h1>MODIFIER LA MISSION</h1>

            <form method="POST">
                <div class="form-group">
                    <label>NOM DE CODE (Jeu)</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($game['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label>TYPE DE MISSION</label>
                    <input type="text" name="type" value="<?= htmlspecialchars($game['type']) ?>" required>
                </div>

                <div class="form-group">
                    <label>VISUEL TACTIQUE (URL ou Nom de fichier)</label>
                    <input type="text" name="image_url" value="<?= htmlspecialchars($game['image'] ?? $game['image_url'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>BRIEFING (Description)</label>
                    <textarea name="description"><?= htmlspecialchars($game['description']) ?></textarea>
                </div>

                <button type="submit" class="btn-submit">SAUVEGARDER LES MODIFICATIONS</button>

                <a href="admin.php" class="btn-cancel">ANNULER ET RETOURNER AU QG</a>
            </form>
        </div>
    </div>

<?php include '../templates/footer.php'; ?>
