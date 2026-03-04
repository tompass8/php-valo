<?php
session_start();
require 'db.php';

// Vérif connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$id = $_SESSION['user_id'];

// 1. TRAITEMENT DU FORMULAIRE (Mise à jour du Genre)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profil'])) {
    $nouveau_genre = $_POST['genre'];

    // On prépare la requête (Sécurité contre injection SQL)
    $stmt = $pdo->prepare("UPDATE users SET genre = ? WHERE id = ?");
    $stmt->execute([$nouveau_genre, $id]);

    // On rafraichit la page pour voir le changement
    header("Location: profil.php");
    exit();
}

// 2. RÉCUPÉRATION DES INFOS USER
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

// Sécurité : Si l'utilisateur n'est pas trouvé (ex: id supprimé), on arrête
if (!$user) {
    die("Erreur : Utilisateur introuvable.");
}

// 3. RÉCUPÉRATION DES SUCCÈS
$stmtSucces = $pdo->query("SELECT * FROM achievements");
$succes = $stmtSucces->fetchAll();

include 'templates/header.php';
?>

    <div class="main-container" style="padding: 40px; color: white;">

        <h1 style="color: #ff4655; font-size: 3em; text-transform: uppercase;">
            AGENT : <?= htmlspecialchars($user['pseudo']) ?>
        </h1>

        <div class="profile-grid" style="display: flex; gap: 40px; flex-wrap: wrap;">

            <div class="card" style="background: #1f2731; padding: 20px; border-left: 5px solid #ff4655; flex: 1;">
                <h2>// DOSSIER PERSONNEL</h2>
                <p><strong>Matricule (Email) :</strong> <?= htmlspecialchars($user['email']) ?></p>

                <p><strong>Temps de service (Jeu) :</strong> <?= rand(50, 5000) ?> heures</p>

                <p style="color: #ff4655;"><strong>☠️ Fin de service estimée :</strong> <?= htmlspecialchars($user['date_mort'] ?? 'Inconnue') ?></p>

                <hr style="border-color: #333; margin: 20px 0;">

                <form method="POST">
                    <label>Genre de l'Agent :</label><br>
                    <select name="genre" style="padding: 10px; background: #0f1923; color: white; border: 1px solid #555;">
                        <?php $genre = $user['genre'] ?? ''; ?>

                        <option value="Non spécifié" <?= $genre == 'Non spécifié' ? 'selected' : '' ?>>Non spécifié</option>
                        <option value="Homme" <?= $genre == 'Homme' ? 'selected' : '' ?>>Homme</option>
                        <option value="Femme" <?= $genre == 'Femme' ? 'selected' : '' ?>>Femme</option>
                        <option value="Radiant" <?= $genre == 'Radiant' ? 'selected' : '' ?>>Radiant</option>
                        <option value="Autre" <?= $genre == 'Autre' ? 'selected' : '' ?>>Autre</option>
                    </select>
                    <button type="submit" name="update_profil" class="btn" style="background: #ff4655; color: white; padding: 10px 20px; border: none; cursor: pointer; margin-top: 10px;">
                        METTRE À JOUR
                    </button>
                </form>
            </div>

            <div class="card" style="flex: 1;">
                <h2 style="border-bottom: 2px solid #ff4655; display: inline-block;">// MÉDAILLES & SUCCÈS</h2>

                <div class="achievements-list" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
                    <?php if ($succes): ?>
                        <?php foreach ($succes as $s): ?>
                            <div class="achievement-item" style="background: #0f1923; padding: 15px; border: 1px solid #333;">
                                <strong style="color: #ff4655;"><?= htmlspecialchars($s['name']) ?></strong>
                                <p style="font-size: 0.9em; color: #ccc;"><?= htmlspecialchars($s['description']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun succès disponible.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

<?php include 'templates/footer.php'; ?>