<?php

class HomeController
{
    /**
     * Affiche la page d'accueil avec les derniers livres disponibles.
     * @return void
     */
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
