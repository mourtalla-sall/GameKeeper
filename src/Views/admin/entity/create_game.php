<?php
// require_once 'vendor/autoload.php';

use Model\admin_model\Game;
use Model\admin_model\Plateform;
use Model\admin_model\Categorie;
use Model\admin_model\Publishers;

function securityInput($input) {
    return trim(htmlspecialchars($input));
}

$message = '';

if (isset($_POST['submit'])) {
    $title = securityInput($_POST['title']);
    $description = securityInput($_POST['description']);
    $release_date = securityInput($_POST['release_date']);
    $cover_image = securityInput($_POST['cover_image']);
    $platform_id  = (int)$_POST['platform_id'];
    $categorie_id = (int)$_POST['categorie_id'];
    $publisher_id = (int)$_POST['publisher_id'];


    if (empty($title) || empty($description) || empty($release_date) || empty($cover_image) || empty($platform_id) || empty($categorie_id) || empty($publisher_id)) {
        $message = "Tous les champs sont requis";
    } else {
        try {
            $game = new Game();
            $game->create($title, $description, $release_date, $cover_image, $platform_id, $categorie_id, $publisher_id);
            $message = "Jeu ajouté avec succés ";
        } catch (Exception $e) {
            $message = "Erreur : " . $e->getMessage();
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
    <title>Créer un Jeu</title>
    <link rel="stylesheet" href="entity/style.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">

            <?php if ($message): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form method="post">
                <h1>Créer un Jeu</h1>

                <label>Titre du Jeu</label>
                <input type="text" name="title"><br>

                <label>Description</label>
                <textarea name="description" rows="4"></textarea><br>

                <label>Date de Sortie</label>
                <input type="date" name="release_date"><br>

                <label>Image de Couverture </label>
                <input type="file" name="cover_image"><br>

                <label>Plateforme</label>
                <select name="platform_id">
                    <?php foreach ($platforms as $plt): ?>
                        <option value="<?= $plt['id'] ?>"><?= htmlspecialchars($plt['name']) ?></option>
                    <?php endforeach; ?>
                </select><br>

                <label>Catégorie</label>
                <select name="categorie_id">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select><br>

                <label>Éditeur (Publisher)</label>
                <select name="publisher_id">
                    <?php foreach ($publishers as $pub): ?>
                        <option value="<?= $pub['id'] ?>"><?= htmlspecialchars($pub['name']) ?></option>
                    <?php endforeach; ?>
                </select><br>

                <button type="submit" name="submit">Créer</button>
            </form>

            <button><a href="index.php?page=dashboard">Annuler</a></button>

        </div>
    </div>
</body>
</html>