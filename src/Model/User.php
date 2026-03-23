<?php
namespace Gamekeeper\Model;

use Gamekeeper\Database;
use PDO;

class User {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }

    public function register($firstName, $lastName, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(firstName, lastName, email, password, role)
                VALUES (?, ?, ?, ?, 'user')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            trim($firstName),
            trim($lastName),
            trim($email),
            $hashedPassword
        ]);
    }

    public function emailexists($email) {
        $sql = "SELECT id FROM user WHERE email=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([trim($email)]);
        return $stmt->fetch() !== false;
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM user WHERE email=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([trim($email)]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getuserbyid($id) {
        $sql = "SELECT id, firstName, lastName, email, role
                FROM user WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateprofile($id, $firstName, $lastName, $email) {
        $sql = "UPDATE user SET firstName=?, lastName=?, email=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            trim($firstName),
            trim($lastName),
            trim($email),
            $id
        ]);
    }

    public function updatepassword($id, $currentPassword, $newPassword) {
        $sql = "SELECT password FROM user WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return false;
        }
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$hashedPassword, $id]);
    }

    public function emailotheruser($email, $id) {
        $sql = "SELECT id FROM user WHERE email=? AND id!=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([trim($email), $id]);
        return $stmt->fetch() !== false;
    }
}