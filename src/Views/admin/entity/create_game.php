<?php
use Gamekeeper\Model\admin_model\Game;
use Gamekeeper\Model\admin_model\Plateform;
use Gamekeeper\Model\admin_model\Categorie;
use Gamekeeper\Model\admin_model\Publishers;

function securityInput($input) {
    return trim(htmlspecialchars($input));
}

$message = '';
$gameData = null;
$isEdit = isset($_GET['id']) && (int)$_GET['id'] > 0;

// Récupère le jeu si modification
if ($isEdit) {
    $gameData = (new Game())->getById((int)$_GET['id']);
}

if (isset($_POST['submit'])) {
    $title        = securityInput($_POST['title']);
    $description  = securityInput($_POST['description']);
    $release_date = securityInput($_POST['release_date']);
    $platform_id  = (int)$_POST['platform_id'];
    $categorie_id = (int)$_POST['categorie_id'];
    $publisher_id = (int)$_POST['publisher_id'];

    // Gestion image
    $cover_image = $gameData['cover_image'] ?? null;
    if (!empty($_FILES['cover_image']['name'])) {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 5 * 1024 * 1024;
        if (!in_array($_FILES['cover_image']['type'], $allowed)) {
            $message = "Format non supporté. JPG, PNG ou WEBP uniquement.";
        } elseif ($_FILES['cover_image']['size'] > $maxSize) {
            $message = "Image trop lourde. Maximum 5MB.";
        } else {
            $ext  = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
            $filename  = uniqid('game_') . '.' . $ext;
            $uploadDir = __DIR__ . '/../../../../upload/';
            move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $filename);
            $cover_image = $filename;
        }
    }

    if (empty($title) || empty($description) || empty($release_date)) {
        $message = "Tous les champs sont requis";
    } elseif (empty($message)) {
        try {
            $game = new Game();
            if ($isEdit) {
                $game->update((int)$_POST['id'], $title, $description, $release_date, $cover_image, $platform_id, $categorie_id, $publisher_id);
                $message = "Jeu modifié avec succès";
                $gameData = $game->getById((int)$_POST['id']);
            } else {
                $game->create($title, $description, $release_date, $cover_image, $platform_id, $categorie_id, $publisher_id);
                $message = "Jeu ajouté avec succès";
            }
        } catch (Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}

$platforms  = (new Plateform())->getAll();
$categories = (new Categorie())->getAll();
$publishers = (new Publishers())->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $isEdit ? 'Modifier' : 'Créer' ?> un Jeu</title>
    <link rel="stylesheet" href="src/Views/admin/entity/style.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">

            <?php if ($message): ?>
                <p class="<?= str_contains($message, 'succès') ? 'success' : 'error' ?>">
                    <?= $message ?>
                </p>
            <?php endif; ?>

            <form method="post" action="index.php?page=admin/saveGame" enctype="multipart/form-data">
                <h1><?= $isEdit ? 'Modifier le Jeu' : 'Créer un Jeu' ?></h1>

                <!--  Champ caché pour l'id en cas de modification -->
                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?= (int)$_GET['id'] ?>">
                <?php endif; ?>

                <label>Titre du Jeu</label>
                <input type="text" name="title" value="<?= htmlspecialchars($gameData['title'] ?? '') ?>"><br>

                <label>Description</label>
                <textarea name="description" rows="4"><?= htmlspecialchars($gameData['description'] ?? '') ?></textarea><br>

                <label>Date de Sortie</label>
                <input type="date" name="release_date" value="<?= $gameData['release_date'] ?? '' ?>"><br>

                <label>Image de Couverture</label>
                <?php if (!empty($gameData['cover_image'])): ?>
                    <img src="upload/<?= htmlspecialchars($gameData['cover_image']) ?>" style="height:60px; border-radius:4px; display:block; margin-bottom:8px">
                <?php endif; ?>
                <input type="file" name="cover_image"><br>

                <label>Plateforme</label>
                <select name="platform_id">
                    <?php foreach ($platforms as $plt): ?>
                        <option value="<?= $plt['id'] ?>" <?= ($gameData['platform_id'] ?? '') == $plt['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($plt['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label>Catégorie</label>
                <select name="categorie_id">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($gameData['categorie_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label>Éditeur (Publisher)</label>
                <select name="publisher_id">
                    <?php foreach ($publishers as $pub): ?>
                        <option value="<?= $pub['id'] ?>" <?= ($gameData['publisher_id'] ?? '') == $pub['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pub['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <button type="submit" name="submit">
                    <?= $isEdit ? 'Modifier' : 'Créer' ?>
                </button>
            </form>

            <button class="btn-annuler"><a  href="index.php?page=admin/dashboard">Annuler</a></button>

        </div>
    </div>
</body>
</html>