<?php

namespace Model\admin_model;

use \Database;

use \PDO;

class Publishers {

    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }

    private function securityInput($nameInput) {
        return trim(htmlspecialchars($nameInput));
    }

    public function create($name, $country) {
        $data = $this->pdo->prepare('INSERT INTO publishers (name, country) VALUES (:name, :country)');
        $data->bindValue(':name',$this->securityInput($name),PDO::PARAM_STR);
        $data->bindValue(':country', $this->securityInput($country), PDO::PARAM_STR);
        return $data->execute();
    }

    public function getAll() {
        $data = $this->pdo->prepare('SELECT * FROM publishers');
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $data = $this->pdo->prepare('SELECT * FROM publishers WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        $data->execute();
        return $data->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $country) {
        $data = $this->pdo->prepare('UPDATE publishers SET name=:name, country=:country WHERE id=:id');
        $data->bindValue(':name',$this->securityInput($name),PDO::PARAM_STR);
        $data->bindValue(':country', $this->securityInput($country), PDO::PARAM_STR);
        $data->bindValue(':id',$id,PDO::PARAM_INT);
        return $data->execute();
    }

    public function delete($id) {
        $data = $this->pdo->prepare('DELETE FROM publishers WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        return $data->execute();
    }
}
?>