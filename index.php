<?php
require_once __DIR__ . '/vendor/autoload.php';

use TestAutoloading\Views\View;


session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

if (isset($_SESSION['user_id'])) {
    header("Location: src/View/profil.php");
} else {
    header("Location: src/View/login.php");
}
exit();



$render = new View();

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'accueil';
}

$pagesAutorisees = ['accueil', 'inscription', 'connexion'];

if (!in_array($page, $pagesAutorisees)) {
    $page = 'accueil';
}

echo $render->render($page);


