<?php
require_once __DIR__ . '/../../vendor/autoload.php';

require_once './src/Views/Navigation/Header.php';


use Gamekeeper\Controlleur\UserController;

$controller = new UserController();
$error = $controller->login();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="src/Views/auht.css">
</head>
<body>
<div class="auth-page">
    <div class="auth-container">
        <h1>Connexion</h1>
        <form method="POST">
            <input type="email"  name="email"  placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="submit" class="btn">Se connecter</button>
        </form>
        <p>Pas encore de compte ? <a href="index.php?page=register" class="back-link">Inscrivez-vous</a></p>
    </div>
</div>
<?php
require_once './src/Views/Navigation/Footer.php'

?>
</body>
</html>