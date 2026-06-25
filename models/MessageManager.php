<?php

class MessageManager
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DBManager::getConnection();
    }

    public function findConversationsByUserId(int $userId): array
    {
        $sql = <<<'SQL'
            /* On récupère le dernier message de chaque conversation. */
            SELECT messages.id,
                   messages.sender_id,
                   messages.receiver_id,
                   messages.content,
                   messages.is_read,
                   messages.created_at,
                   users.id AS other_user_id,
                   users.username AS other_username,
                   users.profile_image AS other_profile_image,
                   unread.unread_count
            FROM messages
            /*
             * Pour chaque message de l'utilisateur connecté, on retrouve l'autre personne.
             * Si je suis l'expéditeur, l'autre personne est le destinataire.
             * Si je suis le destinataire, l'autre personne est l'expéditeur.
             */
            INNER JOIN (
                SELECT
                    CASE
                        WHEN sender_id = :user_id_for_other THEN receiver_id
                        ELSE sender_id
                    END AS other_user_id,
                    MAX(id) AS last_message_id
                FROM messages
                WHERE sender_id = :user_id_for_sent
                OR receiver_id = :user_id_for_received
                GROUP BY other_user_id
            ) last_messages ON messages.id = last_messages.last_message_id
            /* On récupère les informations de l'autre utilisateur pour l'afficher dans la liste. */
            INNER JOIN users ON users.id = last_messages.other_user_id
            /* On compte les messages non lus envoyés par chaque conversation. */
            LEFT JOIN (
                SELECT sender_id, COUNT(*) AS unread_count
                FROM messages
                WHERE receiver_id = :user_id_for_unread
                AND is_read = 0
                GROUP BY sender_id
            ) unread ON unread.sender_id = users.id
            /* Les conversations les plus récentes apparaissent en premier. */
            ORDER BY messages.created_at DESC, messages.id DESC
            SQL;

        $query = $this->db->prepare($sql);
        $query->execute([
            'user_id_for_other' => $userId,
            'user_id_for_sent' => $userId,
            'user_id_for_received' => $userId,
            'user_id_for_unread' => $userId,
        ]);

        return $query->fetchAll();
    }

    public function findMessagesBetweenUsers(int $firstUserId, int $secondUserId): array
    {
        $sql = 'SELECT id, sender_id, receiver_id, content, is_read, created_at
                FROM messages
                WHERE (sender_id = :first_sender_id AND receiver_id = :first_receiver_id)
                OR (sender_id = :second_sender_id AND receiver_id = :second_receiver_id)
                ORDER BY created_at ASC, id ASC';

        $query = $this->db->prepare($sql);
        $query->execute([
            'first_sender_id' => $firstUserId,
            'first_receiver_id' => $secondUserId,
            'second_sender_id' => $secondUserId,
            'second_receiver_id' => $firstUserId,
        ]);

        return $this->hydrateMessages($query->fetchAll());
    }

    public function createMessage(int $senderId, int $receiverId, string $content): void
    {
        $sql = 'INSERT INTO messages (sender_id, receiver_id, content)
                VALUES (:sender_id, :receiver_id, :content)';

        $query = $this->db->prepare($sql);
        $query->execute([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'content' => $content,
        ]);
    }

    public function markMessagesAsRead(int $currentUserId, int $otherUserId): void
    {
        $sql = 'UPDATE messages
                SET is_read = 1
                WHERE sender_id = :other_user_id
                AND receiver_id = :current_user_id
                AND is_read = 0';

        $query = $this->db->prepare($sql);
        $query->execute([
            'other_user_id' => $otherUserId,
            'current_user_id' => $currentUserId,
        ]);
    }

    public function countUnreadMessages(int $userId): int
    {
        $sql = 'SELECT COUNT(*)
                FROM messages
                WHERE receiver_id = :user_id
                AND is_read = 0';

        $query = $this->db->prepare($sql);
        $query->execute([
            'user_id' => $userId,
        ]);

        return (int) $query->fetchColumn();
    }

    private function hydrateMessages(array $messagesData): array
    {
        $messages = [];

        foreach ($messagesData as $messageData) {
            $messages[] = new Message(
                (int) $messageData['id'],
                (int) $messageData['sender_id'],
                (int) $messageData['receiver_id'],
                $messageData['content'],
                (bool) $messageData['is_read'],
                $messageData['created_at']
            );
        }

        return $messages;
    }
}
