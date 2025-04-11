<?php
require_once '../config.php';

if (!est_admin()) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: liste_produits.php");
    exit();
}

$id = (int)$_GET['id'];
$categories = ['Headphones', 'Smartwatch', 'Mobile', 'Tablet', 'Laptop'];
$erreur = '';

// Récupération du produit
$stmt = $db->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch();

if (!$produit) {
    header("Location: liste_produits.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = securiser($_POST['nom']);
    $prix = (float)$_POST['prix'];
    $categorie = securiser($_POST['categorie']);
    
    // Validation
    if (empty($nom) || $prix <= 0 || empty($categorie)) {
        $erreur = "Veuillez remplir tous les champs correctement.";
    } else {
        // Mise à jour des données de base
        $donnees = [$nom, $prix, $categorie];
        
        // Gestion de l'image si une nouvelle est fournie
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $extensions_autorisees = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array(strtolower($extension), $extensions_autorisees)) {
                // Supprimer l'ancienne image
                if (file_exists("../images/collection/" . $produit['image'])) {
                    unlink("../images/collection/" . $produit['image']);
                }
                
                $nom_image = uniqid() . '.' . $extension;
                $destination = "../images/collection/" . $nom_image;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $donnees[] = $nom_image;
                    $requete = "UPDATE produits SET nom = ?, prix = ?, categorie = ?, image = ? WHERE id = ?";
                } else {
                    $erreur = "Erreur lors de l'upload de l'image.";
                }
            } else {
                $erreur = "Format d'image non supporté. Utilisez JPG, PNG ou GIF.";
            }
        } else {
            $requete = "UPDATE produits SET nom = ?, prix = ?, categorie = ? WHERE id = ?";
        }
        
        if (empty($erreur)) {
            $donnees[] = $id;
            $stmt = $db->prepare($requete);
            $stmt->execute($donnees);
            
            header("Location: liste_produits.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un produit</title>
    <link href="../assets/css/adminStyle.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <main class="admin-container">
        <h1>Modifier un produit</h1>
        
        <?php if ($erreur): ?>
            <div class="erreur"><?= securiser($erreur) ?></div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data" class="produit-form">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?= securiser($produit['nom']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="prix">Prix (€):</label>
                <input type="number" id="prix" name="prix" step="0.01" min="0" value="<?= $produit['prix'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="categorie">Catégorie:</label>
                <select id="categorie" name="categorie" required>
                    <option value="">-- Sélectionnez --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat ?>" <?= $cat === $produit['categorie'] ? 'selected' : '' ?>>
                            <?= $cat ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Image actuelle:</label>
                <img src="../images/collection/<?= securiser($produit['image']) ?>" alt="<?= securiser($produit['nom']) ?>" width="100">
            </div>
            
            <div class="form-group">
                <label for="image">Nouvelle image (laisser vide pour conserver l'actuelle):</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            
            <button type="submit" class="blue-button">Enregistrer</button>
            <a href="liste_produits.php" class="btn-annuler">Annuler</a>
        </form>
    </main>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>