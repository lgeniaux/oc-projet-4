<?php

class BookController
{
    public function showBooks(): void
    {
        $search = trim($_GET['search'] ?? '');

        $bookManager = new BookManager();

        if ($search === '') {
            $books = $bookManager->findAvailableBooks();
        } else {
            $books = $bookManager->searchAvailableBooksByTitle($search);
        }

        $view = new View('Nos livres à l\'échange');
        $view->render('books', [
            'books' => $books,
            'search' => $search,
        ]);
    }

    public function showBook(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        $bookManager = new BookManager();
        $book = $bookManager->findBookById($id);

        if ($book === null) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        $view = new View($book->getTitle());
        $view->render('book', [
            'book' => $book,
        ]);
    }

    public function deleteBook(): void
    {
        AuthService::requireAuth();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        $bookManager = new BookManager();
        $book = $bookManager->findBookById($id);

        if ($book === null) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        AuthService::requireBookOwner($book);

        $bookManager->deleteBook($id);

        header('Location: index.php?action=profile&id=' . $_SESSION['user_id']);
        exit;
    }
}
