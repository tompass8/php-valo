<?php
session_start();
require 'db.php';

// Vérif connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$id = $_SESSION['user_id'];

// 1. Récupération User
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) die("Erreur : Agent introuvable.");

// 2. Récupération Succès
$stmtSucces = $pdo->query("SELECT * FROM achievements");
$succes = $stmtSucces->fetchAll();

// Configuration de la page
$page_title = "Dossier Agent - " . htmlspecialchars($user['pseudo']);
$page_css = "profil"; // Charge assets/css/profil.css

include 'templates/header.php';
?>

    <div class="profil-container">

        <h1 class="agent-title">
            AGENT : <span style="color: white;"><?= htmlspecialchars($user['pseudo']) ?></span>
        </h1>

        <div class="profile-grid">

            <div class="card-dossier">
                <h2>// DOSSIER PERSONNEL</h2>
                <p><strong>Matricule :</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Temps de service :</strong> <?= rand(50, 5000) ?> H</p>
                <p><strong>Dernière connexion :</strong> <?= date('d/m/Y H:i') ?></p>
            </div>

            <div class="card-dossier">
                <h2>// MÉDAILLES & SUCCÈS</h2>

                <div class="achievements-grid">
                    <?php if ($succes): ?>
                        <?php foreach ($succes as $s): ?>
                            <div class="achievement-item">
                                <?php if (!empty($s['image'])): ?>
                                    <img src="assets/img/achievements/<?= htmlspecialchars($s['image']) ?>"
                                         alt="<?= htmlspecialchars($s['name']) ?>"
                                         class="achievement-icon">
                                <?php else: ?>
                                    <img src="assets/img/default_badge.png" class="achievement-icon" alt="Locked">
                                <?php endif; ?>

                                <span class="achievement-name"><?= htmlspecialchars($s['name']) ?></span>

                                <p class="achievement-desc">
                                    <?= htmlspecialchars($s['description'] ?? 'Aucune description.') ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color:#888;">Aucune médaille obtenue pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

<?php include 'templates/footer.php'; ?>