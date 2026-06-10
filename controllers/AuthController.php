<?php

class AuthController
{
    public function login(): void
    {
        $error = null;
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $error = AuthService::login($email, $password);

            if ($error === null) {
                header('Location: index.php?action=home');
                exit;
            }
        }

        $view = new View('Connexion');
        $view->render('login', [
            'error' => $error,
            'email' => $email,
        ]);
    }

    public function register(): void
    {
        $error = null;
        $username = '';
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $error = AuthService::register($username, $email, $password);

            if ($error === null) {
                header('Location: index.php?action=home');
                exit;
            }
        }

        $view = new View('Inscription');
        $view->render('register', [
            'error' => $error,
            'username' => $username,
            'email' => $email,
        ]);
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: index.php?action=home');
        exit;
    }

    public function protectedTest(): void
    {
        AuthService::requireAuth();

        $view = new View('Page protégée');
        $view->render('protected-test');
    }
}
