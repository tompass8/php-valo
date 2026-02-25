<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $hours = intval($_POST['hours']);
    $rank = htmlspecialchars($_POST['rank']);
    $main = htmlspecialchars($_POST['main']);
    $userId = $_SESSION['user_id'];

    // --- LOGIQUE D'UPLOAD D'IMAGE ---
    $imageName = "default.png"; // Image par défaut
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "assets/img/" . $imageName);
    }

    $stmt = $pdo->prepare("INSERT INTO games (user_id, name, hours_played, player_rank, main_character, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $name, $hours, $rank, $main, $imageName]);

    header('Location: profil.php');
    exit();
}
include 'templates/header.php';
?>

<div class="profile-container">
    <div class="login-box stats-card">
        <h1>Nouvelle Carte Agent</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>NOM DU JEU</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>IMAGE DE L'AGENT</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label>HEURES</label>
                <input type="number" name="hours">
            </div>
            <div class="form-group">
                <label>RANG</label>
                <input type="text" name="rank">
            </div>
            <div class="form-group">
                <label>MAIN</label>
                <input type="text" name="main">
            </div>
            <button type="submit" class="btn-valo">DÉPLOYER</button>
        </form>
    </div>
</div>