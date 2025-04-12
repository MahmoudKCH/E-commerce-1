<?php
session_start();
$host = "localhost";
$dbname = "eComerce";
$user = "root";
$pass = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES utf8");
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonctions utiles
function est_connecte() {
    return isset($_SESSION['user_id']);
}

function est_admin() {
    return est_connecte() && $_SESSION['role'] === 'admin';
}

function securiser($donnee) {
    return htmlspecialchars(trim($donnee));
}
?>