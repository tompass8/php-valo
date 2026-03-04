<?php
// --- 1. LOGIQUE (PHP) ---
session_start();
require '../config/db.php';
// Vérif connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$id = $_SESSION['user_id'];

// Traitement du formulaire (Mise à jour)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profil'])) {
    $nouveau_genre = $_POST['genre'];
    $stmt = $pdo->prepare("UPDATE users SET genre = ? WHERE id = ?");
    $stmt->execute([$nouveau_genre, $id]);

    header("Location: profil.php");
    exit();
}

// Récupération des données
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    die("Erreur : Utilisateur introuvable.");
}

$stmtSucces = $pdo->query("SELECT * FROM achievements");
$succes = $stmtSucces->fetchAll();

// Configuration du template
$page_title = "Dossier Agent - " . htmlspecialchars($user['pseudo']);
$page_css = "profil";

include '../templates/header.php';?>

    <div class="profil-container">

        <h1 class="agent-title">
            AGENT : <span class="highlight-white"><?= htmlspecialchars($user['pseudo']) ?></span>
        </h1>

        <div class="profile-grid">

            <div class="card card-dossier">
                <h2 class="card-title">// DOSSIER PERSONNEL</h2>
                <div class="dossier-info">
                    <p><strong>Matricule (Email) :</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Temps de service (Jeu) :</strong> <?= rand(50, 5000) ?> heures</p>
                </div>
                <hr class="separator">
            </div>

            <div class="card card-achievements">
                <h2 class="card-title highlight-border">// MÉDAILLES & SUCCÈS</h2>

                <div class="achievements-grid">
                    <?php if ($succes): ?>
                        <?php foreach ($succes as $s): ?>
                            <div class="achievement-item">
                                <strong class="achievement-name"><?= htmlspecialchars($s['name']) ?></strong>
                                <p class="achievement-desc">
                                    <?= htmlspecialchars($s['description']) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-data-text">Aucun succès disponible.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

<?php include '../templates/footer.php'; ?>
