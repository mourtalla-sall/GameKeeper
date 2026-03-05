<?php
require_once __DIR__ . '/../db.php';

class AdminController {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnexion();
    }

    public function dashboard() {
        $totalGames     = $this->pdo->query("SELECT COUNT(*) FROM games")->fetchColumn();
        $totalUsers     = $this->pdo->query("SELECT COUNT(*) FROM user")->fetchColumn();
        $totalPlatforms = $this->pdo->query("SELECT COUNT(*) FROM platforms")->fetchColumn();
        $totalGenres    = $this->pdo->query("SELECT COUNT(*) FROM genres")->fetchColumn();

        $recentGames = $this->pdo->query("
            SELECT games.title, platforms.name AS platform 
            FROM games 
            LEFT JOIN platforms ON games.platform_id = platforms.id
            ORDER BY games.id DESC 
            LIMIT 5
        ")->fetchAll();

        require_once __DIR__ . '/../View/admin/dashboard.php';
    }
}