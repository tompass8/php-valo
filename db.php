<?php
$host = 'localhost';
$dbname = 'projet_valorant'; // Vérifie bien que c'est le nom que tu as mis dans phpMyAdmin
$username = 'root';
$password = ''; // Vide par défaut sur XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>