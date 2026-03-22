<?php
// delete_game.php
require_once 'vendor/autoload.php';

use Gamekeeper\Model\admin_model\Game;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: dashboard.php');
    exit;
}

$game = new Game();
$game_data = $game->getById($id);

if (!$game_data) {
    header('Location: dashboard.php');
    exit;
}

$message = '';

if (isset($_POST['confirm'])) {
    try {
        $game->delete($id);
        header('Location: dashboard.php?deleted=1');
        exit;
    } catch (Exception $e) {
        $message = "Erreur :" . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un Jeu</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">

            <?php if ($message): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <h1>Supprimer un Jeu</h1>           

            <form method="post">
                <button type="submit" name="confirm">Confirmer la suppression</button>
            </form>

            <button><a href="index.php?page=admin/dashboard">Annuler</a></button>

        </div>
    </div>
</body>
</html>