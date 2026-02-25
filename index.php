<?php
session_start();
require_once 'db.php';

// Récupération des jeux
if (isset($pdo)) {
    $sql = "SELECT * FROM games ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $games = [];
}

include 'templates/header.php';
?>

    <style>
        :root {
            --val-red: #ff4655;
            --val-dark: #0f1923;
            --val-text: #ece8e1;
            --val-card-bg: #1f2731;
        }
        body {
            background-color: var(--val-dark);
            color: var(--val-text);
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }
        .hero {
            background: linear-gradient(rgba(15, 25, 35, 0.8), rgba(15, 25, 35, 0.9)), url('https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt3f072436ec0dc39e/6203027b6869680b54070a72/VALORANT_Jett_Tease_1920x1080_no_text.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 20px;
            text-align: center;
            border-bottom: 4px solid var(--val-red);
        }
        .hero h1 {
            font-size: 4rem;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: white;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: bold;
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: var(--val-text);
            transition: 0.3s;
        }
        .btn-primary { background-color: var(--val-red); border-color: var(--val-red); color: white; }
        .btn-primary:hover { background-color: #d93644; }
        .btn-secondary:hover { background-color: rgba(255, 255, 255, 0.1); border-color: white; }
        .btn-admin { background-color: #8b0000; border-color: #8b0000; }

        .container { max-width: 1200px; margin: 50px auto; padding: 0 20px; }
        .games-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; }
        .game-card { background-color: var(--val-card-bg); border: 1px solid #333; transition: transform 0.2s; }
        .game-card:hover { transform: translateY(-5px); border-color: var(--val-red); }
        .game-image { width: 100%; height: 200px; object-fit: cover; border-bottom: 4px solid var(--val-red); }
        .game-info { padding: 20px; }
        .game-title { font-size: 1.5rem; margin: 5px 0 10px 0; text-transform: uppercase; }
        .game-type { color: var(--val-red); font-weight: bold; text-transform: uppercase; font-size: 0.9rem; }
    </style>

    <section class="hero">
        <h1>Valorant Protocol</h1>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="hero-welcome">
                Bon retour, Agent <strong><?= htmlspecialchars($_SESSION['pseudo']) ?></strong>
            </div>

            <a href="profil.php" class="btn btn-secondary">Mon Profil</a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin.php" class="btn btn-primary btn-admin">Dashboard Admin</a>
            <?php endif; ?>

            <a href="logout.php" class="btn btn-secondary">Déconnexion</a>

        <?php else: ?>
            <div class="hero-welcome">Rejoignez les rangs. Défiez les limites.</div>
            <a href="register.php" class="btn btn-primary">S'inscrire</a>
            <a href="login.php" class="btn btn-secondary">Se connecter</a>
        <?php endif; ?>
    </section>

    <div class="container">
        <h2 style="border-left: 5px solid #ff4655; padding-left: 15px;">Missions Disponibles</h2>

        <?php if (count($games) > 0): ?>
            <div class="games-grid">
                <?php foreach ($games as $game): ?>
                    <article class="game-card">
                        <?php if (!empty($game['image_url'])): ?>
                            <img src="<?= htmlspecialchars($game['image_url']) ?>" alt="Jeu" class="game-image">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x200/1f2731/ece8e1?text=VALORANT" alt="No Image" class="game-image">
                        <?php endif; ?>

                        <div class="game-info">
                            <div class="game-type"><?= htmlspecialchars($game['type']) ?></div>
                            <h3 class="game-title"><?= htmlspecialchars($game['name']) ?></h3>
                            <p><?= htmlspecialchars($game['description']) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucune mission disponible.</p>
        <?php endif; ?>
    </div>

<?php include 'templates/footer.php'; ?>