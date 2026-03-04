<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VALORANT - Plateforme</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <nav>
        <a href="index.php">Accueil</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="profil.php">Profil</a>
            <a href="logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="login.php">Connexion</a>
        <?php endif; ?>
    </nav>
</header>
<main>