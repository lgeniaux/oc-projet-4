<?php

class Message
{
    private int $id;
    private int $senderId;
    private int $receiverId;
    private string $content;
    private bool $isRead;
    private string $createdAt;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }

    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isRead(): bool
    {
        return $this->isRead;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
