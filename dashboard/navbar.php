<?php
// Vérifier si la session est déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../user.class.php');
require_once('../cart/cart.class.php');

$us = new user();
$x = $us->get_user($_SESSION['email']);

$cart = new Cart();
$cartItemCount = $cart->countCartRowsPerUser($x['id']);

$isAdmin = ($x['role'] == 'admin' || $x['role'] == 'super_admin');
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="../index.php">
        <img src="..\img\SHOPINILOGO11.png" alt="SHOP'ini" style="width: 150px; height: 45px">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../shop.php">Boutique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../contact.php">Contact</a>
                </li>
                <?php if($isAdmin): ?>
                <li class="nav-item">
                    <a class="nav-link" href="produit.php">Dashboard</a>
                </li>
                <?php endif; ?>
            </ul>
            
            <div class="d-flex align-items-center gap-3">
                <a href="../cart.php" class="btn btn-link position-relative p-0">
                    <i class="fas fa-shopping-cart fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $cartItemCount ?>
                    </span>
                </a>
                
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle p-0" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <?= substr($x['nom'], 0, 1) ?>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header"><?= $x['nom'] ?></h6></li>
                        <li>
                            <a class="dropdown-item" href="settings.php">
                                <i class="fas fa-user me-2"></i>Profil
                            </a>
                        </li>
                        <?php if($isAdmin): ?>
                        <li>
                            <a class="dropdown-item" href="produit.php">
                                <i class="fas fa-box me-2"></i>Produits
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="tables.php">
                                <i class="fas fa-users me-2"></i>Utilisateurs
                            </a>
                        </li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="../deconnexion.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>