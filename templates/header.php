<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VALORANT - Agent Hub</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="valo-navbar">
    <div class="nav-container">
        <a href="profil.php" class="nav-logo">AGENT_<span>HUB</span></a>

        <ul class="nav-links">
            <li><a href="profil.php">MES AGENTS</a></li>
            <li><a href="add_game.php" class="nav-btn-add">+ DÉPLOYER</a></li>

            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php" class="nav-logout">DÉCONNEXION</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="main-content">