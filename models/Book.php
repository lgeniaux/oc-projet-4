<?php

class Book
{
    private int $id;
    private int $userId;
    private string $title;
    private string $author;
    private ?string $image;
    private ?string $description;
    private string $status;
    private string $ownerUsername;

    public function __construct(
        int $id,
        int $userId,
        string $title,
        string $author,
        ?string $image,
        ?string $description,
        string $status,
        string $ownerUsername
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->author = $author;
        $this->image = $image;
        $this->description = $description;
        $this->status = $status;
        $this->ownerUsername = $ownerUsername;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getOwnerUsername(): string
    {
        return $this->ownerUsername;
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
