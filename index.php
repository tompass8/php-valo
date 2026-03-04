<?php
session_start();
require 'db.php';

// 1. Récupération des jeux (Missions disponibles)
$stmt = $pdo->query("SELECT * FROM games ORDER BY id DESC LIMIT 6");
$games = $stmt->fetchAll();

// 2. Vérifier si l'utilisateur est connecté pour personnaliser le message
$isLoggedIn = isset($_SESSION['user_id']);
$pseudo = $isLoggedIn ? $_SESSION['pseudo'] ?? 'Agent' : 'Invité';

include 'templates/header.php';
?>

    <style>
        :root {
            --val-red: #ff4655;
            --val-dark: #0f1923;
            --val-card: #1f2731; /* Un peu plus clair que le fond */
            --val-text: #ece8e1;
        }

        body {
            background-color: var(--val-dark);
            color: var(--val-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        /* HERO SECTION (Bannière du haut) */
        .hero-section {
            background: linear-gradient(135deg, #0f1923 0%, #1f2731 100%);
            padding: 80px 20px;
            text-align: center;
            border-bottom: 4px solid var(--val-red);
            position: relative;
            overflow: hidden;
        }

        /* Effet de fond géométrique */
        .hero-section::before {
            content: "VALORANT";
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 10em;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.03);
            z-index: 0;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        h1 {
            font-size: 3.5em;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 2px;
            font-weight: 800;
        }

        .subtitle {
            font-size: 1.2em;
            color: #ff4655;
            text-transform: uppercase;
            margin-top: 10px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* BOUTONS D'ACTION (HERO) */
        .cta-container {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn-hero {
            padding: 15px 40px;
            background: var(--val-red);
            color: white;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            /* Forme géométrique typique de Valorant */
            clip-path: polygon(10% 0, 100% 0, 100% 70%, 90% 100%, 0 100%, 0 30%);
            transition: transform 0.2s, background 0.2s;
        }

        .btn-hero:hover {
            background: white;
            color: var(--val-dark);
            transform: translateY(-3px);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid white;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%); /* Carré simple */
        }
        .btn-secondary:hover {
            background: white;
            color: var(--val-dark);
        }

        /* GRILLE DES JEUX (MISSIONS) */
        .games-container {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 20px;
        }

        .section-title {
            border-left: 5px solid var(--val-red);
            padding-left: 20px;
            font-size: 2em;
            text-transform: uppercase;
            margin-bottom: 40px;
        }

        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .game-card {
            background: var(--val-card);
            border: 1px solid #333;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .game-card:hover {
            transform: translateY(-5px);
            border-color: var(--val-red);
            box-shadow: 0 10px 30px rgba(255, 70, 85, 0.2);
        }

        /* Image placeholder pour le jeu */
        .game-img-placeholder {
            height: 180px;
            background: #2c3540;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .game-info {
            padding: 20px;
        }

        .game-title {
            font-size: 1.4em;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: white;
            text-transform: uppercase;
        }

        .game-type {
            font-size: 0.8em;
            color: var(--val-red);
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 15px;
            display: inline-block;
            border: 1px solid var(--val-red);
            padding: 2px 8px;
        }

        .game-desc {
            color: #aaa;
            font-size: 0.9em;
            line-height: 1.5;
        }

    </style>

    <div class="hero-section">
        <div class="hero-content">
            <?php if ($isLoggedIn): ?>
                <div class="subtitle">// STATUT : CONNECTÉ</div>
                <h1>BIEVENUE, AGENT <?= htmlspecialchars($pseudo) ?></h1>
                <p style="color:#aaa; max-width:600px; margin: 20px auto;">
                    Prêt à déployer ? Consultez les missions disponibles ou gérez votre profil.
                </p>

                <div class="cta-container">
                    <a href="profil.php" class="btn-hero">MON DOSSIER</a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="admin.php" class="btn-hero btn-secondary">ADMINISTRATION</a>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="subtitle">// PROTOCOLE VALORANT</div>
                <h1>REJOIGNEZ LES RANGS</h1>
                <p style="color:#aaa; max-width:600px; margin: 20px auto;">
                    Une équipe mondiale. Des pouvoirs uniques. Connectez-vous pour accéder aux données classifiées.
                </p>

                <div class="cta-container">
                    <a href="login.php" class="btn-hero">CONNEXION</a>
                    <a href="register.php" class="btn-hero btn-secondary">S'INSCRIRE</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="games-container">
        <h2 class="section-title">MISSIONS DISPONIBLES</h2>

        <?php if (count($games) > 0): ?>
            <div class="games-grid">
                <?php foreach ($games as $game): ?>
                    <div class="game-card">
                        <div class="game-img-placeholder">
                            <?= htmlspecialchars($game['type']) ?>
                        </div>

                        <div class="game-info">
                            <div class="game-type">// TYPE : <?= htmlspecialchars($game['type']) ?></div>
                            <h3 class="game-title"><?= htmlspecialchars($game['name']) ?></h3>
                            <p class="game-desc">
                                Une nouvelle mission tactique. Préparez votre équipe et défiez les limites.
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color: #aaa; font-style: italic;">Aucune mission disponible pour le moment.</p>
        <?php endif; ?>

    </div>

<?php include 'templates/footer.php'; ?>