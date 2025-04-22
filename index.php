<?php
session_start();
require_once('produit/produit.class.php');
require_once('cart/cart.class.php');
require_once('user.class.php');

$us = new user();
$x = $us->get_user($_SESSION['email']);

$cart = new Cart();
$cartItemCount = $cart->countCartRowsPerUser($x['id']);

$produit = new Produit();
$categories = $produit->selectionnerCategories();
$featuredProducts = $produit->listerProduits(); // Produits vedettes
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOP'ini | Accueil</title>
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
    
    .navbar {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
    }
    
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
    
    /* Styles spécifiques à l'index */
    .hero-section {
        background: linear-gradient(135deg, rgba(1, 130, 202, 0.1) 0%, rgba(20, 193, 142, 0.05) 100%);
        padding: 6rem 0;
        margin-bottom: 3rem;
        border-radius: 12px;
    }
    
    .feature-box {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .feature-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .feature-icon {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }
    
    /* Footer modifié avec couleurs sombres */
    .footer {
        background-color: white;
        color: var(--dark);
        padding: 5rem 0 2rem;
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
    
    .footer ul.list-unstyled li {
        margin-bottom: 0.75rem;
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
    
    .footer .text-light {
        color: var(--dark) !important;
    }
    
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }
    }
</style>
</head>
<body>
    <!-- Navigation identique à shop.php -->
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
                        <a class="nav-link active" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Boutique</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <a href="cart.php" class="btn btn-link position-relative p-0">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span class="cart-badge"><?= $cartItemCount ?></span>
                    </a>
                    
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle p-0" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <?= substr($x['nom'], 0, 1) ?>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header"><?= $x['nom'] ?></h6></li>
                            <li><a class="dropdown-item" href="dashboard\settings.php"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="dashboard\produit.php"><i class="fas fa-box me-2"></i>Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="deconnexion.php"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (spécifique à l'index) -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">L'innovation technologique à portée de main</h1>
                    <p class="lead mb-4">Découvrez notre sélection exclusive de produits high-tech soigneusement choisis pour leur qualité et performance.</p>
                    <!-- <a href="shop.php" class="btn btn-primary btn-lg px-4">Explorer la boutique</a> -->
                </div>
                <div class="col-lg-6">
                    <img src="img/WATCH2.png" alt="Produits SHOP'ini" class="img-fluid ">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h5 class="mb-2">Livraison rapide</h5>
                        <p class="text-muted mb-0">Expédition sous 24h</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5 class="mb-2">Paiement sécurisé</h5>
                        <p class="text-muted mb-0">Cryptage SSL</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <h5 class="mb-2">Retours faciles</h5>
                        <p class="text-muted mb-0">30 jours pour changer d'avis</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5 class="mb-2">Support 24/7</h5>
                        <p class="text-muted mb-0">Assistance technique</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Produits vedettes -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-3">Nos Produits Vedettes</h2>
                    <p class="text-muted">Découvrez notre sélection de produits les plus populaires</p>
                </div>
            </div>
            
            <div class="product-grid">
                <?php foreach ($featuredProducts as $prod): ?>
                <div class="product-card">
                    <div class="product-media">
                        <img src="img/<?= $prod['image'] ?>" 
                             class="product-img" 
                             alt="<?= $prod['nom_produit'] ?>"
                             loading="lazy">
                        <span class="product-badge"><?= $prod['categorie'] ?></span>
                    </div>
                    <div class="product-body">
                        <h3 class="product-title"><?= $prod['nom_produit'] ?></h3>
                        <p class="product-description">
                            <?= substr($prod['description'], 0, 100) ?>
                            <?= strlen($prod['description']) > 100 ? '...' : '' ?>
                        </p>
                        <div class="product-footer">
                            <span class="product-price"><?= number_format($prod['prix'], 2) ?> €</span>
                            <form action="cart/ajouter_au_panier.php" method="post">
                                <input type="hidden" name="id_user" value="<?= $x['id'] ?>">
                                <input type="hidden" name="id_produit" value="<?= $prod['id_produit'] ?>">
                                <input type="hidden" name="nom_produit" value="<?= htmlspecialchars($prod['nom_produit']) ?>">
                                <input type="hidden" name="prix_produit" value="<?= $prod['prix'] ?>">
                                <input type="hidden" name="quantite" value="1"> <!-- Ajout de ce champ -->
                                <button type="submit" class="add-to-cart-btn" title="Ajouter au panier">
                                <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>     
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer identique à shop.php -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    
                    <img src="img/SHOPINILOGO11.png" alt="SHOP'ini" style="width: 400px; height: 110px" class="mb-3">
                    <p class="text-light">
                    SHOP'ini est votre destination premium pour les produits high-tech.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4">
                    <h5 class="text-white mb-3">Navigation</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php" class="text-light">Accueil</a></li>
                        <li class="mb-2"><a href="shop.php" class="text-light">Boutique</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-light">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-4">
                    <h5 class="text-white mb-3">Catégories</h5>
                    <ul class="list-unstyled">
                        <?php foreach (array_slice($categories, 0, 5) as $categorie): ?>
                        <li class="mb-2"><a href="shop.php?categorie=<?= urlencode($categorie) ?>" class="text-light"><?= $categorie ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <h5 class="text-white mb-3">Contact</h5>
                    <ul class="list-unstyled text-light">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Rue Tech, Sfax, Tunisie</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> contact@SHOP'ini.tn</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +216 12 345 678</li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4 bg-secondary">
            
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small text-light mb-0">&copy; <?= date('Y') ?> SHOP'ini. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small text-light mb-0">
                        <a href="#" class="text-light">Conditions générales</a> | 
                        <a href="#" class="text-light">Politique de confidentialité</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation des cartes produit
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