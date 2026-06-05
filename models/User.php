<?php

class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $passwordHash;
    private ?string $profileImage;
    private ?string $biography;

    public function __construct(
        int $id,
        string $username,
        string $email,
        string $passwordHash,
        ?string $profileImage,
        ?string $biography
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->profileImage = $profileImage;
        $this->biography = $biography;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getProfileImage(): ?string
    {
        return $this->profileImage;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }
}
