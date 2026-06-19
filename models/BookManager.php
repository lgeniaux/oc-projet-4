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
                LIMIT :limit';

        $query = $this->db->prepare($sql);
        $query->bindValue('limit', $limit, PDO::PARAM_INT);
        $query->execute();

        return $this->hydrateBooks($query->fetchAll());
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

        return $this->hydrateBooks($query->fetchAll());
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

        return $this->hydrateBooks($query->fetchAll());
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

        return $this->hydrateBook($bookData);
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

        return $this->hydrateBooks($query->fetchAll());
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

    public function createBook(
        int $userId,
        string $title,
        string $author,
        string $image,
        string $description,
        string $status
    ): int {
        $sql = 'INSERT INTO books (user_id, title, author, image, description, status)
                VALUES (:user_id, :title, :author, :image, :description, :status)';

        $query = $this->db->prepare($sql);
        $query->execute([
            'user_id' => $userId,
            'title' => $title,
            'author' => $author,
            'image' => $image === '' ? null : $image,
            'description' => $description === '' ? null : $description,
            'status' => $status,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateBook(
        int $id,
        string $title,
        string $author,
        string $image,
        string $description,
        string $status
    ): void {
        $sql = 'UPDATE books
                SET title = :title,
                    author = :author,
                    image = :image,
                    description = :description,
                    status = :status,
                    updated_at = NOW()
                WHERE id = :id';

        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
            'title' => $title,
            'author' => $author,
            'image' => $image === '' ? null : $image,
            'description' => $description === '' ? null : $description,
            'status' => $status,
        ]);
    }

    public function deleteBook(int $id): void
    {
        $sql = 'DELETE FROM books WHERE id = :id';

        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
        ]);
    }

    private function hydrateBooks(array $booksData): array
    {
        $books = [];

        foreach ($booksData as $bookData) {
            $books[] = $this->hydrateBook($bookData);
        }

        return $books;
    }

    private function hydrateBook(array $bookData): Book
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
