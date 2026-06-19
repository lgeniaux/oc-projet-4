<?php

session_start();

require_once 'config/config.php';
require_once 'config/autoload.php';

$action = Utils::request('action', 'home');

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
        case 'add-book':
            $bookController = new BookController();
            $bookController->addBook();
            break;
        case 'edit-book':
            $bookController = new BookController();
            $bookController->editBook();
            break;
        case 'profile':
            $userController = new UserController();
            $userController->showProfile();
            break;
        case 'myprofile':
            $userController = new UserController();
            $userController->showMyProfile();
            break;
        case 'delete-book':
            $bookController = new BookController();
            $bookController->deleteBook();
            break;
        case 'login':
            $authController = new AuthController();
            $authController->showLogin();
            break;
        case 'register':
            $authController = new AuthController();
            $authController->showRegister();
            break;
        case 'logout':
            $authController = new AuthController();
            $authController->logout();
            break;
        case 'protected-test':
            $authController = new AuthController();
            $authController->protectedTest();
            break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $exception) {
    echo '<h1>Erreur</h1>';
    echo '<p>' . Utils::safe($exception->getMessage()) . '</p>';
}
