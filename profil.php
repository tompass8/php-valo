<?php
// --- PARTIE BACK (Logique) ---
session_start();
require_once 'db.php';

// Protection de la page : redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// 1. Récupération des infos de l'Agent connecté
$stmtUser = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmtUser->execute([$userId]);
$user = $stmtUser->fetch();

// 2. Récupération des Cartes de Jeu dynamiques
// On récupère uniquement les jeux appartenant à cet utilisateur (user_id)
$stmtGames = $pdo->prepare("SELECT * FROM games WHERE user_id = ? ORDER BY id DESC");
$stmtGames->execute([$userId]);
$myGames = $stmtGames->fetchAll();

// --- PARTIE FRONT (Affichage) ---
include 'templates/header.php';
?>

    <div class="profile-container">
        <h1>Agent : <?= htmlspecialchars($user['pseudo']) ?></h1>

        <div class="stats-card">
            <h3>Infos</h3>
            <p>EMAIL : <?= htmlspecialchars($user['email']) ?></p>
            <p>SESSION ID : #<?= $user['id'] ?></p>
        </div>

        <div class="achievements">
            <h3>Succès</h3>
            <div class="achievements-grid" style="display: flex; gap: 15px; margin-top: 10px;">
                <div class="badge-valo">PREMIER SANG</div>
                <div class="badge-valo">MVP</div>
                <div class="badge-valo">CLUTCH KING</div>
            </div>
        </div>

        <div class="achievements" style="margin-top: 40px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3>Mes Cartes d'Agent</h3>
                <a href="add_game.php" class="btn-valo" style="text-decoration: none; font-size: 0.7em; padding: 8px 15px;">+ DÉPLOYER AGENT</a>
            </div>

            <div class="game-grid">
                <?php if (!empty($myGames)): ?>
                    <?php foreach ($myGames as $game): ?>
                        <div class="game-card">
                            <div class="card-banner">
                                <div class="card-tag"><?= htmlspecialchars($game['name']) ?></div>

                                <?php if (!empty($game['image_url'])): ?>
                                    <img src="assets/img/<?= htmlspecialchars($game['image_url']) ?>"
                                         alt="Agent Image"
                                         style="width:100%; height:100%; object-fit:cover; display:block;">
                                <?php else: ?>
                                    <div style="background: #222; width:100%; height:100%; display: flex; align-items: center; justify-content: center;">
                                        <span style="color: #444; font-size: 2em;">?</span>
                                    </div>
                                <?php endif; ?>

                                <a href="delete_game.php?id=<?= $game['id'] ?>"
                                   onclick="return confirm('Voulez-vous vraiment désactiver cet agent ?')"
                                   style="position:absolute; right:10px; top:10px; color:var(--valo-red); font-weight:bold; text-decoration:none; background: rgba(0,0,0,0.7); padding: 2px 8px; border-radius: 3px; z-index: 10;">
                                    X
                                </a>
                            </div>

                            <div class="card-content">
                                <h4>ID : <?= htmlspecialchars($user['pseudo']) ?></h4>
                                <div class="card-stats">
                                    <div class="stat-row">
                                        <span>Heures :</span>
                                        <strong><?= htmlspecialchars($game['hours_played']) ?>h</strong>
                                    </div>
                                    <div class="stat-row">
                                        <span>Rang :</span>
                                        <strong><?= htmlspecialchars($game['player_rank'] ?: 'UNRANKED') ?></strong>
                                    </div>
                                    <div class="stat-row">
                                        <span>Main :</span>
                                        <strong><?= htmlspecialchars($game['main_character'] ?: 'NON DÉFINI') ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="opacity: 0.5; font-style: italic;">Aucun agent n'est actuellement déployé sur le terrain.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php include 'templates/footer.php'; ?>