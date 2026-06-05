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
        $sql = 'SELECT id, username, email, password_hash, profile_image, biography
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

        return $this->createUser($userData);
    }

    public function findUserById(int $id): ?User
    {
        $sql = 'SELECT id, username, email, password_hash, profile_image, biography
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

        return $this->createUser($userData);
    }

    private function createUser(array $userData): User
    {
        return new User(
            (int) $userData['id'],
            $userData['username'],
            $userData['email'],
            $userData['password_hash'],
            $userData['profile_image'],
            $userData['biography']
        );
    }
}
