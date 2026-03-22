<?php
require_once __DIR__ . '/../../db.php';

require_once './src/Views/Navigation/Header.php';


use Gamekeeper\Database;

$database = Database::getInstance();
$pdo = $database->getConnexion();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$data = $pdo->prepare('SELECT games.*, platforms.name AS platform,
    categorie.name AS categorie_nom, publishers.name AS publisher
    FROM games
    LEFT JOIN platforms ON games.platform_id = platforms.id
    LEFT JOIN categorie ON games.categorie_id = categorie.id
    LEFT JOIN publishers ON games.publisher_id = publishers.id
    WHERE games.id = :id');
$data->execute([':id' => $id]);
$game = $data->fetch(PDO::FETCH_ASSOC);

if (!$game) {
    echo "Jeu introuvable.";
}
?>

<link rel="stylesheet" href="src/Views/view.css">

<div class="detail-container">
    <div class="detail-cover">
        <img src="<?= htmlspecialchars($game['cover_image'] ??  '../public/image/foot1.jpg') ?>" alt="<?= htmlspecialchars($game['title']) ?>">
    </div>

    <div class="detail-info">
        <h1><?= htmlspecialchars($game['title']) ?></h1>

        <div class="detail-badges">
            <span class="badge"><?= htmlspecialchars($game['categorie_nom']) ?></span>
            <span class="badge"><?= htmlspecialchars($game['platform']) ?></span>
            <span class="badge"><?= htmlspecialchars($game['publisher']) ?></span>
        </div>

        <p class="detail-description"><?= htmlspecialchars($game['description']) ?></p>

        <div class="detail-meta">
            <div class="meta-item">
                <span class="meta-label">Date de sortie</span>
                <span class="meta-value"><?= htmlspecialchars($game['release_date']) ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Plateforme</span>
                <span class="meta-value"><?= htmlspecialchars($game['platform']) ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Éditeur</span>
                <span class="meta-value"><?= htmlspecialchars($game['publisher']) ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Catégorie</span>
                <span class="meta-value"><?= htmlspecialchars($game['categorie_nom']) ?></span>
            </div>
        </div>

        <a href="index.php?page=nos_jeux" class="btn-retour"> Retour aux jeux</a>
    </div>
</div>
<?php
require_once './src/Views/Navigation/Footer.php'

?>