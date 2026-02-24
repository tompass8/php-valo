<?php
session_start();
require 'db.php';

// Sécurité
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Accès non autorisé");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("DELETE FROM games WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: admin.php');
exit();
?>