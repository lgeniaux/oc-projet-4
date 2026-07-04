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

    /**
     * Construit un livre avec les données récupérées en base.
     */
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

    /**
     * Retourne l'identifiant du livre.
     * @return int : l'identifiant du livre.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Retourne l'identifiant du propriétaire.
     * @return int : l'identifiant utilisateur.
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Retourne le titre du livre.
     * @return string : le titre.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Retourne l'auteur du livre.
     * @return string : l'auteur.
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Retourne l'URL de l'image du livre.
     * @return string|null : l'URL ou null.
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Retourne la description du livre.
     * @return string|null : la description ou null.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Retourne le statut de disponibilité du livre.
     * @return string : le statut.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Retourne le pseudo du propriétaire du livre.
     * @return string : le pseudo du propriétaire.
     */
    public function getOwnerUsername(): string
    {
        return $this->ownerUsername;
    }

    /**
     * Indique si le livre est disponible à l'échange.
     * @return bool : true si le livre est disponible.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
