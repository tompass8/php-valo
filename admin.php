<?php
// --- 1. LOGIQUE (PHP) ---
session_start();
require 'db.php';

// Sécurité : Accès restreint aux administrateurs
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit();
}

// Récupération des données (Jeux et Utilisateurs)
$stmt = $pdo->query("SELECT * FROM games ORDER BY name ASC");
$games = $stmt->fetchAll();

$stmtUsers = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmtUsers->fetchAll();

// Configuration de la page
$page_title = "Dashboard Admin - Valorant";
$page_css = "admin";

include 'templates/header.php';
?>

    <div class="admin-container">
        <h1 class="admin-main-title">Dashboard <span class="highlight-red">ADMIN</span></h1>
        <p class="admin-subtitle">// GESTION DU PROTOCOLE VALORANT</p>

        <section class="admin-section">
            <div class="section-header">
                <div class="header-info">
                    <h2>Liste des Jeux</h2>
                    <span class="count-info">Total : <?= count($games) ?> missions</span>
                </div>
                <a href="admin_game_add.php" class="btn-val">+ NOUVEAU JEU</a>
            </div>

            <table class="val-table">
                <thead>
                <tr>
                    <th class="col-name">NOM DU JEU</th>
                    <th class="col-type">TYPE</th>
                    <th class="col-actions">ACTIONS</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($games as $game): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($game['name']) ?></strong></td>
                        <td><?= htmlspecialchars($game['type']) ?></td>
                        <td class="actions-cell">
                            <a href="admin_game_edit.php?id=<?= $game['id'] ?>" class="btn-ghost">ÉDITER</a>
                            <a href="admin_game_delete.php?id=<?= $game['id'] ?>" class="btn-ghost btn-danger" onclick="return confirm('Supprimer ce jeu ?');">SUPPRIMER</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="admin-section">
            <div class="section-header simple">
                <h2>Agents Inscrits</h2>
                <span class="count-info">Total : <?= count($users) ?> agents</span>
            </div>

            <table class="val-table">
                <thead>
                <tr>
                    <th>IDENTITÉ (PSEUDO)</th>
                    <th>CONTACT (EMAIL)</th>
                    <th>ACCRÉDITATION</th>
                    <th>GESTION</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($u['pseudo']) ?></strong></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <span class="badge <?= $u['role'] === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                <?= $u['role'] === 'admin' ? 'COMMANDANT' : 'AGENT' ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit_user.php?id=<?= $u['id'] ?>" class="btn-ghost">MODIFIER RÔLE</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>

<?php include 'templates/footer.php'; ?>