<?php

class MessageService
{
    /**
     * Compte les messages non lus de l'utilisateur connecté.
     * @return int : le nombre de messages non lus.
     */
    public static function countUnreadMessagesForCurrentUser(): int
    {
        if (!isset($_SESSION['user_id'])) {
            return 0;
        }

        $messageManager = new MessageManager();

        return $messageManager->countUnreadMessages((int) $_SESSION['user_id']);
    }
}
