<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'VALORANT' ?></title>

    <link rel="stylesheet" href="assets/css/style.css">

    <?php if (isset($page_css)): ?>
        <link rel="stylesheet" href="assets/css/<?= $page_css ?>.css">
    <?php endif; ?>
</head>
<body>

<header>
    <nav class="navbar">
        <div class="nav-links">
            <a href="index.php">ACCUEIL</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="profil.php">PROFIL</a>
                <?php if(($_SESSION['role'] ?? '') === 'admin'): ?>
                    <a href="admin.php">ADMIN</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="nav-auth">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="logout-btn">EXTRACTION</a>
            <?php else: ?>
                <a href="login.php">CONNEXION</a>
            <?php endif; ?>
        </div>

        <div class="nav-scan-line"></div>
    </nav>
</header>
<main>

