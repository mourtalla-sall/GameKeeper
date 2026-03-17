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