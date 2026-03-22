<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';
// require_once __DIR__ . '/db.php';
use Gamekeeper\Database;
use Gamekeeper\Controlleur\AdminController;
use Gamekeeper\Views\View;

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

//  Pages admin  gérés par AdminController
$adminPages = ['admin/dashboard', 'admin/gameForm', 'admin/saveGame', 'admin/deleteGame'];

if (in_array($page, $adminPages)) {
    $controller = new AdminController();
    $action = explode('/', $page)[1]; 
    $controller->$action();
    exit;
}

// Pages normales gérés par View render()
$pagesAutorisees = [
    'accueil', 'register', 'login', 'nos_jeux',
    'Footer', 'Deconnexion', 'profil',
    'categorie_detail', 'game_detail', 'modifieprofil'
];

if (!in_array($page, $pagesAutorisees)) {
    $page = 'accueil';
}

$render = new View();
echo $render->render($page);