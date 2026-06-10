<?php

class UserController
{
    public function showProfile(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            throw new Exception("L'utilisateur demandé n'existe pas.");
        }

        $userManager = new UserManager();
        $user = $userManager->findUserById($id);

        if ($user === null) {
            throw new Exception("L'utilisateur demandé n'existe pas.");
        }

        $bookManager = new BookManager();
        $books = $bookManager->findBooksByUserId($id);
        $bookCount = $bookManager->countBooksByUserId($id);

        $view = new View($user->getUsername());
        $view->render('profile', [
            'profileUser' => $user,
            'books' => $books,
            'bookCount' => $bookCount,
        ]);
    }
}
