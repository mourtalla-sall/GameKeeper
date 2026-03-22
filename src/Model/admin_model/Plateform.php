<?php

namespace Gamekeeper\Model\admin_model;

use Gamekeeper\Database;

use \PDO;

class Plateform {

    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }

    private function securityInput($nameInput) {
        return trim(htmlspecialchars($nameInput));
    }

    public function create($name, $manufacturer, $release_year) {
        $data = $this->pdo->prepare('INSERT INTO platforms (name, manufacturer, release_year) VALUES (:name, :manufacturer, :release_year)');
        $data->bindValue(':name',$this->securityInput($name),PDO::PARAM_STR);
        $data->bindValue(':manufacturer', $this->securityInput($manufacturer), PDO::PARAM_STR);
        $data->bindValue(':release_year', $release_year,PDO::PARAM_INT);
        return $data->execute();
    }

    public function getAll() {
        $data = $this->pdo->prepare('SELECT * FROM platforms');
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $data = $this->pdo->prepare('SELECT * FROM platforms WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        $data->execute();
        return $data->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $manufacturer, $release_year) {
        $data = $this->pdo->prepare('UPDATE platforms SET name=:name, manufacturer=:manufacturer, release_year=:release_year WHERE id=:id');
        $data->bindValue(':name',$this->securityInput($name),PDO::PARAM_STR);
        $data->bindValue(':manufacturer', $this->securityInput($manufacturer), PDO::PARAM_STR);
        $data->bindValue(':release_year', $release_year,PDO::PARAM_INT);
        $data->bindValue(':id',$id,PDO::PARAM_INT);
        return $data->execute();
    }

    public function delete($id) {
        $data = $this->pdo->prepare('DELETE FROM platforms WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        return $data->execute();
    }
}
?>