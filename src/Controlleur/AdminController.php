<?php
require_once __DIR__ . '/../../db.php';

use Model\admin_model\Game;
use Model\admin_model\Plateform;
use Model\admin_model\Categorie;
use Model\admin_model\Publishers;

class AdminController {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnexion();
    }

    public function dashboard() {
        $totalGames      = $this->pdo->query("SELECT COUNT(*) FROM games")->fetchColumn();
        $totalUsers      = $this->pdo->query("SELECT COUNT(*) FROM user")->fetchColumn();
        $totalPlatforms  = $this->pdo->query("SELECT COUNT(*) FROM platforms")->fetchColumn();
        $totalCategorie  = $this->pdo->query("SELECT COUNT(*) FROM categorie")->fetchColumn();
        $totalPlaytime   = $this->pdo->query("SELECT COALESCE(SUM(playtime), 0) FROM user_games")->fetchColumn();
        $completedGames  = $this->pdo->query("SELECT COUNT(*) FROM user_games WHERE status = 'completed'")->fetchColumn();
        $inProgressGames = $this->pdo->query("SELECT COUNT(*) FROM user_games WHERE status = 'playing'")->fetchColumn();
        $gamesByPlatform = $this->pdo->query("
            SELECT platforms.name, COUNT(games.id) AS total
            FROM platforms
            LEFT JOIN games ON games.platform_id = platforms.id
            GROUP BY platforms.id
        ")->fetchAll();

        $games = (new Game())->getAll();

        require_once __DIR__ . '/../View/admin/dashboard.php';
    }

    public function gameForm() {
        $game       = null;
        $platforms  = (new Plateform())->getAll();
        $categories = (new Categorie())->getAll();
        $publishers = (new Publishers())->getAll();

        if (isset($_GET['id'])) {
            $game = (new Game())->getById((int)$_GET['id']);
        }

        require_once __DIR__ . '/../View/admin/entity/create_game.php';
    }

    public function saveGame() {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $releaseDate = $_POST['release_date'];
    $platformId  = $_POST['platform_id'];
    $categorieId = $_POST['categorie_id'];
    $publisherId = $_POST['publisher_id'];

    $coverImage = null;
    if (!empty($_FILES['cover_image']['name'])) {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($_FILES['cover_image']['type'], $allowed)) {
            die("Format non supporté. JPG, PNG ou WEBP uniquement.");
        }
        if ($_FILES['cover_image']['size'] > $maxSize) {
            die("Image trop lourde. Maximum 5MB.");
        }

        // Sauvegarde du fichier
        $ext      = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('game_') . '.' . $ext;
        $uploadDir = __DIR__ . '/../../upload/';
        move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $filename);
        $coverImage = $filename;
    }

    $gameModel = new Game();
    if (isset($_POST['id'])) {
        $gameModel->update((int)$_POST['id'], $title, $description, $releaseDate, $coverImage, $platformId, $categorieId, $publisherId);
    } else {
        $gameModel->create($title, $description, $releaseDate, $coverImage, $platformId, $categorieId, $publisherId);
    }

    header('Location: index.php?page=dashboard');
    exit;
}

    public function deleteGame() {
        $gameModel = new Game();
        $gameModel->delete((int)$_GET['id']);
        header('Location: index.php?page=dashboard');
        exit;
    }
}