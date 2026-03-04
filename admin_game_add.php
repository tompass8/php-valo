<?php
session_start();
require __DIR__ . '/db.php';

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
    <div class="main-container" style="padding: 20px;">
        <h1>Nouvelle Mission</h1>
        <form method="POST">
            <input type="text" name="name" placeholder="Nom du jeu" required style="display:block; margin:10px 0;"><br>
            <input type="text" name="type" placeholder="Type (FPS...)" required style="display:block; margin:10px 0;"><br>
            <textarea name="description" placeholder="Description" style="display:block; margin:10px 0; width:300px; height:100px;"></textarea><br>
            <input type="text" name="image_url" placeholder="URL Image" style="display:block; margin:10px 0;"><br>
            <button type="submit" class="btn" style="background-color:#ff4655; color:white; padding:10px; border:none; cursor:pointer;">Créer</button>
        </form>
    </div>
<?php include 'templates/footer.php'; ?>