<?php
require_once 'config.php';

if (est_connecte()) {
    header("Location: index.php");
    exit();
}

$erreur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = securiser($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    
    $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        
        header("Location: index.php");
        exit();
    } else {
        $erreur = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="assets/css/homeStyle.css" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h1>Connexion</h1>
        <?php if ($erreur): ?>
            <div class="erreur"><?= securiser($erreur) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <button type="submit" class="blue-button">Se connecter</button>
        </form>
        <p>Pas encore de compte? <a href="inscription.php">S'inscrire</a></p>
    </div>
</body>
</html>

C:\laragon\www\projet\products.php