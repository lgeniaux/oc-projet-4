<?php

class AuthController
{
    /**
     * Affiche et traite le formulaire de connexion.
     * @return void
     */
    public function showLogin(): void
    {
        $error = null;
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim(Utils::request('email', ''));
            $password = Utils::request('password', '');

            $result = AuthService::login($email, $password);

            if ($result['user'] !== null) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $result['user']->getId();
                Utils::redirect('home');
            }

            $error = $result['error'];
        }

        $view = new View('Connexion');
        $view->render('login', [
            'error' => $error,
            'email' => $email,
        ]);
    }

    /**
     * Affiche et traite le formulaire d'inscription.
     * @return void
     */
    public function showRegister(): void
    {
        $error = null;
        $username = '';
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim(Utils::request('username', ''));
            $email = trim(Utils::request('email', ''));
            $password = Utils::request('password', '');

            $result = AuthService::register($username, $email, $password);

            if ($result['user'] !== null) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $result['user']->getId();
                Utils::redirect('home');
            }

            $error = $result['error'];
        }

        $view = new View('Inscription');
        $view->render('register', [
            'error' => $error,
            'username' => $username,
            'email' => $email,
        ]);
    }

    /**
     * Déconnecte l'utilisateur connecté.
     * @return void
     */
    public function logout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::redirect('home');
        }

        session_destroy();
        Utils::redirect('home');
    }
}
