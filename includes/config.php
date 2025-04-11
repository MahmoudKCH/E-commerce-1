<?php
// Activation du rapport d'erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration des sessions
ini_set('session.cookie_lifetime', 86400); // 1 jour
ini_set('session.gc_maxlifetime', 86400);
session_start();

// Chemins absolus
define('BASE_URL', 'http://localhost/eCommerce/E-commerce1');
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../') . '/');

// Connexion BDD
$db = new PDO('mysql:host=localhost;dbname=eComerce', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
]);

/**
 * Vérifie les privilèges admin avec double validation
 */
function est_admin() {
    // Vérification basique de session
    if (empty($_SESSION['user_id']) || empty($_SESSION['role'])) {
        error_log("Accès refusé: Session incomplète");
        return false;
    }

    // Validation en base de données
    try {
        global $db;
        $stmt = $db->prepare("SELECT role FROM utilisateurs WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        return ($user && $user['role'] === 'admin');
    } catch (PDOException $e) {
        error_log("Erreur vérification admin: " . $e->getMessage());
        return false;
    }
}

// Dans config.php
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>