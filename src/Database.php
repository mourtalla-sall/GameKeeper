<?php
namespace Gamekeeper;

use PDO;

class Database {
    private static $instance = null;
    private PDO $pdo;

    private function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=mickael-touati.students-laplateforme.io;dbname=mickael-touati_gamekeeper;charset=utf8",
                'game',
                '~Xr91cm98',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (\PDOException $e) {
            die("Erreur de connexion à la base de données");
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnexion(): PDO {
        return $this->pdo;
    }
}