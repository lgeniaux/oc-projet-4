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

    public function showMyProfile(): void
    {
        AuthService::requireAuth();

        $userManager = new UserManager();
        $user = $userManager->findUserById((int) $_SESSION['user_id']);

        $bookManager = new BookManager();
        $books = $bookManager->findBooksByUserId($user->getId());
        $bookCount = $bookManager->countBooksByUserId($user->getId());

        $error = null;
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $profileImage = trim($_POST['profile_image'] ?? '');

            $result = AuthService::updateProfile($user, $email, $username, $password, $profileImage);

            if ($result['user'] !== null) {
                $user = $result['user'];
                $success = true;
            } else {
                $error = $result['error'];
            }
        }

        $view = new View('Mon compte');
        $view->render('myprofile', [
            'profileUser' => $user,
            'books' => $books,
            'bookCount' => $bookCount,
            'error' => $error,
            'success' => $success,
        ]);
    }
}
