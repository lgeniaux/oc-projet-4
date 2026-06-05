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
}
