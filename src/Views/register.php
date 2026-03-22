<?php
require_once __DIR__ . '/../../vendor/autoload.php';



require_once './src/Views/Navigation/Header.php';

use Gamekeeper\Controlleur\UserController;

$controller = new UserController();
$error = $controller->register();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="src/Views/auht.css">
</head>
<body>
<div class="auth-page">
    <div class="auth-container">
        <h1>Inscription</h1>
        <?php if (!empty($error)) : ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['success'])) : ?>
            <p class="success">Inscription réussie ! Connectez-vous.</p>
        <?php endif; ?>
        <form method="POST">
            <input type="text"  name="firstName" placeholder="Prénom" required>
            <input type="text" name="lastName" placeholder="Nom"  required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
            <button type="submit" name="submit" class="btn">S'inscrire</button>
        </form>
        <p>Vous avez déjà un compte ? <a href="index.php?page=login" class="back-link">Connectez-vous</a></p>
    </div>
</div>
<?php
require_once './src/Views/Navigation/Footer.php'

?>
</body>
</html>