<?php
require_once('user.class.php');
session_start();
$user = new User();
if (isset($_POST['user_id']) && isset($_POST['new_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    if ($new_role == 'admin') {
        $user ->change_role_to_admin($user_id);
    } elseif ($new_role == 'user') {
        $user ->change_role_to_user($user_id);
    }
    header('location: dashboard/tables.php');
    exit();
} else {
    header('Location: error.php'); // Rediriger vers une page d'erreur
    exit();
}
?>
