<?php
// --- 1. LOGIQUE (PHP) ---
session_start();
require '../config/db.php';
// Sécurité : Accès Admin uniquement
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Note : On utilise 'image' si tu as renommé ta colonne suite à l'erreur précédente
    // Sinon, remplace 'image' par 'image_url' ci-dessous
    $stmt = $pdo->prepare("INSERT INTO games (name, type, description, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([
            $_POST['name'],
            $_POST['type'],
            $_POST['description'],
            $_POST['image_url']// On garde le champ texte pour l'instant comme dans ton code
    ]);

    header('Location: admin.php');
    exit();
}

$page_title = "Nouvelle Mission - Admin";
$page_css = "admin"; // On utilise admin.css pour le style

include '../templates/header.php';?>

    <div class="add-container">
        <div class="form-card">
            <span class="subtitle">// PROTOCOLE D'AJOUT</span>
            <h1>NOUVELLE MISSION</h1>

            <form method="POST">
                <div class="form-group">
                    <label>NOM DE CODE (Jeu)</label>
                    <input type="text" name="name" required placeholder="Ex: LEAGUE OF LEGENDS">
                </div>

                <div class="form-group">
                    <label>TYPE DE MISSION</label>
                    <input type="text" name="type" required placeholder="Ex: FPS TACTIQUE, MOBA...">
                </div>

                <div class="form-group">
                    <label>VISUEL TACTIQUE (URL Image)</label>
                    <input type="text" name="image_url" placeholder="https://...">
                </div>

                <div class="form-group">
                    <label>BRIEFING (Description)</label>
                    <textarea name="description" placeholder="Détails de la mission..."></textarea>
                </div>

                <button type="submit" class="btn-submit">INITIALISER LA MISSION</button>

                <a href="admin.php" class="btn-cancel">ANNULER ET RETOURNER AU QG</a>
            </form>
        </div>
    </div>

<?php include '../templates/footer.php'; ?>
