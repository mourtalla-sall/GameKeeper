<?php
namespace Gamekeeper\Model\admin_model;

use Gamekeeper\Database;

use \PDO;

class Categorie {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnexion();
    }

    private function securityInput($nameInput) {
        return trim(htmlspecialchars($nameInput));
    }

    public function create($name) {
        $data = $this->pdo->prepare('INSERT INTO categorie (name) VALUES (:name)');
        $data->bindValue(':name', $this->securityInput($name), PDO::PARAM_STR);
        return $data->execute();
    }

    public function getAll() {
        $data = $this->pdo->prepare('SELECT * FROM categorie');
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $data = $this->pdo->prepare('SELECT * FROM categorie WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        $data->execute();
        return $data->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name) {
        $data = $this->pdo->prepare('UPDATE categorie SET name = :name WHERE id = :id');
        $data->bindValue(':name', $this->securityInput($name), PDO::PARAM_STR);
        $data->bindValue(':id',   $id,                         PDO::PARAM_INT);
        return $data->execute();
    }

    public function delete($id) {
        $data = $this->pdo->prepare('DELETE FROM categorie WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        return $data->execute();
    }
}