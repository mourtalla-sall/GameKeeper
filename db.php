<?php
// Login à la base de donnée avec des variables, faciles a modifié si changement de mot de passe ou de db


class Database{
    private static $instance;
    private PDO $pdo ;
    
    private function __construct()
    {
        $this->pdo = new PDO("mysql:host=mourtalla-sall.students-laplateforme.io;
        dbname=mourtalla-sall_GameKeeper;charset=utf8", 
        'gameKeeper', 'Game123456@/',
        [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
        ]); 
        
    }
    public static function getInstance(){
        if (self::$instance === NULL) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    public function getConnexion(): PDO{
        return $this->pdo;
    }
}

?>