<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

if (isset($_SESSION['user_id'])) {
    header("Location: src/View/profil.php");
} else {
    header("Location: src/View/login.php");
}
exit();

