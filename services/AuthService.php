<?php

class AuthService
{
    public static function login(string $email, string $password): array
    {
        if ($email === '' || $password === '') {
            return ['user' => null, 'error' => 'Email et mot de passe sont obligatoires.'];
        }

        $userManager = new UserManager();
        $user = $userManager->findUserByEmail($email);

        if ($user === null || !password_verify($password, $user->getPasswordHash())) {
            return ['user' => null, 'error' => 'Email ou mot de passe incorrect.'];
        }

        return ['user' => $user, 'error' => null];
    }

    public static function register(string $username, string $email, string $password): array
    {
        if ($username === '' || $email === '' || $password === '') {
            return ['user' => null, 'error' => 'Tous les champs sont obligatoires.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['user' => null, 'error' => 'Adresse email invalide.'];
        }

        $userManager = new UserManager();

        if ($userManager->findUserByEmail($email) !== null) {
            return ['user' => null, 'error' => 'Cette adresse email est déjà utilisée.'];
        }

        if ($userManager->findUserByUsername($username) !== null) {
            return ['user' => null, 'error' => 'Ce pseudo est déjà utilisé.'];
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $userManager->createUser($username, $email, $passwordHash);

        return ['user' => $userManager->findUserById($userId), 'error' => null];
    }

    public static function updateProfile(
        User $user,
        string $email,
        string $username,
        string $password,
        string $profileImage
    ): array {
        if ($email === '' || $username === '') {
            return ['user' => null, 'error' => 'L\'email et le pseudo sont obligatoires.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['user' => null, 'error' => 'Adresse email invalide.'];
        }

        $userManager = new UserManager();

        if ($email !== $user->getEmail() && $userManager->findUserByEmail($email) !== null) {
            return ['user' => null, 'error' => 'Cette adresse email est déjà utilisée.'];
        }

        if ($username !== $user->getUsername() && $userManager->findUserByUsername($username) !== null) {
            return ['user' => null, 'error' => 'Ce pseudo est déjà utilisé.'];
        }

        if ($password !== '' && strlen($password) < 6) {
            return ['user' => null, 'error' => 'Le mot de passe doit contenir au moins 6 caractères.'];
        }

        if ($email !== $user->getEmail()) {
            $userManager->updateEmail($user->getId(), $email);
        }

        if ($username !== $user->getUsername()) {
            $userManager->updateUsername($user->getId(), $username);
        }

        if ($password !== '') {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $userManager->updatePassword($user->getId(), $passwordHash);
        }

        if ($profileImage !== $user->getProfileImage()) {
            $profileImageValue = $profileImage === '' ? null : $profileImage;
            $userManager->updateProfileImage($user->getId(), $profileImageValue);
        }

        $updatedUser = $userManager->findUserById($user->getId());

        return ['user' => $updatedUser, 'error' => null];
    }

    public static function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            Utils::redirect('login');
        }
    }

    public static function requireBookOwner(Book $book): void
    {
        if ($book->getUserId() !== (int) $_SESSION['user_id']) {
            throw new Exception("Vous n'avez pas le droit de supprimer ce livre.");
        }
    }
}
