<?php
session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';

use Gamekeeper\Controlleur\AdminController;
use Gamekeeper\Database;


$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

$controller = new AdminController();

switch ($page) {
    case 'dashboard':
        $controller->dashboard();
        break;
    case 'gameForm':
        $controller->gameForm();
        break;
    case 'saveGame':
        $controller->saveGame();
        break;
    case 'deleteGame':
        $controller->deleteGame();
        break;
    default:
        $controller->dashboard();
        break;
}