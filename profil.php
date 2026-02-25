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

        <div class="achievements-grid">
            <div class="badge-valo">PREMIER SANG</div>
            <div class="badge-valo">MVP</div>
            <div class="badge-valo">CLUTCH KING</div>
        </div>
    </div>

<div class="achievements">
    <h3>Mes Jeux</h3>
    <div class="game-grid">

        <div class="game-card">
            <div class="card-banner">
                <div class="card-tag">VALORANT</div>
                <div style="background: #444; width:100%; height:100%;"></div>
            </div>
            <div class="card-content">
                <h4>AGENT : BAN</h4>
                <div class="card-stats">
                    <div class="stat-row"><span>Heures :</span> <strong>415h</strong></div>
                    <div class="stat-row"><span>Rang :</span> <strong>Diamant 2</strong></div>
                    <div class="stat-row"><span>Main :</span> <strong>Jett</strong></div>
                </div>
            </div>
        </div>

        <div class="game-card">
            <div class="card-banner">
                <div class="card-tag">CYBERPUNK</div>
                <div style="background: #555; width:100%; height:100%;"></div>
            </div>
            <div class="card-content">
                <h4>MERC : V</h4>
                <div class="card-stats">
                    <div class="stat-row"><span>Heures :</span> <strong>120h</strong></div>
                    <div class="stat-row"><span>Style :</span> <strong>Netrunner</strong></div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'templates/footer.php'; ?>


