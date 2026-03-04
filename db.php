<?php
$host = 'localhost';
$port = '3307'; // Le port qu'on a changé dans XAMPP
$dbname = 'projet_valorant'; // Le nom exact de la base créée
$username = 'root';
$password = ''; // Vide (par défaut XAMPP) OU le mot de passe de ton pote s'il en a un

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>