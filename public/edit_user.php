<?php
session_start();
require '../config/db.php';;

// --- SÉCURITÉ ---
// Seul un ADMIN peut accéder à cette page
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit();
}

// 1. Récupération de l'ID via l'URL
if (!isset($_GET['id'])) {
    header('Location: admin.php');
    exit();
}
$id = $_GET['id'];

// 2. Traitement du formulaire (Mise à jour)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $role = $_POST['role']; // 'user' ou 'admin'

    // Requête de mise à jour
    $stmt = $pdo->prepare("UPDATE users SET pseudo = ?, email = ?, role = ? WHERE id = ?");
    $stmt->execute([$pseudo, $email, $role, $id]);

    // Redirection vers le dashboard
    header("Location: admin.php");
    exit();
}

// 3. Récupération des infos actuelles de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

// Si l'utilisateur n'existe pas
if (!$user) {
    die("Agent introuvable.");
}

include '../templates/header.php';?>

    <style>
        :root {
            --val-red: #ff4655;
            --val-dark: #0f1923;
            --val-card: #1f2731;
            --val-text: #ece8e1;
        }

        .edit-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 85vh;
            background-color: var(--val-dark);
            color: var(--val-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .form-card {
            background: var(--val-card);
            width: 100%;
            max-width: 500px;
            padding: 40px;
            border-left: 5px solid var(--val-red);
            border: 1px solid #333;
            border-left-width: 5px; /* On force le bord gauche rouge */
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        h1 {
            text-transform: uppercase;
            font-size: 1.8em;
            margin-top: 0;
            margin-bottom: 30px;
            letter-spacing: 1px;
            font-weight: 800;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .form-group { margin-bottom: 20px; }

        label {
            display: block;
            color: #888;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8em;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            background-color: var(--val-dark);
            border: 1px solid #444;
            color: white;
            font-family: inherit;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            border-color: var(--val-red);
            background-color: #16202a;
        }

        /* Bouton Sauvegarder */
        .btn-submit {
            background-color: var(--val-red);
            color: white;
            border: none;
            padding: 15px 30px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            clip-path: polygon(0 0, 100% 0, 100% 70%, 95% 100%, 0 100%);
            transition: 0.2s;
            display: block;
            width: 100%;
            margin-top: 30px;
        }

        .btn-submit:hover {
            background-color: white;
            color: var(--val-red);
        }

        .btn-cancel {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
            font-size: 0.8em;
            text-transform: uppercase;
        }
        .btn-cancel:hover { color: white; }

    </style>

    <div class="edit-container">
        <div class="form-card">
            <h1>DOSSIER AGENT #<?= $user['id'] ?></h1>

            <form method="POST">

                <div class="form-group">
                    <label>IDENTIFIANT (PSEUDO)</label>
                    <input type="text" name="pseudo" value="<?= htmlspecialchars($user['pseudo']) ?>" required>
                </div>

                <div class="form-group">
                    <label>CONTACT (EMAIL)</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label style="color: var(--val-red);">ACCRÉDITATION (RÔLE)</label>
                    <select name="role">
                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>
                            AGENT (Utilisateur Standard)
                        </option>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>
                            COMMANDANT (Administrateur)
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">CONFIRMER LES CHANGEMENTS</button>
                <a href="admin.php" class="btn-cancel">ANNULER</a>
            </form>
        </div>
    </div>

<?php include '../templates/footer.php'; ?>
