<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - GameKeeper</title>
</head>
<body>

<h1>Dashboard Admin</h1>

<!-- Les 4 chiffres -->
<div>
    <div>
    <h3>Jeux</h3>
        <p><?= $totalGames ?></p>
    </div>

    <div>
    <h3>Utilisateurs</h3>
        <p><?= $totalUsers ?></p>
    </div>

    <div>
    <h3>Plateformes</h3>
        <p><?= $totalPlatforms ?></p>
    </div>

    <div>
    <h3>Genres</h3>
        <p><?= $totalCategorie ?></p>
    </div>
</div>

<!-- Les 5 derniers jeux -->
<h2>Derniers jeux ajoutés</h2>
<table border="1">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Plateforme</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recentGames as $game): ?>
        <tr>
            <td><?= htmlspecialchars($game['title']) ?></td>
            <td><?= htmlspecialchars($game['platform'] ?? '—') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>