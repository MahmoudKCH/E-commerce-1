<?php
require_once __DIR__ . '/../includes/config.php';

// Vérification robuste de l'admin
if (!est_admin()) {
    $_SESSION['redirect_reason'] = 'admin_required';
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

// [Récupération et traitement du produit...]
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Produit</title>
    <style>
        .error-message {
            color: #d9534f;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #d9534f;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php 
    // Affichage des erreurs de permission
    if (isset($_GET['erreur']) && $_GET['erreur'] === 'acces_refuse'):
    ?>
        <div class="error-message">
            Accès refusé : Privilèges insuffisants. 
            <a href="<?= BASE_URL ?>/login.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>">
                Se connecter en tant qu'admin
            </a>
        </div>
    <?php endif; ?>

    <!-- [Formulaire de modification...] -->
</body>
</html>