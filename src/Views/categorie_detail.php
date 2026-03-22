<?php
require_once __DIR__ . '/../../db.php';

use Gamekeeper\Database;

$database = Database::getInstance();
$pdo = $database->getConnexion();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$queryCategorie = $pdo->prepare('SELECT * FROM categorie WHERE id = :id');
$queryCategorie->execute([':id' => $id]);
$categorie = $queryCategorie->fetch(PDO::FETCH_ASSOC);

if (!$categorie) {
    die("Catégorie introuvable.");
}

$queryJeux = $pdo->prepare('
    SELECT games.id, games.title, games.cover_image, games.description,
           platforms.name AS platform
    FROM games
    LEFT JOIN platforms ON games.platform_id = platforms.id
    WHERE games.categorie_id = :id
');
$queryJeux->execute([':id' => $id]);
$games = $queryJeux->fetchAll(PDO::FETCH_ASSOC);

$nbJeux = count($games);
?>

<link rel="stylesheet" href="src/Views/view.css">

<div class="detail-container">
    <div class="detail-cover">
        <img
            src="<?= htmlspecialchars($categorie['cover_image'] ?? '../../public/image/foot1.jpg') ?>"
            alt="<?= htmlspecialchars($categorie['name']) ?>"
        >
    </div>

    <div class="detail-info">
        <h1><?= htmlspecialchars($categorie['name']) ?></h1>

        <div class="detail-badges">
            <span class="badge"><?= $nbJeux ?> jeux</span>
        </div>

        <p class="detail-description"><?= htmlspecialchars($categorie['description']) ?></p>

        <div class="detail-meta">
            <div class="meta-item">
                <span class="meta-label">Categorie</span>
                <span class="meta-value"><?= $nbJeux ?> jeux</span>
            </div>
        </div>

        <a href="index.php?page=nos_categories" class="btn-retour"> Retour aux catégories</a>
    </div>
</div>

<div class="section-jeux">
    <h2 class="section-title">Jeux dans "<?= htmlspecialchars($categorie['name']) ?>"</h2>

    <?php if (empty($games)) : ?>
        <p class="empty">Aucun jeu dans cette catégorie.</p>
    <?php else : ?>
        <div class="games-grid">
            <?php foreach ($games as $game) : ?>
                <div class="game-card">
                    <img
                        src="<?= htmlspecialchars($game['cover_image'] ?? '../../public/image/foot1.jpg') ?>"
                        alt="<?= htmlspecialchars($game['title']) ?>"
                    >
                    <div class="game-card-body">
                        <h2><?= htmlspecialchars($game['title']) ?></h2>
                        <?php if ($game['platform']) : ?>
                            <span class="categorie"><?= htmlspecialchars($game['platform']) ?></span>
                        <?php endif; ?>
                        <p><?= htmlspecialchars($game['description']) ?></p>
                        <a href="index.php?page=game_detail&id=<?= $game['id'] ?>" class="btn-voir">Voir le jeu</a>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/Navigation/Footer.php'; ?>