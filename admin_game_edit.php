<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php'); exit();
}

$id = intval($_GET['id']);

// Mise à jour
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("UPDATE games SET name=?, type=?, description=?, image_url=? WHERE id=?");
    $stmt->execute([
        $_POST['name'], $_POST['type'], $_POST['description'], $_POST['image_url'], $id
    ]);
    header('Location: admin.php'); exit();
}

// Récupération des données existantes
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch();

include 'templates/header.php';
?>
    <div class="main-container">
        <h1>Modifier : <?= htmlspecialchars($game['name']) ?></h1>
        <form method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($game['name']) ?>" required><br>
            <input type="text" name="type" value="<?= htmlspecialchars($game['type']) ?>" required><br>
            <textarea name="description"><?= htmlspecialchars($game['description']) ?></textarea><br>
            <input type="text" name="image_url" value="<?= htmlspecialchars($game['image_url']) ?>"><br>
            <button type="submit" class="btn">Sauvegarder</button>
        </form>
    </div>
<?php include 'templates/footer.php'; ?>