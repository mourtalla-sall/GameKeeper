<?php
require_once __DIR__ . '/vendor/autoload.php';

use TestAutoloading\Views\View;

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