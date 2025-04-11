<?php
require_once 'config.php';

if (est_connecte()) {
    header("Location: index.php");
    exit();
}

$erreur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = securiser($_POST['nom']);
    $email = securiser($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirmation = $_POST['confirmation'];
    
    // Validation
    if ($mot_de_passe !== $confirmation) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $db->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $erreur = "Cet email est déjà utilisé.";
        } else {
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (?, ?, ?, 'user')");
            $stmt->execute([$nom, $email, $hash]);
            
            header("Location: connexion.php?inscription=success");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="assets/css/homeStyle.css" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h1>Inscription</h1>
        <?php if ($erreur): ?>
            <div class="erreur"><?= securiser($erreur) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <div class="form-group">
                <label for="confirmation">Confirmer le mot de passe:</label>
                <input type="password" id="confirmation" name="confirmation" required>
            </div>
            <button type="submit" class="blue-button">S'inscrire</button>
        </form>
        <p>Déjà un compte? <a href="connexion.php">Se connecter</a></p>
    </div>
</body>
</html>