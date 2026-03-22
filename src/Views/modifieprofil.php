<?php
require_once __DIR__ . '/../../vendor/autoload.php';

require_once './src/Views/Navigation/Header.php';



use Gamekeeper\Controlleur\UserController;

$controller = new UserController();
$data = $controller->profil();
$user= $data['user'];
$error = $data['error'];
$success = $data['success'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le profil</title>
    <link rel="stylesheet" href="src/Views/auht.css">
    
</head>
<body>
<div class="auth-page">
    <div class="auth-container">
        <h1>Modifier le profil</h1>

        <!-- Modifier infos -->
        <p class="section-title"> Informations personnelles</p>
        <form method="POST">
            <input type="text" name="firstName"value="<?= htmlspecialchars($user['firstName']) ?>"placeholder="Prénom" required>
            <input type="text" name="lastName"value="<?= htmlspecialchars($user['lastName']) ?>"placeholder="Nom" required>
            <input type="email"name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Email" required>
        
        </form>

        <p class="section-title">  Changer le mot de passe</p>
        <form method="POST">
            <input type="password" name="current_password" placeholder="Mot de passe actuel" required>
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
            <button type="submit" name="update_password" class="btn"> Modifier </button>
        </form>

        <form method="POST">
            <a href="index.php?page=profil" name="delete_account" class="btn"> Annuler </a>
        </form>

    </div>
</div>
<?php
require_once './src/Views/Navigation/Footer.php'
?>