<?php
require_once __DIR__ . '/vendor/autoload.php';

use Gamekeeper\Views\View;


// session_start();


// if (isset($_SESSION['user_id'])) {
//     header("Location: src/View/profil.php");
// } else {
//     header("Location: src/View/login.php");
// }
// exit();



$render = new View();

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'accueil';
}

$pagesAutorisees = ['accueil', 'register', 'login', 'nos_jeux', 'Footer', 'Deconnexion', 'profil'];

if (!in_array($page, $pagesAutorisees)) {
    $page = 'accueil';
}

echo $render->render($page);


