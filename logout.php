<?php
// logout.php
session_start();

// On détruit toutes les données de session
$_SESSION = array();
session_destroy();

// On redirige vers la page de login (Authentification)
header('Location: login.php');
exit();