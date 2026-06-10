<?php

class BookManager
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DBManager::getConnection();
    }

    public function findLatestAvailableBooks(int $limit = 4): array
    {
        $sql = 'SELECT books.id, books.user_id, books.title, books.author, books.image,
                       books.description, books.status, users.username AS owner_username
                FROM books
                INNER JOIN users ON books.user_id = users.id
                WHERE books.status = "available"
                ORDER BY books.created_at DESC, books.id DESC
                LIMIT ' . $limit;

        $query = $this->db->prepare($sql);
        $query->execute();

        return $this->createBooks($query->fetchAll());
    }

    public function findAvailableBooks(): array
    {
        $sql = 'SELECT books.id, books.user_id, books.title, books.author, books.image,
                       books.description, books.status, users.username AS owner_username
                FROM books
                INNER JOIN users ON books.user_id = users.id
                WHERE books.status = "available"
                ORDER BY books.created_at DESC, books.id DESC';

        $query = $this->db->prepare($sql);
        $query->execute();

        return $this->createBooks($query->fetchAll());
    }

    public function searchAvailableBooksByTitle(string $search): array
    {
        $sql = 'SELECT books.id, books.user_id, books.title, books.author, books.image,
                       books.description, books.status, users.username AS owner_username
                FROM books
                INNER JOIN users ON books.user_id = users.id
                WHERE books.status = "available"
                AND books.title LIKE :search
                ORDER BY books.created_at DESC, books.id DESC';

        $query = $this->db->prepare($sql);
        $query->execute([
            'search' => '%' . $search . '%',
        ]);

        return $this->createBooks($query->fetchAll());
    }

    public function findBookById(int $id): ?Book
    {
        $sql = 'SELECT books.id, books.user_id, books.title, books.author, books.image,
                       books.description, books.status, users.username AS owner_username
                FROM books
                INNER JOIN users ON books.user_id = users.id
                WHERE books.id = :id';

        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
        ]);

        $bookData = $query->fetch();

        if (!$bookData) {
            return null;
        }

        return $this->createBook($bookData);
    }

    public function findBooksByUserId(int $userId): array
    {
        $sql = 'SELECT books.id, books.user_id, books.title, books.author, books.image,
                       books.description, books.status, users.username AS owner_username
                FROM books
                INNER JOIN users ON books.user_id = users.id
                WHERE books.user_id = :user_id
                ORDER BY books.created_at DESC, books.id DESC';

        $query = $this->db->prepare($sql);
        $query->execute([
            'user_id' => $userId,
        ]);

        return $this->createBooks($query->fetchAll());
    }

    public function countBooksByUserId(int $userId): int
    {
        $sql = 'SELECT COUNT(*) FROM books WHERE user_id = :user_id';

        $query = $this->db->prepare($sql);
        $query->execute([
            'user_id' => $userId,
        ]);

        return (int) $query->fetchColumn();
    }

    public function deleteBook(int $id): void
    {
        $sql = 'DELETE FROM books WHERE id = :id';

        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
        ]);
    }

    private function createBooks(array $booksData): array
    {
        $books = [];

        foreach ($booksData as $bookData) {
            $books[] = $this->createBook($bookData);
        }

        return $books;
    }

    private function createBook(array $bookData): Book
    {
        return new Book(
            (int) $bookData['id'],
            (int) $bookData['user_id'],
            $bookData['title'],
            $bookData['author'],
            $bookData['image'],
            $bookData['description'],
            $bookData['status'],
            $bookData['owner_username']
        );
    }
}
