<?php

class MessageService
{
    public static function countUnreadMessagesForCurrentUser(): int
    {
        if (!isset($_SESSION['user_id'])) {
            return 0;
        }

        $messageManager = new MessageManager();

        return $messageManager->countUnreadMessages((int) $_SESSION['user_id']);
    }
}
