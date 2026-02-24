<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php'); exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO games (name, type, description, image_url) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['type'],
        $_POST['description'],
        $_POST['image_url']
    ]);
    header('Location: admin.php'); exit();
}

include 'templates/header.php';
?>
    <div class="main-container">
        <h1>Nouvelle Mission</h1>
        <form method="POST">
            <input type="text" name="name" placeholder="Nom du jeu" required><br>
            <input type="text" name="type" placeholder="Type (FPS...)" required><br>
            <textarea name="description" placeholder="Description"></textarea><br>
            <input type="text" name="image_url" placeholder="URL Image"><br>
            <button type="submit" class="btn">Créer</button>
        </form>
    </div>
<?php include 'templates/footer.php'; ?>