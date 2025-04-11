<?php
session_start();
require_once '../config.php';
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
$stmt = $db->query("SELECT * FROM produits");
$produits = $stmt->fetchAll();
?>
<!-- Affichez les produits avec des boutons de modification/suppression -->