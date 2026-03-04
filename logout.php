<?php
session_start(); // On récupère la session en cours
session_unset(); // On vide toutes les variables de session
session_destroy(); // On détruit complètement la session

// On redirige l'utilisateur vers la page de connexion (ou l'accueil)
header("Location: login.php");
exit();
?>