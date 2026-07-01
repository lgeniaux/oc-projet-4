<?php

class MessageController
{
    public function showMessages(): void
    {
        AuthService::requireAuth();

        $currentUserId = (int) $_SESSION['user_id'];
        $selectedUserId = (int) Utils::request('user', 0);
        $error = null;

        $userManager = new UserManager();
        $messageManager = new MessageManager();
        $selectedUser = null;

        if ($selectedUserId > 0) {
            if ($selectedUserId === $currentUserId) {
                Utils::redirect('messages');
            }

            $selectedUser = $userManager->findUserById($selectedUserId);

            if ($selectedUser === null) {
                throw new NotFoundException("L'utilisateur demandé n'existe pas.");
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($selectedUser === null) {
                throw new NotFoundException("L'utilisateur demandé n'existe pas.");
            }

            $content = trim(Utils::request('content', ''));

            if ($content === '') {
                $error = 'Le message ne peut pas être vide.';
            } else {
                $messageManager->createMessage($currentUserId, $selectedUser->getId(), $content);
                Utils::redirect('messages', ['user' => $selectedUser->getId()]);
            }
        }

        if ($selectedUser !== null) {
            $messageManager->markMessagesAsRead($currentUserId, $selectedUser->getId());
        }

        $conversations = $messageManager->findConversationsByUserId($currentUserId);
        $messages = [];

        if ($selectedUser !== null) {
            $messages = $messageManager->findMessagesBetweenUsers($currentUserId, $selectedUser->getId());
        }

        $selectedUserImage = '';

        if ($selectedUser !== null) {
            $selectedUserImage = trim((string) $selectedUser->getProfileImage());
        }

        $view = new View('Messagerie');
        $view->render('messages', [
            'conversations' => $conversations,
            'messages' => $messages,
            'selectedUser' => $selectedUser,
            'selectedUserImage' => $selectedUserImage,
            'currentUserId' => $currentUserId,
            'error' => $error,
        ]);
    }
}
