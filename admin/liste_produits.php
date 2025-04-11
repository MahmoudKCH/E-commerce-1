<?php
require_once __DIR__ . '/../includes/config.php';

if (!est_admin()) {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

try {
    $stmt = $db->query("SELECT * FROM produits ORDER BY created_at DESC");
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/adminStyle.css">
    <style>
        .produit-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .produit-table th, .produit-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .produit-table th {
            background-color: #f4f4f4;
        }
        .action-btn {
            padding: 6px 12px;
            margin: 0 3px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-modifier {
            background-color: #4CAF50;
            color: white;
        }
        .btn-supprimer {
            background-color: #f44336;
            color: white;
        }
        .btn-ajouter {
            background-color: #2196F3;
            color: white;
            padding: 10px 15px;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="admin-container">
        <h1>Liste des Produits</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success">Produit modifié avec succès!</div>
        <?php endif; ?>

        <table class="produit-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit): ?>
                <tr>
                    <td><?= htmlspecialchars($produit['id']) ?></td>
                    <td>
                        <?php if (!empty($produit['image'])): ?>
                            <img src="<?= BASE_URL ?>/images/collection/<?= htmlspecialchars($produit['image']) ?>" 
                                 alt="<?= htmlspecialchars($produit['nom']) ?>" width="50">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($produit['nom']) ?></td>
                    <td><?= number_format($produit['prix'], 2) ?> €</td>
                    <td><?= htmlspecialchars($produit['categorie']) ?></td>
                    <td>
                        <a href="modifier_produit.php?id=<?= $produit['id'] ?>" class="action-btn btn-modifier">Modifier</a>
                        <a href="supprimer_produit.php?id=<?= $produit['id'] ?>" 
                           class="action-btn btn-supprimer" 
                           onclick="return confirm('Êtes-vous sûr?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="ajouter_produit.php" class="btn-ajouter">+ Ajouter un produit</a>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>