<?php

class HomeController
{
    public function showHome(): void
    {
        $bookManager = new BookManager();
        $books = $bookManager->findLatestAvailableBooks(4);

        $view = new View('Accueil');
        $view->render('home', [
            'books' => $books,
        ]);
    }
}
