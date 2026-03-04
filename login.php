<?php
// --- LOGIQUE (BACK) ---
session_start();
require_once 'db.php';

// Si l'utilisateur est déjà connecté, on l'envoie direct au profil
if (isset($_SESSION['user_id'])) {
    header('Location: profil.php');
    exit();
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']); // Sécurité XSS
    $password = $_POST['password'];

    // On cherche l'utilisateur par son email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérification du mot de passe haché
    if ($user && password_verify($password, $user['password'])) {
        // On stocke les infos en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        header('Location: profil.php'); // Redirection vers le profil
        exit();
    } else {
        $error = "ACCÈS REFUSÉ : Identifiants incorrects.";
    }
}

// --- AFFICHAGE (FRONT) ---
include 'templates/header.php';
?>

    <style>
        :root {
            --val-red: #ff4655;
            --val-dark: #0f1923;
            --val-card: #1f2731;
            --val-text: #ece8e1;
        }

        /* Conteneur principal qui centre la carte */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh; /* Prend presque toute la hauteur */
            background-color: var(--val-dark);
        }

        /* La carte de connexion */
        .login-card {
            background: var(--val-card);
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-top: 4px solid var(--val-red);
            border-bottom: 1px solid #333;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            position: relative;
        }

        /* Titre */
        h1 {
            color: white;
            text-transform: uppercase;
            font-size: 2em;
            text-align: center;
            margin-bottom: 10px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .subtitle {
            text-align: center;
            color: #999;
            font-size: 0.9em;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        /* Champs de formulaire */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #ccc;
            font-size: 0.8em;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            background-color: #0f1923; /* Plus foncé que la carte */
            border: 1px solid #444;
            color: white;
            font-family: inherit;
            outline: none;
            transition: border 0.3s;
            box-sizing: border-box; /* Important pour ne pas dépasser */
        }

        input:focus {
            border-color: var(--val-red); /* Bordure rouge au clic */
        }

        /* Bouton VALORANT */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: var(--val-red);
            color: white;
            border: none;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 1em;
            cursor: pointer;
            /* Coin coupé style Valorant */
            clip-path: polygon(0 0, 100% 0, 100% 80%, 95% 100%, 0 100%);
            transition: background 0.3s, transform 0.1s;
        }

        .btn-submit:hover {
            background-color: white;
            color: var(--val-red);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        /* Message d'erreur */
        .alert-error {
            background: rgba(255, 70, 85, 0.1);
            border-left: 3px solid var(--val-red);
            color: var(--val-red);
            padding: 15px;
            margin-bottom: 20px;
            font-size: 0.9em;
            text-align: center;
            font-weight: bold;
        }

        /* Lien inscription */
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85em;
            color: #888;
        }
        .register-link a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-bottom: 1px solid var(--val-red);
        }
        .register-link a:hover {
            color: var(--val-red);
        }

    </style>

    <div class="login-container">
        <div class="login-card">
            <h1>Identifiez-vous</h1>
            <p class="subtitle">// Accès au Protocole Valorant</p>

            <?php if ($error): ?>
                <div class="alert-error">
                    ⚠️ <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="email">Matricule (Email)</label>
                    <input type="email" id="email" name="email" required placeholder="agent@valorant.com">
                </div>

                <div class="form-group">
                    <label for="password">Code d'accès (Mot de passe)</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn-submit">
                    Lancer la connexion
                </button>
            </form>

            <div class="register-link">
                Nouvelle recrue ? <a href="register.php">CRÉER UN DOSSIER</a>
            </div>
        </div>
    </div>

<?php include 'templates/footer.php'; ?>