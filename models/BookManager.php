<?php

class BookManager
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
     * Récupère les derniers livres disponibles.
     * @param int $limit : le nombre maximum de livres à retourner.
     * @return array : la liste des livres.
     */
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

    /**
     * Récupère tous les livres disponibles.
     * @return array : la liste des livres disponibles.
     */
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

    /**
     * Recherche les livres disponibles par titre.
     * @param string $search : le texte recherché.
     * @return array : la liste des livres trouvés.
     */
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

    /**
     * Récupère un livre par son identifiant.
     * @param int $id : l'identifiant du livre.
     * @return Book|null : le livre trouvé ou null.
     */
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

    /**
     * Récupère les livres d'un utilisateur.
     * @param int $userId : l'identifiant de l'utilisateur.
     * @return array : la liste des livres.
     */
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

    /**
     * Compte les livres d'un utilisateur.
     * @param int $userId : l'identifiant de l'utilisateur.
     * @return int : le nombre de livres.
     */
    public function countBooksByUserId(int $userId): int
    {
        $sql = 'SELECT COUNT(*) FROM books WHERE user_id = :user_id';

        $query = $this->db->prepare($sql);
        $query->execute([
            'user_id' => $userId,
        ]);

        return (int) $query->fetchColumn();
    }

    /**
     * Crée un livre dans la bibliothèque d'un utilisateur.
     * @param int $userId : l'identifiant du propriétaire.
     * @param string $title : le titre du livre.
     * @param string $author : l'auteur du livre.
     * @param string $image : l'URL de l'image.
     * @param string $description : la description du livre.
     * @param string $status : le statut de disponibilité.
     * @return int : l'identifiant du livre créé.
     */
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

    /**
     * Met à jour les informations d'un livre.
     * @param int $id : l'identifiant du livre.
     * @param string $title : le titre du livre.
     * @param string $author : l'auteur du livre.
     * @param string $image : l'URL de l'image.
     * @param string $description : la description du livre.
     * @param string $status : le statut de disponibilité.
     * @return void
     */
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

    /**
     * Supprime un livre par son identifiant.
     * @param int $id : l'identifiant du livre.
     * @return void
     */
    public function deleteBook(int $id): void
    {
        $sql = 'DELETE FROM books WHERE id = :id';

        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id,
        ]);
    }

    /**
     * Transforme des lignes SQL en objets Book.
     * @param array $booksData : les lignes retournées par la base.
     * @return array : la liste des livres hydratés.
     */
    private function hydrateBooks(array $booksData): array
    {
        $books = [];

        foreach ($booksData as $bookData) {
            $books[] = $this->hydrateBook($bookData);
        }

        return $books;
    }

    /**
     * Transforme une ligne SQL en objet Book.
     * @param array $bookData : les données du livre.
     * @return Book : le livre hydraté.
     */
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
