<?php
require_once __DIR__ . '/../../vendor/autoload.php';


require_once './src/Views/Navigation/Header.php';



use Gamekeeper\Controlleur\UserController;

$controller = new UserController();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

$user = (new \Gamekeeper\Model\User())->getuserbyid($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="src/Views/auht.css">
</head>
<body>
<div class="auth-page">
    <div class="auth-container">

        <div class="avatar">
            <?= strtoupper(substr($user['firstName'], 0, 1)) ?>
        </div>
        <div class="profil-name">
            <?= htmlspecialchars($user['firstName']) ?>
            <?= htmlspecialchars($user['lastName']) ?>
        </div>
        <div class="profil-email"><?= htmlspecialchars($user['email']) ?></div>

        <div class="info-grid">
            <div class="info-row">
                <span class="info-label">Prénom</span>
                <span class="info-value"><?= htmlspecialchars($user['firstName']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Nom</span>
                <span class="info-value"><?= htmlspecialchars($user['lastName']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value"><?= htmlspecialchars($user['email']) ?></span>
            </div>
        </div>

        <a href="index.php?page=modifieprofil" class="btn">Modifier le profil</a>
        <a href="index.php?page=Deconnexion" class="btn">Se déconnecter</a>

    </div>
</div>
<?php
require_once './src/Views/Navigation/Footer.php'
?>