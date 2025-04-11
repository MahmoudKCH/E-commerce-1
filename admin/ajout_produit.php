<?php
require_once '../config.php';

if (!est_admin()) {
    header("Location: ../index.php");
    exit();
}

$erreur = '';
$categories = ['Headphones', 'Smartwatch', 'Mobile', 'Tablet', 'Laptop'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = securiser($_POST['nom']);
    $prix = (float)$_POST['prix'];
    $categorie = securiser($_POST['categorie']);
    
    // Validation
    if (empty($nom) || $prix <= 0 || empty($categorie)) {
        $erreur = "Veuillez remplir tous les champs correctement.";
    } else {
        // Gestion de l'upload de l'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $extensions_autorisees = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array(strtolower($extension), $extensions_autorisees)) {
                $nom_image = uniqid() . '.' . $extension;
                $destination = "../images/collection/" . $nom_image;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    // Insertion en base de données
                    $stmt = $db->prepare("INSERT INTO produits (nom, prix, categorie, image) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$nom, $prix, $categorie, $nom_image]);
                    
                    header("Location: liste_produits.php");
                    exit();
                } else {
                    $erreur = "Erreur lors de l'upload de l'image.";
                }
            } else {
                $erreur = "Format d'image non supporté. Utilisez JPG, PNG ou GIF.";
            }
        } else {
            $erreur = "Veuillez sélectionner une image.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
    <link href="../assets/css/adminStyle.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <main class="admin-container">
        <h1>Ajouter un produit</h1>
        
        <?php if ($erreur): ?>
            <div class="erreur"><?= securiser($erreur) ?></div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data" class="produit-form">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            
            <div class="form-group">
                <label for="prix">Prix (€):</label>
                <input type="number" id="prix" name="prix" step="0.01" min="0" required>
            </div>
            
            <div class="form-group">
                <label for="categorie">Catégorie:</label>
                <select id="categorie" name="categorie" required>
                    <option value="">-- Sélectionnez --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat ?>"><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            
            <button type="submit" class="blue-button">Ajouter</button>
            <a href="liste_produits.php" class="btn-annuler">Annuler</a>
        </form>
    </main>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>