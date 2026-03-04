<?php
require 'db.php'; // On inclut la connexion à la BDD

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Sécurité max

    // On vérifie si l'email est déjà pris
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $error = "Cet email est déjà utilisé !";
    } else {
        // Insertion du nouvel utilisateur
        $ins = $pdo->prepare("INSERT INTO users (pseudo, email, password, role) VALUES (?, ?, ?, 'user')");
        if ($ins->execute([$pseudo, $email, $password])) {
            echo "Inscription réussie ! <a href='login.php'>Connectez-vous ici</a>";
        }
    }
}
?>

<form method="POST">
    <input type="text" name="pseudo" placeholder="Pseudo" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <button type="submit">S'inscrire</button>
</form>