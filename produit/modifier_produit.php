<?php
session_start();
require_once('produit.class.php');

// Vérification de l'ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID de produit invalide";
    header('Location: ../dashboard/dashboard.php');
    exit;
}

$pr = new Produit();
$product = $pr->getProduct($_GET['id']);

if (!$product) {
    $_SESSION['error'] = "Produit non trouvé";
    header('Location: ../dashboard/dashboard.php');
    exit;
}

// Récupération des données
$id = $product['id_produit'];
$nom = $product['nom_produit']; 
$desc = $product['description']; 
$cat = $product['categorie']; 
$prix = $product['prix']; 
$stock = $product['stock'];
$image = $product['image'];
$categories = $pr->selectionnerCategories();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOP'ini | Modifier Produit</title>
    <link rel="shortcut icon" href="../img/SHOPINIlo.png" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
    /* Palette de couleurs mise à jour */
    :root {
        --primary: #0182ca;       /* Nouveau bleu */
        --primary-dark: #016ba3;  /* Bleu plus foncé */
        --secondary: #14c18e;     /* Nouveau vert */
        --dark: #1e293b;
        --light: #f8fafc;
        --light-gray: #e2e8f0;
    }
    
    body {
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        background-color: #f8f9fa;
        padding-top: 80px;
    }
    
    .form-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2.5rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
    }
    
    .current-image {
        max-width: 200px;
        height: auto;
        border-radius: 8px;
        border: 1px solid var(--light-gray);
        transition: transform 0.3s ease;
    }
    
    .current-image:hover {
        transform: scale(1.05);
    }
    
    .form-label {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border: 1px solid var(--light-gray);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(1, 130, 202, 0.1);
    }
    
    .btn-primary {
        background-color: var(--primary);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background-color: var(--light-gray);
        color: var(--dark);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background-color: #d1d5db;
        transform: translateY(-2px);
    }
    
    h2 {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-gray);
    }
    
    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
        border: none;
        border-radius: 8px;
    }
    
    .text-muted {
        color: #64748b !important;
    }
    
    .small {
        font-size: 0.875rem;
    }
    
    .file-upload {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    
    .file-upload-btn {
        border: 1px dashed var(--light-gray);
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .file-upload-btn:hover {
        border-color: var(--primary);
        background-color: rgba(1, 130, 202, 0.05);
    }
    
    .file-upload-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    @media (max-width: 768px) {
        .form-container {
            padding: 1.5rem;
        }
    }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="form-container">
            <h2><i class="fas fa-edit me-2"></i>Modifier le produit</h2>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="update_Product.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                
                <!-- Section Image -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Image actuelle</label>
                            <?php if ($image): ?>
                                <div>
                                    <img src="../img/<?= htmlspecialchars($image) ?>" class="current-image">
                                    <input type="hidden" name="current_image" value="<?= htmlspecialchars($image) ?>">
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">Aucune image disponible</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nouvelle image</label>
                            <p class="text-muted small mb-3">Laisser vide pour conserver l'image actuelle</p>
                            <div class="file-upload">
                                <label class="file-upload-btn">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2" style="color: var(--primary);"></i>
                                    <div>Cliquez pour télécharger une nouvelle image</div>
                                    <input type="file" class="file-upload-input" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Informations produit -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nom du produit</label>
                            <input type="text" class="form-control" name="nom" 
                                   value="<?= htmlspecialchars($nom) ?>" required minlength="3" maxlength="255">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Catégorie</label>
                            <select class="form-select" name="categorie" required>
                                <option value="">Sélectionnez une catégorie</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category) ?>" 
                                        <?= ($category == $cat) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Prix (€)</label>
                            <input type="number" step="0.01" class="form-control" name="prix" 
                                   value="<?= htmlspecialchars($prix) ?>" required min="0.01" max="9999.99">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" class="form-control" name="stock" 
                                   value="<?= htmlspecialchars($stock) ?>" required min="0" max="9999">
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="5" required><?= htmlspecialchars($desc) ?></textarea>
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="../dashboard/produit.php" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation pour le téléchargement de fichier
        document.querySelector('.file-upload-input').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : "Aucun fichier sélectionné";
            const uploadBtn = document.querySelector('.file-upload-btn');
            uploadBtn.innerHTML = `
                <i class="fas fa-check-circle fa-2x mb-2" style="color: var(--secondary);"></i>
                <div>${fileName}</div>
                <small class="text-muted">Cliquez pour changer</small>
            `;
        });
    </script>
</body>
</html>