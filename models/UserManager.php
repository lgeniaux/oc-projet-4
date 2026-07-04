<?php

class UserManager
{
    private PDO $db;

    /**
     * Initialise le manager avec la connexion à la base de données.
     */
    public function __construct()
    {
        $this->db = DBManager::getConnection();
    }

    /**
     * Récupère un utilisateur par son email.
     * @param string $email : l'adresse email recherchée.
     * @return User|null : l'utilisateur trouvé ou null.
     */
    public function findUserByEmail(string $email): ?User
    {
        $sql = 'SELECT id, username, email, password_hash, profile_image, biography, created_at
                FROM users
                WHERE email = :email';

        $query = $this->db->prepare($sql);
        $query->execute([
            'email' => $email,
        ]);

        $userData = $query->fetch();

        if (!$userData) {
            return null;
        }

        return $this->createUserFromData($userData);
    }

    /**
     * Récupère un utilisateur par son pseudo.
     * @param string $username : le pseudo recherché.
     * @return User|null : l'utilisateur trouvé ou null.
     */
    public function findUserByUsername(string $username): ?User
    {
        $sql = 'SELECT id, username, email, password_hash, profile_image, biography, created_at
                FROM users
                WHERE username = :username';

        $query = $this->db->prepare($sql);
        $query->execute([
            'username' => $username,
        ]);

        $userData = $query->fetch();

        if (!$userData) {
            return null;
        }

        return $this->createUserFromData($userData);
    }

    /**
     * Récupère un utilisateur par son identifiant.
     * @param int $id : l'identifiant de l'utilisateur.
     * @return User|null : l'utilisateur trouvé ou null.
     */
    public function findUserById(int $id): ?User
    {
        $sql = 'SELECT id, username, email, password_hash, profile_image, biography, created_at
                FROM users
                WHERE id = :id';

        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
        ]);

        $userData = $query->fetch();

        if (!$userData) {
            return null;
        }

        return $this->createUserFromData($userData);
    }

    /**
     * Crée un nouvel utilisateur.
     * @param string $username : le pseudo de l'utilisateur.
     * @param string $email : l'adresse email de l'utilisateur.
     * @param string $passwordHash : le mot de passe déjà hashé.
     * @return int : l'identifiant créé.
     */
    public function createUser(string $username, string $email, string $passwordHash): int
    {
        $sql = 'INSERT INTO users (username, email, password_hash)
                VALUES (:username, :email, :password_hash)';

        $query = $this->db->prepare($sql);
        $query->execute([
            'username' => $username,
            'email' => $email,
            'password_hash' => $passwordHash,
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Met à jour l'adresse email d'un utilisateur.
     * @param int $id : l'identifiant de l'utilisateur.
     * @param string $email : la nouvelle adresse email.
     * @return void
     */
    public function updateEmail(int $id, string $email): void
    {
        $sql = 'UPDATE users SET email = :email WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
            'email' => $email,
        ]);
    }

    /**
     * Met à jour le pseudo d'un utilisateur.
     * @param int $id : l'identifiant de l'utilisateur.
     * @param string $username : le nouveau pseudo.
     * @return void
     */
    public function updateUsername(int $id, string $username): void
    {
        $sql = 'UPDATE users SET username = :username WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
            'username' => $username,
        ]);
    }

    /**
     * Met à jour le mot de passe hashé d'un utilisateur.
     * @param int $id : l'identifiant de l'utilisateur.
     * @param string $passwordHash : le nouveau mot de passe hashé.
     * @return void
     */
    public function updatePassword(int $id, string $passwordHash): void
    {
        $sql = 'UPDATE users SET password_hash = :password_hash WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
            'password_hash' => $passwordHash,
        ]);
    }

    /**
     * Met à jour l'URL de photo de profil d'un utilisateur.
     * @param int $id : l'identifiant de l'utilisateur.
     * @param string|null $profileImage : la nouvelle URL ou null.
     * @return void
     */
    public function updateProfileImage(int $id, ?string $profileImage): void
    {
        $sql = 'UPDATE users SET profile_image = :profile_image WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
            'profile_image' => $profileImage,
        ]);
    }

    /**
     * Transforme une ligne SQL en objet User.
     * @param array $userData : les données de l'utilisateur.
     * @return User : l'utilisateur hydraté.
     */
    private function createUserFromData(array $userData): User
    {
        return new User(
            (int) $userData['id'],
            $userData['username'],
            $userData['email'],
            $userData['password_hash'],
            $userData['profile_image'],
            $userData['biography'],
            $userData['created_at']
        );
    }
}
