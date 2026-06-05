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
        $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $query->execute();

        return $this->createBooks($query->fetchAll());
    }

    private function createBooks(array $booksData): array
    {
        $books = [];

        foreach ($booksData as $bookData) {
            $books[] = new Book(
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

        return $books;
    }
}
