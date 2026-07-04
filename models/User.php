<?php

class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $passwordHash;
    private ?string $profileImage;
    private ?string $biography;
    private string $createdAt;

    /**
     * Construit un utilisateur avec les données récupérées en base.
     */
    public function __construct(
        int $id,
        string $username,
        string $email,
        string $passwordHash,
        ?string $profileImage,
        ?string $biography,
        string $createdAt
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->profileImage = $profileImage;
        $this->biography = $biography;
        $this->createdAt = $createdAt;
    }

    /**
     * Retourne l'identifiant de l'utilisateur.
     * @return int : l'identifiant utilisateur.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Retourne le pseudo de l'utilisateur.
     * @return string : le pseudo.
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Retourne l'adresse email de l'utilisateur.
     * @return string : l'adresse email.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Retourne le mot de passe hashé de l'utilisateur.
     * @return string : le hash du mot de passe.
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * Retourne l'URL de photo de profil de l'utilisateur.
     * @return string|null : l'URL ou null.
     */
    public function getProfileImage(): ?string
    {
        return $this->profileImage;
    }

    /**
     * Retourne la biographie de l'utilisateur.
     * @return string|null : la biographie ou null.
     */
    public function getBiography(): ?string
    {
        return $this->biography;
    }

    /**
     * Retourne la date de création du compte.
     * @return string : la date de création.
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
