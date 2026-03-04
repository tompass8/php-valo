<?php
session_start();
require 'db.php';

// --- SÉCURITÉ : VÉRIFICATION DU RÔLE ---
// Résolution du conflit : On redirige vers index.php si l'accès est refusé
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit();
}

// 1. Récupérer la liste des jeux (Missions)
$stmt = $pdo->query("SELECT * FROM games ORDER BY name ASC");
$games = $stmt->fetchAll();

// 2. Récupérer la liste des utilisateurs (Agents)
$stmtUsers = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmtUsers->fetchAll();

include 'templates/header.php';
?>

    <style>
        :root {
            --val-red: #ff4655;
            --val-dark: #0f1923;
            --val-card: #1f2731;
            --val-text: #ece8e1;
        }

        .admin-container {
            padding: 40px;
            color: var(--val-text);
            background-color: var(--val-dark);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h1, h2 {
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        h1 { font-size: 2.5em; border-left: 5px solid var(--val-red); padding-left: 20px; }
        h2 { font-size: 1.5em; color: #bdbdbd; margin-top: 0; }

        .admin-section {
            background: var(--val-card);
            padding: 30px;
            margin-bottom: 40px;
            border: 1px solid #333;
            position: relative;
        }

        .admin-section::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 20px; height: 20px;
            border-top: 2px solid var(--val-red);
            border-right: 2px solid var(--val-red);
        }

        .btn-val {
            display: inline-block;
            background: var(--val-red);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid var(--val-red);
            transition: all 0.3s ease;
            font-size: 0.9em;
        }
        .btn-val:hover { background: white; color: var(--val-red); }

        .btn-ghost {
            background: transparent;
            border: 1px solid #555;
            color: #ccc;
            padding: 5px 10px;
            font-size: 0.8em;
            text-decoration: none;
            text-transform: uppercase;
        }
        .btn-ghost:hover { border-color: white; color: white; }

        .btn-danger { color: #ff4655; margin-left: 10px; }
        .btn-danger:hover { text-decoration: underline; }

        .val-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .val-table th {
            background: #2c3540;
            color: var(--val-red);
            text-transform: uppercase;
            padding: 15px;
            text-align: left;
            font-size: 0.85em;
            border-bottom: 2px solid var(--val-red);
        }
        .val-table td { padding: 15px; border-bottom: 1px solid #333; color: #ddd; }
        .val-table tr:hover { background-color: #252f38; }

        .badge {
            padding: 5px 10px;
            font-size: 0.75em;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 2px;
        }
        .badge-admin { background: rgba(255, 70, 85, 0.2); color: #ff4655; border: 1px solid #ff4655; }
        .badge-user { background: #333; color: #aaa; }
    </style>

    <div class="admin-container">
        <h1>Dashboard <span style="color: var(--val-red);">ADMIN</span></h1>
        <p style="margin-bottom: 50px; color: #888;">// GESTION DU PROTOCOLE VALORANT</p>

        <section class="admin-section">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
                <div>
                    <h2>Liste des Jeux</h2>
                    <span style="color:#666; font-size:0.9em;">Total : <?= count($games) ?> missions</span>
                </div>
                <a href="admin_game_add.php" class="btn-val">+ NOUVEAU JEU</a>
            </div>

            <table class="val-table">
                <thead>
                <tr>
                    <th width="40%">NOM DU JEU</th>
                    <th width="30%">TYPE</th>
                    <th width="30%">ACTIONS</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($games as $game): ?>
                    <tr>
                        <td style="font-weight: bold; color: white;"><?= htmlspecialchars($game['name']) ?></td>
                        <td style="color: #999;"><?= htmlspecialchars($game['type']) ?></td>
                        <td>
                            <a href="admin_game_edit.php?id=<?= $game['id'] ?>" class="btn-ghost">ÉDITER</a>
                            <a href="admin_game_delete.php?id=<?= $game['id'] ?>" class="btn-ghost btn-danger" onclick="return confirm('Supprimer ce jeu ?');">SUPPRIMER</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="admin-section">
            <div style="margin-bottom: 20px;">
                <h2>Agents Inscrits</h2>
                <span style="color:#666; font-size:0.9em;">Total : <?= count($users) ?> agents</span>
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
                        <td style="color: white; font-weight: bold;"><?= htmlspecialchars($u['pseudo']) ?></td>
                        <td style="color: #999;"><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <?php if ($u['role'] === 'admin'): ?>
                                <span class="badge badge-admin">COMMANDANT</span>
                            <?php else: ?>
                                <span class="badge badge-user">AGENT</span>
                            <?php endif; ?>
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