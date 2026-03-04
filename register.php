<?php
session_start(); // On démarre la session pour gérer les messages éventuels
require 'db.php';

$message = ""; // Pour afficher les erreurs ou succès

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Sécurité max

    // 1. Vérifier si l'email existe déjà
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $message = "<div style='color: red; margin-bottom: 20px;'>❌ Cet email est déjà utilisé !</div>";
    } else {
        // 2. GÉNÉRATION DES DONNÉES ALÉATOIRES (Pour le projet)
        // Temps de jeu aléatoire entre 0 et 5000 heures
        $temps_jeu = rand(0, 5000);

        // Date de mort aléatoire (entre dans 1 an et dans 80 ans)
        $date_mort = date('Y-m-d', strtotime('+' . rand(1, 80) . ' years'));

        // Genre par défaut (l'utilisateur le changera dans son profil)
        $genre = 'Non spécifié';

        // 3. INSERTION DANS LA BDD
        // On ajoute bien les colonnes : genre, date_mort, temps_jeu
        $ins = $pdo->prepare("INSERT INTO users (pseudo, email, password, role, genre, date_mort, temps_jeu) VALUES (?, ?, ?, 'user', ?, ?, ?)");

        if ($ins->execute([$pseudo, $email, $password, $genre, $date_mort, $temps_jeu])) {
            $message = "<div style='color: #0f0; margin-bottom: 20px;'>✅ Inscription réussie ! Agent enregistré. <br><a href='login.php' style='color: white; text-decoration: underline;'>Connectez-vous ici</a></div>";
        } else {
            $message = "<div style='color: red;'>❌ Erreur lors de l'inscription.</div>";
        }
    }
}

include 'templates/header.php';
?>

    <div class="main-container" style="display: flex; justify-content: center; align-items: center; min-height: 80vh; flex-direction: column;">

        <div class="login-card" style="background: #1f2731; padding: 40px; border-top: 5px solid #ff4655; width: 100%; max-width: 400px; color: white;">
            <h2 style="text-align: center; text-transform: uppercase; margin-bottom: 30px;">Recrutement Agent</h2>

            <?= $message ?>

            <form method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                <div>
                    <label>Nom de code (Pseudo)</label>
                    <input type="text" name="pseudo" required style="width: 100%; padding: 10px; background: #0f1923; border: 1px solid #555; color: white;">
                </div>

                <div>
                    <label>Identifiant (Email)</label>
                    <input type="email" name="email" required style="width: 100%; padding: 10px; background: #0f1923; border: 1px solid #555; color: white;">
                </div>

                <div>
                    <label>Mot de passe</label>
                    <input type="password" name="password" required style="width: 100%; padding: 10px; background: #0f1923; border: 1px solid #555; color: white;">
                </div>

                <button type="submit" class="btn" style="background: #ff4655; color: white; padding: 15px; border: none; font-weight: bold; cursor: pointer; margin-top: 10px; text-transform: uppercase;">
                    Rejoindre le protocole
                </button>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">
                Déjà agent ? <a href="login.php" style="color: #ff4655;">Se connecter</a>
            </p>
        </div>
    </div>

<?php include 'templates/footer.php'; ?>