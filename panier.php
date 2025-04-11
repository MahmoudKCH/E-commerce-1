<?php
require_once 'config.php';

if (!est_connecte()) {
    header("Location: connexion.php");
    exit();
}

// Ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produit_id'])) {
    $produit_id = (int)$_POST['produit_id'];
    $quantite = (int)$_POST['quantite'];
    $user_id = $_SESSION['user_id'];
    
    // Vérifier si le produit existe
    $stmt = $db->prepare("SELECT id FROM produits WHERE id = ?");
    $stmt->execute([$produit_id]);
    
    if ($stmt->fetch()) {
        // Vérifier si le produit est déjà dans le panier
        $stmt = $db->prepare("SELECT id FROM panier WHERE user_id = ? AND produit_id = ?");
        $stmt->execute([$user_id, $produit_id]);
        
        if ($stmt->fetch()) {
            // Mise à jour de la quantité
            $stmt = $db->prepare("UPDATE panier SET quantite = quantite + ? WHERE user_id = ? AND produit_id = ?");
            $stmt->execute([$quantite, $user_id, $produit_id]);
        } else {
            // Ajout au panier
            $stmt = $db->prepare("INSERT INTO panier (user_id, produit_id, quantite) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $produit_id, $quantite]);
        }
    }
    
    header("Location: panier.php");
    exit();
}

// Suppression d'un produit du panier
if (isset($_GET['supprimer'])) {
    $id = (int)$_GET['supprimer'];
    $stmt = $db->prepare("DELETE FROM panier WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    header("Location: panier.php");
    exit();
}

// Récupération du panier
$stmt = $db->prepare("
    SELECT p.id, p.nom, p.prix, p.image, pan.quantite, pan.id as panier_id 
    FROM panier pan
    JOIN produits p ON pan.produit_id = p.id
    WHERE pan.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($items as $item) {
    $total += $item['prix'] * $item['quantite'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>
    <link href="assets/css/homeStyle.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container">
        <h1>Mon Panier</h1>
        
        <?php if (empty($items)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <table class="panier-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <img src="images/collection/<?= securiser($item['image']) ?>" alt="<?= securiser($item['nom']) ?>" width="50">
                            <?= securiser($item['nom']) ?>
                        </td>
                        <td><?= number_format($item['prix'], 2) ?> €</td>
                        <td><?= $item['quantite'] ?></td>
                        <td><?= number_format($item['prix'] * $item['quantite'], 2) ?> €</td>
                        <td>
                            <a href="panier.php?supprimer=<?= $item['panier_id'] ?>" class="btn-supprimer">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total</td>
                        <td colspan="2"><?= number_format($total, 2) ?> €</td>
                    </tr>
                </tfoot>
            </table>
            
            <div class="panier-actions">
                <a href="index.php" class="blue-button">Continuer mes achats</a>
                <a href="commande.php" class="blue-button">Passer la commande</a>
            </div>
        <?php endif; ?>
    </main>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>