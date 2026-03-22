<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - GameKeeper</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h1>Dashboard</h1>

<!-- Stats cards -->
<div class="stats">
    <div class="stat-card">
        <h3>Total Games</h3>
        <p><?= $totalGames ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Playtime</h3>
        <p><?= $totalPlaytime ?> hours</p>
    </div>
    <div class="stat-card">
        <h3>Completed Games</h3>
        <p><?= $completedGames ?></p>
    </div>
    <div class="stat-card">
        <h3>In Progress Games</h3>
        <p><?= $inProgressGames ?></p>
    </div>
</div>

<h2>Games by Platform</h2>
<div class="platform-list">
    <?php foreach ($gamesByPlatform as $row): ?>
    <div class="bar-item">
        <span><?= htmlspecialchars($row['name']) ?></span>
        <progress value="<?= $row['total'] ?>" max="<?= $totalGames ?>"></progress>
        <span><?= $row['total'] ?> jeux</span>
    </div>
    <?php endforeach; ?>
</div>

<h2>Liste des jeux</h2>

<a href="index.php?page=gameForm" class="btn-ajouter">Ajouter un jeu</a>
<div class="table-container">
<table>
    <thead>
        <tr>
            <th>Image</th>
            <th>Titre</th>
            <th>Plateforme</th>
            <th>Catégorie</th>
            <th>Éditeur</th>
            <th>Date de sortie</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($games as $game): ?>
        <tr>
            <td>
            
              
               <img src="../../upload/<?= $game['cover_image'] ?>" style="height:60px; border-radius:4px">

                
            </td>
            <td><?= htmlspecialchars($game['title']) ?></td>
            <td><?= htmlspecialchars($game['platform'] ?? '—') ?></td>
            <td><?= htmlspecialchars($game['categorie'] ?? '—') ?></td>
            <td><?= htmlspecialchars($game['publisher'] ?? '—') ?></td>
            <td><?= $game['release_date'] ?? '—' ?></td>
            <td>
                <a href="entity/update_game.php?id=<?= $game['id'] ?>" class="btn-modifier">Modifier</a>
                <a href="index.php?page=deleteGame&id=<?= $game['id'] ?>" class="btn-supprimer" 
                onclick="return confirm('Supprimer ce jeu ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

</body>
</html>