<?php

class AuthService
{
    public static function login(string $email, string $password): ?string
    {
        $email = trim($email);

        if ($email === '' || $password === '') {
            return 'Email et mot de passe sont obligatoires.';
        }

        $userManager = new UserManager();
        $user = $userManager->findUserByEmail($email);

        if ($user === null || !password_verify($password, $user->getPasswordHash())) {
            return 'Email ou mot de passe incorrect.';
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getId();

        return null;
    }

    public static function register(string $username, string $email, string $password): ?string
    {
        $username = trim($username);
        $email = trim($email);

        if ($username === '' || $email === '' || $password === '') {
            return 'Tous les champs sont obligatoires.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Adresse email invalide.';
        }

        $userManager = new UserManager();

        if ($userManager->findUserByEmail($email) !== null) {
            return 'Cette adresse email est déjà utilisée.';
        }

        if ($userManager->findUserByUsername($username) !== null) {
            return 'Ce pseudo est déjà utilisé.';
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $userManager->createUser($username, $email, $passwordHash);

        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;

        return null;
    }

    public static function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }
}
