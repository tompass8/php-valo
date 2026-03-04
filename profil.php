<?php
// --- PARTIE BACK (Logique) ---
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Récupération des données (Code PHP pur)
$userId = $_SESSION['user_id'];
$stmtUser = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmtUser->execute([$userId]);
$user = $stmtUser->fetch();

// --- PARTIE FRONT (Affichage) ---
include 'templates/header.php';
?>

    <div class="profile-container">
        <h1>Agent : <?= htmlspecialchars($user['pseudo']) ?></h1>

        <div class="stats-card">
            <h3>Infos</h3>
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
            <p>Temps de jeu : <?= rand(10, 500) ?>h</p> </div>

        <div class="achievements">
            <h3>Succès</h3>
        </div>
    </div>

<?php include 'templates/footer.php'; ?>


