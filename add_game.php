<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $hours = intval($_POST['hours']);
    $rank = htmlspecialchars($_POST['rank']);
    $main = htmlspecialchars($_POST['main']);
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO games (user_id, name, hours_played, player_rank, main_character) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $name, $hours, $rank, $main]);

    header('Location: profil.php');
    exit();
}

include 'templates/header.php';
?>

    <div class="profile-container">
        <div class="login-box stats-card">
            <h1>Nouvelle Carte Agent</h1>
            <form method="POST">
                <div class="form-group">
                    <label>NOM DU JEU</label>
                    <input type="text" name="name" placeholder="ex: Valorant" required>
                </div>
                <div class="form-group">
                    <label>HEURES DE JEU</label>
                    <input type="number" name="hours" placeholder="ex: 450" required>
                </div>
                <div class="form-group">
                    <label>RANG</label>
                    <input type="text" name="rank" placeholder="ex: Diamant 2">
                </div>
                <div class="form-group">
                    <label>MAIN (AGENT)</label>
                    <input type="text" name="main" placeholder="ex: Jett">
                </div>
                <button type="submit" class="btn-valo">CRÉER LA CARTE</button>
            </form>
        </div>
    </div>

<?php include 'templates/footer.php'; ?>