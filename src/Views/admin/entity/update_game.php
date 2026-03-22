<?php
// update_game.php
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../db.php';

use Gamekeeper\Model\admin_model\Game;
use Gamekeeper\Model\admin_model\Plateform;
use Gamekeeper\Model\admin_model\Categorie;
use Gamekeeper\Model\admin_model\Publishers;

function securityInput($input) {
    return trim(htmlspecialchars($input));
}

$message = '';
$game_data = null;

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

if (isset($_POST['submit'])) {
    $title = securityInput($_POST['title']);
    $description  = securityInput($_POST['description']);
    $release_date = securityInput($_POST['release_date']);
    $cover_image  = securityInput($_POST['cover_image']);
    $platform_id  = (int)$_POST['platform_id'];
    $categorie_id = (int)$_POST['categorie_id'];
    $publisher_id = (int)$_POST['publisher_id'];

    if (empty($title) || empty($description) || empty($release_date) || empty($cover_image) || empty($platform_id) || empty($categorie_id) || empty($publisher_id)) {
        $message = "Tous les champs sont requis";
    } else {
        try {
            $game->update($id, $title, $description, $release_date, $cover_image, $platform_id, $categorie_id, $publisher_id);
            $message = "Jeu mis à jour avec succés ";
            $game_data = $game->getById($id);
        } catch (Exception $e) {
            $message = "Erreur :" . $e->getMessage();
        }
    }
}

$platform  = new Plateform();
$platforms = $platform->getAll();

$categorie  = new Categorie();
$categories = $categorie->getAll();

$publisher  = new Publishers();
$publishers = $publisher->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Jeu</title>
    <link rel="stylesheet" href="src/Views/admin/entity/style.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">

            <?php if ($message): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <h1>Modifier un Jeu</h1>

                <label>Titre du Jeu</label>
                <input type="text" name="title" value="<?= htmlspecialchars($game_data['title']) ?>"><br>

                <label>Description</label>
                <textarea name="description" rows="4"><?= htmlspecialchars($game_data['description']) ?></textarea><br>

                <label>Date de Sortie</label>
                <input type="date" name="release_date" value="<?= htmlspecialchars($game_data['release_date']) ?>"><br>

                <label>Image de Couverture</label>
                <?php if (!empty($game_data['cover_image'])): ?>
                <img src="../../upload/<?= $game_data['cover_image'] ?>" style="height:60px; border-radius:6px; display:block; margin-bottom:8px">
                <?php endif; ?>
                <input type="file" name="cover_image" accept="image/jpeg,image/png,image/webp"><br>

                <label>Plateforme</label>
                <select name="platform_id">
                    <?php foreach ($platforms as $plt): ?>
                        <option value="<?= $plt['id'] ?>" <?= $plt['id'] == $game_data['platform_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($plt['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label>Catégorie</label>
                <select name="categorie_id">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $game_data['categorie_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label>Éditeur (Publisher)</label>
                <select name="publisher_id">
                    <?php foreach ($publishers as $pub): ?>
                        <option value="<?= $pub['id'] ?>" <?= $pub['id'] == $game_data['publisher_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pub['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <button type="submit" name="submit">Mettre à jour</button>
            </form>

            <button><a href="index.php?page=admin/dashboard">Annuler</a></button>

        </div>
    </div>
</body>
</html>