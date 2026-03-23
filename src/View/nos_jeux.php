<?php

require_once __DIR__ . '/../../db.php';


$database = Database::getInstance();
$pdo = $database->getConnexion();




  $data = $pdo->prepare('SELECT games.id, games.title, games.cover_image,
    games.description, categorie.name as categorie_nom FROM games
    JOIN categorie ON games.categorie_id = categorie.id');
    $data->execute();
    $games = $data->fetchAll(PDO::FETCH_ASSOC);
    


?>
<link rel="stylesheet" href="view.css">
<section>
      
<div class="games-grid">  
<?php
  foreach ($games as $game) {
      $title = htmlspecialchars($game['title']);
      $image = htmlspecialchars($game['cover_image'] ?? '../public/image/foot1.jpg');
      $categorie = htmlspecialchars($game['categorie_nom']);
      $description = htmlspecialchars($game['description']);

    echo "
      <div class='game-card'>
          <img src='$image' alt='$title'>
          <div class='game-card-body'>
              <h2>$title</h2>
              <span class='categorie'>$categorie</span>
              <p>$description</p>
              <a href='game_detail.php?id={$game['id']}' class='btn-voir'>Voir tout</a>
          </div>
      </div>
    ";
  }
?>
</div>  
</section>