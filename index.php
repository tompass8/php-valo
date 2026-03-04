<?php
// --- 1. LOGIQUE (BACKEND) ---
session_start();
require 'db.php'; // Connexion à la base de données

// On récupère la liste des jeux depuis la base de données
// On stocke le résultat dans la variable $games
$stmt = $pdo->query("SELECT * FROM games ORDER BY id DESC");
$games = $stmt->fetchAll();

// Configuration de la page
$page_title = "Accueil - Protocol Valorant";

// On inclut le header (Menu + CSS)
include 'templates/header.php';
?>

    <section class="hero">
        <p style="color: var(--val-red); font-weight: bold; letter-spacing: 2px;">// STATUT : CONNECTÉ</p>

        <h1 style="font-size: 4em; text-transform: uppercase; margin: 10px 0; line-height: 1;">
            BIENVENUE, AGENT <span style="color: white;"><?= htmlspecialchars($_SESSION['pseudo'] ?? 'INCONNU') ?></span>
        </h1>

        <p style="color: #888; font-size: 1.2em; margin-bottom: 40px;">
            Prêt à déployer ? Consultez les missions disponibles ou gérez votre profil.
        </p>

        <div style="display: flex; justify-content: center; gap: 20px;">
            <a href="profil.php" class="btn-val">MON DOSSIER</a>
            <?php if(($_SESSION['role'] ?? '') === 'admin'): ?>
                <a href="admin.php" class="btn-ghost">ADMINISTRATION</a>
            <?php endif; ?>
        </div>
    </section>

    <div class="container">
        <h2 style="border-left: 4px solid var(--val-red); padding-left: 15px; text-transform: uppercase; margin-bottom: 30px;">
            Missions Disponibles
        </h2>

        <div class="missions-grid">
            <?php if (!empty($games)): ?>
                <?php foreach ($games as $game): ?>
                    <div class="mission-card">

                        <div class="card-img-wrapper">
                            <?php if (!empty($game['image']) && file_exists('assets/img/games/' . $game['image'])): ?>
                                <img src="assets/img/games/<?= htmlspecialchars($game['image']) ?>"
                                     alt="<?= htmlspecialchars($game['name']) ?>"
                                     class="game-cover">
                            <?php else: ?>
                                <div class="no-image">
                                    <span>// NO DATA</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-content">
                            <span class="mission-type">// TYPE : <?= htmlspecialchars($game['type']) ?></span>

                            <h3><?= htmlspecialchars($game['name']) ?></h3>

                            <p class="mission-desc">
                                <?= htmlspecialchars($game['description'] ?? 'Aucune information tactique disponible.') ?>
                            </p>

                            <a href="#" class="btn-ghost">DÉTAILS DU JEU</a>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune mission disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>

<?php include 'templates/footer.php'; ?>