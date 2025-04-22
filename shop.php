<?php
session_start();
require_once('produit/produit.class.php');
$produit = new Produit();

// Récupérer les catégories de produits 
$categories = $produit->selectionnerCategories();
require_once('user.class.php');
$us = new user();
$x = $us->get_user($_SESSION['email']);
require_once('cart/cart.class.php');
$cart = new Cart();
$cartItemCount = $cart->countCartRowsPerUser($x['id']);

if (isset($_GET['categorie'])) {
    $selectedCategory = $_GET['categorie'];
    $produitsCategorie = $produit->listerProduitsParCategorie($selectedCategory);
} else {
    $produits = $produit->listerProduits();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOP'ini - Boutique</title>
    <link rel="shortcut icon" href="img/SHOPINIlo.png" type="image/x-icon">
    
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
        
        /* Navigation modernisée */
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }
        
        /* Barre de filtres horizontale */
        .filter-bar {
            background: white;
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Style des cartes produit modernes */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        .product-media {
            position: relative;
            height: 200px;
            background: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        
        .product-img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        
        .product-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--primary);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .product-body {
            padding: 1.25rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }
        
        .product-description {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            flex-grow: 1;
        }
        
        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }
        
        .product-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        /* Style du bouton ajouter au panier */
        .add-to-cart-btn {
            border: none;
            background: var(--primary);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        
        .add-to-cart-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.1);
        }
        
        /* Style personnalisé pour la pagination */
        .pagination-custom .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .pagination-custom .page-link {
            color: var(--primary);
        }
        
        /* Avatar utilisateur */
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        /* Badge panier */
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            background: var(--secondary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        /* Footer modernisé */
        .footer {
            background-color: white;
            color: var(--dark);
            padding: 5rem 0 2rem;
            border-top: 1px solid var(--light-gray);
        }
        
        .footer h5 {
            color: var(--dark);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .footer a {
            color: #4b5563;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--primary);
        }
        
        .footer .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background-color: #f1f5f9;
            color: var(--dark);
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .footer .social-link:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .footer ul.list-unstyled li {
            margin-bottom: 0.75rem;
        }
        
        .footer ul.list-unstyled li i {
            width: 20px;
            text-align: center;
            color: var(--primary);
        }
        
        /* Style responsive */
        @media (max-width: 768px) {
            .filter-bar {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/SHOPINILOGO11.png" alt="SHOP'ini" style="width: 150px; height: 45px">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="shop.php">Boutique</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <a href="cart.php" class="btn btn-link position-relative p-0">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span class="cart-badge"><?php echo $cartItemCount; ?></span>
                    </a>
                    
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle p-0" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <?php echo substr($x['nom'], 0, 1); ?>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header"><?php echo $x['nom']; ?></h6></li>
                            <li><a class="dropdown-item" href="dashboard\settings.php"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="hpdashboard\produit.php"><i class="fas fa-box me-2"></i>Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="deconnexion.php"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="container py-4">
        <!-- Barre de filtres horizontale -->
        <div class="filter-bar">
            <div class="filter-group">
                <label for="categoryFilter" class="form-label mb-0">Catégorie:</label>
                <select id="categoryFilter" class="form-select form-select-sm" onchange="location = this.value;">
                    <option value="shop.php">Toutes catégories</option>
                    <?php foreach ($categories as $categorie): ?>
                    <option value="?categorie=<?php echo urlencode($categorie); ?>" 
                        <?php echo (isset($_GET['categorie']) && $_GET['categorie'] === $categorie) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($categorie); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="priceRange" class="form-label mb-0">Prix max:</label>
                <input type="range" class="form-range" min="0" max="10000" step="50" id="priceRange" style="width: 120px;">
                <span id="priceValue" class="ms-2">1000 €</span>
            </div>
            
            <div class="filter-group ms-auto">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="Rechercher...">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Grille de produits -->
        <div class="product-grid">
            <?php 
            $produitsAfficher = isset($produitsCategorie) ? $produitsCategorie : $produits;
            if (empty($produitsAfficher)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <h4 class="alert-heading">Aucun produit trouvé</h4>
                    <p>Nous n'avons trouvé aucun produit correspondant à votre sélection.</p>
                    <a href="shop.php" class="btn btn-primary">Voir tous les produits</a>
                </div>
            </div>
            <?php else: ?>
                <?php foreach ($produitsAfficher as $prod): ?>
                <div class="product-card">
                    <div class="product-media">
                        <img src="img/<?php echo htmlspecialchars($prod['image']); ?>" 
                             class="product-img" 
                             alt="<?php echo htmlspecialchars($prod['nom_produit']); ?>"
                             loading="lazy">
                        <span class="product-badge"><?php echo htmlspecialchars($prod['categorie']); ?></span>
                    </div>
                    <div class="product-body">
                        <h3 class="product-title"><?php echo htmlspecialchars($prod['nom_produit']); ?></h3>
                        <p class="product-description">
                            <?php echo htmlspecialchars(substr($prod['description'], 0, 100)); ?>
                            <?php echo strlen($prod['description']) > 100 ? '...' : ''; ?>
                        </p>
                        <div class="product-footer">
                            <span class="product-price"><?php echo number_format($prod['prix'], 2); ?> €</span>
                            <form action="cart/ajouter_au_panier.php" method="post">
                                <input type="hidden" name="id_user" value="<?php echo $x['id']; ?>">
                                <input type="hidden" name="id_produit" value="<?php echo $prod['id_produit']; ?>">
                                <input type="hidden" name="nom_produit" value="<?php echo htmlspecialchars($prod['nom_produit']); ?>">
                                <input type="hidden" name="prix_produit" value="<?php echo $prod['prix']; ?>">
                                <input type="number" name="quantite" value="1" min="1" class="form-control form-control-sm d-none">
                                <button type="submit" class="add-to-cart-btn" title="Ajouter au panier">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-5">
            <ul class="pagination pagination-custom justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </main>

    <!-- Pied de page -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <img src="img/SHOPINILOGO11.png" alt="SHOP'ini" style="width: 400px; height: 110px" class="mb-3">
                    <p>
                    SHOP'ini est votre destination premium pour les produits high-tech.
                        Nous sélectionnons avec soin chaque article pour vous offrir le meilleur.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-3">Navigation</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php">Accueil</a></li>
                        <li class="mb-2"><a href="shop.php">Boutique</a></li>
                        <li class="mb-2"><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-3">Catégories</h5>
                    <ul class="list-unstyled">
                        <?php foreach (array_slice($categories, 0, 5) as $categorie): ?>
                        <li class="mb-2"><a href="shop.php?categorie=<?= urlencode($categorie) ?>"><?= htmlspecialchars($categorie) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="col-lg-4">
                    <h5 class="mb-3">Contact</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Rue Tech, Sfax, Tunisie</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> contact@SHOP'ini.tn</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +216 12 345 678</li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4 bg-light">
            
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small mb-0">&copy; <?= date('Y') ?> SHOP'ini. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small mb-0">
                        <a href="#">Conditions générales</a> | 
                        <a href="#">Politique de confidentialité</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Gestion de la plage de prix
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        
        if (priceRange && priceValue) {
            priceRange.addEventListener('input', function() {
                priceValue.textContent = this.value + ' €';
            });
        }
        
        // Animation au survol des produits
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.15)';
                card.querySelector('.product-img').style.transform = 'scale(1.05)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
                card.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
                card.querySelector('.product-img').style.transform = '';
            });
        });
    </script>
</body>
</html>