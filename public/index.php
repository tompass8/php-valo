<?php
// --- 1. LOGIQUE (PHP) ---
session_start();
require '../config/db.php';

$stmt = $pdo->query("SELECT * FROM games ORDER BY id DESC");
$games = $stmt->fetchAll();

$page_title = "Accueil";

include '../templates/header.php';?>

    <section class="hero">
        <p class="hero-status">// STATUT : CONNECTÉ</p>

        <h1 class="hero-title">
            BIENVENUE, AGENT <span><?= htmlspecialchars($_SESSION['pseudo'] ?? 'INCONNU') ?></span>
        </h1>

        <p class="hero-subtitle">
            Prêt à déployer ? Consultez les missions disponibles ou gérez votre profil.
        </p>

        <div class="hero-actions">
            <a href="profil.php" class="btn-val">MON DOSSIER</a>
            <?php if(($_SESSION['role'] ?? '') === 'admin'): ?>
                <a href="admin.php" class="btn-ghost">ADMINISTRATION</a>
            <?php endif; ?>
        </div>
    </section>

    <div class="container">
        <h2 class="section-title">Missions Disponibles</h2>

        <div class="missions-grid">
            <?php if (!empty($games)): ?>
                <?php foreach ($games as $game): ?>
                    <div class="mission-card">
                        <div class="card-img-wrapper">
                            <?php if (!empty($game['image']) && file_exists('../assets/img/games/' . $game['image'])): ?>
                                <img src="/php-valo/assets/img/games/<?= htmlspecialchars($game['image']) ?>"
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
                <p class="no-results">Aucune mission disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>

<?php include '../templates/footer.php'; ?>
