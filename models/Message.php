<?php

class Message
{
    private int $id;
    private int $senderId;
    private int $receiverId;
    private string $content;
    private bool $isRead;
    private string $createdAt;

    /**
     * Construit un message avec les données récupérées en base.
     */
    public function __construct(
        int $id,
        int $senderId,
        int $receiverId,
        string $content,
        bool $isRead,
        string $createdAt
    ) {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->content = $content;
        $this->isRead = $isRead;
        $this->createdAt = $createdAt;
    }

    /**
     * Retourne l'identifiant du message.
     * @return int : l'identifiant du message.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Retourne l'identifiant de l'expéditeur.
     * @return int : l'identifiant de l'expéditeur.
     */
    public function getSenderId(): int
    {
        return $this->senderId;
    }

    /**
     * Retourne l'identifiant du destinataire.
     * @return int : l'identifiant du destinataire.
     */
    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    /**
     * Retourne le contenu du message.
     * @return string : le contenu du message.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Indique si le message a été lu.
     * @return bool : true si le message est lu.
     */
    public function isRead(): bool
    {
        return $this->isRead;
    }

    /**
     * Retourne la date de création du message.
     * @return string : la date de création.
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
