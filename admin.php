<?php
session_start();
require 'db.php';

// --- SÉCURITÉ : VÉRIFICATION DU RÔLE ---
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Récupérer la liste des jeux
$stmt = $pdo->query("SELECT * FROM games ORDER BY name ASC");
$games = $stmt->fetchAll();

// Récupérer la liste des utilisateurs
$stmtUsers = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmtUsers->fetchAll();

include 'templates/header.php';
?>

    <div class="main-container" style="padding: 20px;">
        <h1>Dashboard ADMIN - Valorant Protocol</h1>

        <section class="admin-section" style="margin-bottom: 40px;">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h2>Liste des Missions (Jeux)</h2>
                <a href="admin_game_add.php" class="btn" style="background-color:green; color:white; padding:10px; text-decoration:none;">+ Ajouter un jeu</a>
            </div>

            <table border="1" style="width:100%; margin-top:10px; border-collapse:collapse;">
                <thead>
                <tr style="background:#ff4655; color:white;">
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($games as $game): ?>
                    <tr>
                        <td><?= htmlspecialchars($game['name']) ?></td>
                        <td><?= htmlspecialchars($game['type']) ?></td>
                        <td>
                            <a href="admin_game_edit.php?id=<?= $game['id'] ?>">Modifier</a> |
                            <a href="admin_game_delete.php?id=<?= $game['id'] ?>" style="color:red;" onclick="return confirm('Supprimer ce jeu ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="admin-section">
            <h2>Gestion des Agents (Users)</h2>
            <table border="1" style="width:100%; border-collapse:collapse;">
                <thead>
                <tr style="background:#333; color:white;">
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Rôle</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['pseudo']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                        <span style="<?= $u['role'] == 'admin' ? 'color:red; font-weight:bold;' : '' ?>">
                            <?= ucfirst($u['role']) ?>
                        </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>

<?php include 'templates/footer.php'; ?>