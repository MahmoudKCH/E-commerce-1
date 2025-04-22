<?php
session_start();
require_once('produit.class.php');

try {
    // Validation des données
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        throw new Exception("ID de produit invalide");
    }

    // Récupération des données
    $id = $_POST['id'];
    $current_image = $_POST['current_image'] ?? null;
    
    // Gestion de l'image
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Nouvelle image uploadée
        $upload_dir = '../img/';
        $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
        $destination = $upload_dir . $file_name;
        
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            throw new Exception("Erreur lors de l'upload de l'image");
        }
        
        // Supprimer l'ancienne image si elle existe
        if ($current_image && file_exists($upload_dir . $current_image)) {
            unlink($upload_dir . $current_image);
        }
    } else {
        // Conserver l'image existante
        $file_name = $current_image;
    }

    // Mise à jour du produit
    $pr = new Produit();
    $pr->modifierProduit(
        $id,
        $_POST['nom'],
        $_POST['description'],
        $_POST['categorie'],
        $_POST['prix'],
        $_POST['stock'],
        $file_name
    );

    $_SESSION['success'] = "Produit mis à jour avec succès";
    header('Location: ../dashboard/produit.php');
    exit;

} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: modifier_produit.php?id=" . $_POST['id']);
    exit;
}

