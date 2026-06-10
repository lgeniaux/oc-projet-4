<?php

class UserManager
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DBManager::getConnection();
    }

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

    public function updateEmail(int $id, string $email): void
    {
        $sql = 'UPDATE users SET email = :email WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
            'email' => $email,
        ]);
    }

    public function updateUsername(int $id, string $username): void
    {
        $sql = 'UPDATE users SET username = :username WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
            'username' => $username,
        ]);
    }

    public function updatePassword(int $id, string $passwordHash): void
    {
        $sql = 'UPDATE users SET password_hash = :password_hash WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
            'password_hash' => $passwordHash,
        ]);
    }

    public function updateProfileImage(int $id, ?string $profileImage): void
    {
        $sql = 'UPDATE users SET profile_image = :profile_image WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
            'profile_image' => $profileImage,
        ]);
    }

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
