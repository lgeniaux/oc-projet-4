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
        case 'messages':
            $messageController = new MessageController();
            $messageController->showMessages();
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
            http_response_code(404);
            $view = new View('Page introuvable');
            $view->render('not_found');
            break;
    }
} catch (Exception $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    $view = new View('Erreur');
    $view->render('error');
}
