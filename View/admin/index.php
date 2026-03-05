<?php

//page d'accueil admin affiche les stat(nombre de jeux, users, plateformes, genres)
session_start();

require_once 'db.php';
require_once 'Controlleur/AdminController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

$controller = new AdminController();

switch ($page) {
    case 'dashboard':
        $controller->dashboard();
        break;
    default:
        $controller->dashboard();
        break;
}