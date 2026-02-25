<?php
session_start();
require_once 'db.php';

// Vérifier que l'utilisateur est connecté et qu'on a un ID de jeu
if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $gameId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    // Sécurité : On vérifie que le jeu appartient bien à l'utilisateur connecté
    $stmt = $pdo->prepare("DELETE FROM games WHERE id = ? AND user_id = ?");
    $stmt->execute([$gameId, $userId]);
}

// Retour direct au profil
header('Location: profil.php');
exit();