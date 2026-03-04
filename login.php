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
    $email = htmlspecialchars($_POST['email']);
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
        $_SESSION['role'] = $user['role'];

        header('Location: profil.php');
        exit();
    } else {
        $error = "Accès refusé : Identifiants invalides.";
    }
}

// --- AFFICHAGE (FRONT) ---
include 'templates/header.php';
?>

    <div class="profile-container">
        <div class="login-box">
            <h1>Connexion Agent</h1>
            <p>Entrez vos accès pour rejoindre la zone de combat.</p>

            <?php if ($error): ?>
                <div style="background: rgba(255, 70, 85, 0.2); border: 1px solid var(--valo-red); padding: 10px; margin-bottom: 20px; color: var(--valo-red);">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div style="margin-bottom: 15px;">
                    <label>EMAIL</label><br>
                    <input type="email" name="email" required style="width: 100%; padding: 10px; background: var(--valo-black); border: 1px solid #444; color: white;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label>MOT DE PASSE</label><br>
                    <input type="password" name="password" required style="width: 100%; padding: 10px; background: var(--valo-black); border: 1px solid #444; color: white;">
                </div>

                <button type="submit" class="badge" style="border: none; cursor: pointer; width: 100%; font-family: inherit;">
                    S'AUTHENTIFIER
                </button>
            </form>

            <p style="margin-top: 20px; font-size: 0.8em;">
                Pas encore d'agent ? <a href="register.php" style="color: var(--valo-red);">Créer un compte</a>
            </p>
        </div>
    </div>

<?php include 'templates/footer.php'; ?>