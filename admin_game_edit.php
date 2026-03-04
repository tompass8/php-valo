<?php
session_start();
require __DIR__ . '/db.php';

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
    <div class="main-container" style="padding: 20px;">
        <h1>Modifier : <?= htmlspecialchars($game['name']) ?></h1>
        <form method="POST">
            <label>Nom :</label>
            <input type="text" name="name" value="<?= htmlspecialchars($game['name']) ?>" required style="display:block; margin:10px 0;"><br>

            <label>Type :</label>
            <input type="text" name="type" value="<?= htmlspecialchars($game['type']) ?>" required style="display:block; margin:10px 0;"><br>

            <label>Description :</label>
            <textarea name="description" style="display:block; margin:10px 0; width:300px; height:100px;"><?= htmlspecialchars($game['description']) ?></textarea><br>

            <label>Image URL :</label>
            <input type="text" name="image_url" value="<?= htmlspecialchars($game['image_url']) ?>" style="display:block; margin:10px 0;"><br>

            <button type="submit" class="btn" style="background-color:#ff4655; color:white; padding:10px; border:none;">Sauvegarder</button>
        </form>
    </div>
<?php include 'templates/footer.php'; ?>