<?php

class AuthService
{
    public static function login(string $email, string $password): ?string
    {
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
        if ($username === '' || $email === '' || $password === '') {
            return 'Tous les champs sont obligatoires.';
        }

        $emailError = self::validateEmail($email);
        if ($emailError !== null) {
            return $emailError;
        }

        $usernameError = self::validateUsername($username);
        if ($usernameError !== null) {
            return $usernameError;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userManager = new UserManager();
        $userId = $userManager->createUser($username, $email, $passwordHash);

        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;

        return null;
    }

    public static function validateProfileUpdate(
        User $currentUser,
        string $email,
        string $username,
        string $password
    ): ?string {
        if ($email === '' || $username === '') {
            return 'L\'email et le pseudo sont obligatoires.';
        }

        $emailError = self::validateEmail($email, $currentUser);
        if ($emailError !== null) {
            return $emailError;
        }

        $usernameError = self::validateUsername($username, $currentUser);
        if ($usernameError !== null) {
            return $usernameError;
        }

        if ($password !== '') {
            $passwordError = self::validatePassword($password);
            if ($passwordError !== null) {
                return $passwordError;
            }
        }

        return null;
    }

    public static function updateProfile(
        int $userId,
        User $currentUser,
        string $email,
        string $username,
        string $password,
        string $profileImage
    ): void {
        $userManager = new UserManager();

        if ($email !== $currentUser->getEmail()) {
            $userManager->updateEmail($userId, $email);
        }

        if ($username !== $currentUser->getUsername()) {
            $userManager->updateUsername($userId, $username);
        }

        if ($password !== '') {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $userManager->updatePassword($userId, $passwordHash);
        }

        if ($profileImage !== $currentUser->getProfileImage()) {
            $profileImageValue = $profileImage === '' ? null : $profileImage;
            $userManager->updateProfileImage($userId, $profileImageValue);
        }
    }

    public static function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    private static function validateEmail(string $email, ?User $excludeUser = null): ?string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Adresse email invalide.';
        }

        if ($excludeUser !== null && $email === $excludeUser->getEmail()) {
            return null;
        }

        $userManager = new UserManager();
        if ($userManager->findUserByEmail($email) !== null) {
            return 'Cette adresse email est déjà utilisée.';
        }

        return null;
    }

    private static function validateUsername(string $username, ?User $excludeUser = null): ?string
    {
        if ($excludeUser !== null && $username === $excludeUser->getUsername()) {
            return null;
        }

        $userManager = new UserManager();
        if ($userManager->findUserByUsername($username) !== null) {
            return 'Ce pseudo est déjà utilisé.';
        }

        return null;
    }

    private static function validatePassword(string $password): ?string
    {
        if (strlen($password) < 6) {
            return 'Le mot de passe doit contenir au moins 6 caractères.';
        }

        return null;
    }
}
