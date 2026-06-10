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

        $isOwnProfile = isset($_SESSION['user_id']) && (int) $_SESSION['user_id'] === $user->getId();

        if ($isOwnProfile) {
            AuthService::requireAuth();

            $error = null;
            $success = false;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = trim($_POST['email'] ?? '');
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';
                $profileImage = trim($_POST['profile_image'] ?? '');

                $error = AuthService::validateProfileUpdate($user, $email, $username, $password);

                if ($error === null) {
                    AuthService::updateProfile($user->getId(), $user, $email, $username, $password, $profileImage);
                    $user = $userManager->findUserById($user->getId());
                    $success = true;
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
            return;
        }

        $view = new View($user->getUsername());
        $view->render('profile', [
            'profileUser' => $user,
            'books' => $books,
            'bookCount' => $bookCount,
        ]);
    }
}
