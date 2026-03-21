<?php
require_once __DIR__ . '/../../db.php';

$database = Database::getInstance();
$pdo = $database->getConnexion();

// Récupère l'id de la catégorie depuis l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: index.php');
    exit;
}

// Récupère les infos de la catégorie
$queryCategorie = $pdo->prepare('SELECT * FROM categorie WHERE id = :id');
$queryCategorie->execute([':id' => $id]);
$categorie = $queryCategorie->fetch(PDO::FETCH_ASSOC);

// Si la catégorie n'existe pas → redirige
if (!$categorie) {
    header('Location: index.php');
    exit;
}

// Récupère tous les jeux de cette catégorie
$queryJeux = $pdo->prepare('
    SELECT games.id, games.title, games.cover_image, games.description, categorie.name as categorie_nom 
    FROM games
    JOIN categorie ON games.categorie_id = categorie.id
    WHERE categorie.id = :id
');
$queryJeux->execute([':id' => $id]);
$games = $queryJeux->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catégorie : <?php echo $categorie['name']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="detail-header">
        <a href="index.php" class="btn-retour"> Retour</a>
        <h1><?php echo $categorie['name']; ?></h1>
        <p><?php echo $categorie['description']; ?></p>
    </div>

    <div class="games-grid">
        <?php if (empty($games)) { ?>

            <p class="empty">Aucun jeu dans cette catégorie.</p>

        <?php } else { ?>

            <?php foreach ($games as $game) { ?>
                <div class="game-card">
                    <img src="<?php echo $game['cover_image']; ?>" alt="<?php echo $game['title']; ?>">
                    <div class="game-card-body">
                        <h2><?php echo $game['title']; ?></h2>
                        <span class="categorie"><?php echo $game['categorie_nom']; ?></span>
                        <p><?php echo $game['description']; ?></p>
                        <a href="game_detail.php?id=<?php echo $game['id']; ?>" class="btn-voir">Voir tout</a>
                    </div>
                </div>
            <?php } ?>

        <?php } ?>
    </div>

</body>
</html>


