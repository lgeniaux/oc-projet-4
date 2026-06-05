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

            $userManager = new UserManager();
            $user = $userManager->findUserByEmail($email);

            if ($user !== null && password_verify($password, $user->getPasswordHash())) {
                $_SESSION['user_id'] = $user->getId();
                header('Location: index.php?action=home');
                exit;
            }

            $error = 'Email ou mot de passe incorrect.';
        }

        $view = new View('Connexion');
        $view->render('login', [
            'error' => $error,
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
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $view = new View('Page protégée');
        $view->render('protected-test');
    }
}
