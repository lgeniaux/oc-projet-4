<?php

class BookController
{
    /**
     * Affiche la liste des livres disponibles, avec recherche optionnelle.
     * @return void
     */
    public function showBooks(): void
    {
        $search = trim(Utils::request('search', ''));

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

    /**
     * Affiche la fiche détaillée d'un livre.
     * @return void
     */
    public function showBook(): void
    {
        $id = (int) Utils::request('id', 0);

        if ($id <= 0) {
            throw new NotFoundException("Le livre demandé n'existe pas.");
        }

        $bookManager = new BookManager();
        $book = $bookManager->findBookById($id);

        if ($book === null) {
            throw new NotFoundException("Le livre demandé n'existe pas.");
        }

        $view = new View($book->getTitle());
        $view->render('book', [
            'book' => $book,
        ]);
    }

    /**
     * Supprime un livre appartenant à l'utilisateur connecté.
     * @return void
     */
    public function deleteBook(): void
    {
        AuthService::requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::redirect('myprofile');
        }

        $id = (int) Utils::request('id', 0);

        if ($id <= 0) {
            throw new NotFoundException("Le livre demandé n'existe pas.");
        }

        $bookManager = new BookManager();
        $book = $bookManager->findBookById($id);

        if ($book === null) {
            throw new NotFoundException("Le livre demandé n'existe pas.");
        }

        AuthService::requireBookOwner($book);

        $bookManager->deleteBook($id);

        Utils::redirect('myprofile');
    }

    /**
     * Affiche et traite le formulaire d'ajout d'un livre.
     * @return void
     */
    public function addBook(): void
    {
        AuthService::requireAuth();

        $error = null;
        $formValues = [
            'title' => '',
            'author' => '',
            'description' => '',
            'image' => '',
            'status' => 'available',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim(Utils::request('title', ''));
            $author = trim(Utils::request('author', ''));
            $description = trim(Utils::request('description', ''));
            $image = trim(Utils::request('image', ''));
            $status = trim(Utils::request('status', 'available'));
            $formValues = compact('title', 'author', 'description', 'image', 'status');

            if ($title === '' || $author === '') {
                $error = 'Le titre et l\'auteur sont obligatoires.';
            } elseif (!Utils::isValidImageUrl($image)) {
                $error = 'L\'URL de l\'image doit être une adresse http ou https valide.';
            } elseif (!in_array($status, ['available', 'unavailable'], true)) {
                $error = 'Le statut choisi est invalide.';
            } else {
                $bookManager = new BookManager();
                $bookManager->createBook((int) $_SESSION['user_id'], $title, $author, $image, $description, $status);

                Utils::redirect('myprofile');
            }
        }

        $view = new View('Ajouter un livre');
        $view->render('edit-book', [
            'error' => $error,
            'formValues' => $formValues,
            'pageTitle' => 'Ajouter un livre',
            'formAction' => 'index.php?action=add-book',
        ]);
    }

    /**
     * Affiche et traite le formulaire de modification d'un livre.
     * @return void
     */
    public function editBook(): void
    {
        AuthService::requireAuth();

        $id = (int) Utils::request('id', 0);

        if ($id <= 0) {
            throw new NotFoundException("Le livre demandé n'existe pas.");
        }

        $bookManager = new BookManager();
        $book = $bookManager->findBookById($id);

        if ($book === null) {
            throw new NotFoundException("Le livre demandé n'existe pas.");
        }

        AuthService::requireBookOwner($book);

        $error = null;
        $formValues = [
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'description' => (string) $book->getDescription(),
            'image' => trim((string) $book->getImage()),
            'status' => $book->getStatus(),
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim(Utils::request('title', ''));
            $author = trim(Utils::request('author', ''));
            $description = trim(Utils::request('description', ''));
            $image = trim(Utils::request('image', ''));
            $status = trim(Utils::request('status', 'available'));
            $formValues = compact('title', 'author', 'description', 'image', 'status');

            if ($title === '' || $author === '') {
                $error = 'Le titre et l\'auteur sont obligatoires.';
            } elseif (!Utils::isValidImageUrl($image)) {
                $error = 'L\'URL de l\'image doit être une adresse http ou https valide.';
            } elseif (!in_array($status, ['available', 'unavailable'], true)) {
                $error = 'Le statut choisi est invalide.';
            } else {
                $bookManager->updateBook($id, $title, $author, $image, $description, $status);

                Utils::redirect('myprofile');
            }
        }

        $view = new View('Modifier un livre');
        $view->render('edit-book', [
            'error' => $error,
            'formValues' => $formValues,
            'pageTitle' => 'Modifier les informations',
            'formAction' => 'index.php?action=edit-book&id=' . $book->getId(),
        ]);
    }
}
