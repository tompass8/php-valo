<?php
session_start();
require_once 'db.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("DELETE FROM games WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
}

header('Location: profil.php');
exit();