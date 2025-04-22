<?php
session_start();
require_once('user.class.php');
$us = new user();
$x = $us->get_user($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="img/SHOPINIlo.png" type="image/x-icon" />
    <title>SHOP'ini - Confirmation de commande</title>
    
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #0182ca;
            --primary-dark: #016ba3;
            --secondary: #14c18e;
            --dark: #1e293b;
            --light: #f8fafc;
            --light-gray: #e2e8f0;
            --success: #10b981;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f8f9fa;
            padding-top: 80px;
        }
        
        .confirmation-command {
            min-height: 60vh;
            display: flex;
            align-items: center;
        }
        
        .confirmation-card {
            background: white;
            border-radius: 12px;
            padding: 3rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        /* Footer identique aux autres pages */
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
    </style>
</head>

<body>


    <!-- Confirmation de commande -->
    <div class="container-fluid confirmation-command py-5">
        <div class="container">
            <div class="confirmation-card animate__animated animate__fadeIn">
                <i class="fas fa-check-circle text-success fa-5x mb-4"></i>
                <h2 class="text-success mb-3">Commande confirmée !</h2>
                <p class="lead mb-4">Votre commande a été confirmée avec succès. Vous recevrez sous peu un email de confirmation avec les détails de votre commande.</p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="shop.php" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la boutique
                    </a>
                </div>
            </div>
        </div>
    </div>



    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const confirmationCard = document.querySelector('.confirmation-card');
            setTimeout(() => {
                confirmationCard.classList.add('animate__fadeIn');
            }, 100);
        });
    </script>
</body>
</html>