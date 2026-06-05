<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

$action = 'home';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

try {
    switch ($action) {
        case 'home':
            $homeController = new HomeController();
            $homeController->showHome();
            break;
        case 'books':
            $bookController = new BookController();
            $bookController->showBooks();
            break;
        case 'book':
            $bookController = new BookController();
            $bookController->showBook();
            break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $exception) {
    echo '<h1>Erreur</h1>';
    echo '<p>' . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
}
