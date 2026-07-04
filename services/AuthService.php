<?php

class AuthService
{
    /**
     * Vérifie les identifiants de connexion d'un utilisateur.
     * @param string $email : l'adresse email saisie.
     * @param string $password : le mot de passe saisi.
     * @return array : l'utilisateur connecté ou un message d'erreur.
     */
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

    /**
     * Crée un compte utilisateur après validation des informations.
     * @param string $username : le pseudo souhaité.
     * @param string $email : l'adresse email souhaitée.
     * @param string $password : le mot de passe souhaité.
     * @return array : l'utilisateur créé ou un message d'erreur.
     */
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

    /**
     * Met à jour les informations du profil utilisateur.
     * @param User $user : l'utilisateur à modifier.
     * @param string $email : la nouvelle adresse email.
     * @param string $username : le nouveau pseudo.
     * @param string $password : le nouveau mot de passe, ou vide si inchangé.
     * @param string $profileImage : la nouvelle URL de photo de profil.
     * @return array : l'utilisateur mis à jour ou un message d'erreur.
     */
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

        if (!Utils::isValidImageUrl($profileImage)) {
            return ['user' => null, 'error' => 'L\'URL de la photo de profil doit être une adresse http ou https valide.'];
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

    /**
     * Redirige vers la connexion si aucun utilisateur n'est connecté.
     * @return void
     */
    public static function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            Utils::redirect('login');
        }
    }

    /**
     * Vérifie que le livre appartient à l'utilisateur connecté.
     * @param Book $book : le livre à contrôler.
     * @return void
     */
    public static function requireBookOwner(Book $book): void
    {
        if ($book->getUserId() !== (int) $_SESSION['user_id']) {
            throw new NotFoundException("Le livre demandé n'existe pas.");
        }
    }
}
