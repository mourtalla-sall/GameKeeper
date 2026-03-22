<?php

namespace Gamekeeper\Model\admin_model;

use Gamekeeper\Database;

use \PDO;

class Game {

    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }

    private function securityInput($input) {
        return trim(htmlspecialchars($input));
    }

    public function create($title, $description, $release_date, $cover_image, $platform_id, $categorie_id, $publisher_id) {
        $data = $this->pdo->prepare('INSERT INTO games (title, description, release_date, cover_image, platform_id, categorie_id, publisher_id) VALUES (:title, :description, :release_date, :cover_image, :platform_id, :categorie_id, :publisher_id)');
        $data->bindValue(':title', $this->securityInput($title),       PDO::PARAM_STR);
        $data->bindValue(':description',  $this->securityInput($description), PDO::PARAM_STR);
        $data->bindValue(':release_date', $release_date,PDO::PARAM_STR);
        $data->bindValue(':cover_image',  $cover_image, PDO::PARAM_STR);
        $data->bindValue(':platform_id',  $platform_id, PDO::PARAM_INT);
        $data->bindValue(':categorie_id', $categorie_id,PDO::PARAM_INT);
        $data->bindValue(':publisher_id', $publisher_id,PDO::PARAM_INT);
        return $data->execute();
    }

    public function getAll() {
        $data = $this->pdo->prepare('SELECT games.*, platforms.name AS platform,
        categorie.name AS categorie, publishers.name AS publisher 
        FROM games
        LEFT JOIN platforms ON games.platform_id = platforms.id
        LEFT JOIN categorie ON games.categorie_id = categorie.id
        LEFT JOIN publishers ON games.publisher_id = publishers.id
        ORDER BY games.id DESC');
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $data = $this->pdo->prepare('SELECT * FROM games WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        $data->execute();
        return $data->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $release_date, $cover_image, $platform_id, $categorie_id, $publisher_id) {
        $data = $this->pdo->prepare('UPDATE games SET title=:title, description=:description, release_date=:release_date, cover_image=:cover_image, platform_id=:platform_id, categorie_id=:categorie_id, publisher_id=:publisher_id WHERE id=:id');
        $data->bindValue(':title', $this->securityInput($title),       PDO::PARAM_STR);
        $data->bindValue(':description', $this->securityInput($description), PDO::PARAM_STR);
        $data->bindValue(':release_date', $release_date, PDO::PARAM_STR);
        $data->bindValue(':cover_image', $cover_image, PDO::PARAM_STR);
        $data->bindValue(':platform_id', $platform_id,PDO::PARAM_INT);
        $data->bindValue(':categorie_id', $categorie_id,PDO::PARAM_INT);
        $data->bindValue(':publisher_id', $publisher_id,PDO::PARAM_INT);
        $data->bindValue(':id', $id,PDO::PARAM_INT);
        return $data->execute();
    }

    public function delete($id) {
        $data = $this->pdo->prepare('DELETE FROM games WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        return $data->execute();
    }

    public function count() {
        return $this->pdo->query('SELECT COUNT(*) FROM games')->fetchColumn();
    }
}
?>