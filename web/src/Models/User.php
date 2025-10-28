<?php

//Implémentations de la logique de l'objet utilisateur
namespace Models;

require_once __DIR__ . '/../Config/autoloader.php';

class User
{
    private int $id;
    private string $lastname;
    private string $firstname;
    private string $username;
    private string $email;
    private bool $isTeacher;
    private string $passwordHash;
    private string $entredPassword;

    public function __construct(/* args*/): void {}

    public function verify(): array
    {
        return [];
    }

    public function getId(bool $specialCharacters = false): ?int
    {
        if (isset($this->id) && is_int($this->id)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->id);
            } else {
                return $this->id;
            }
        }
        return '';
    }

    public function getLastname(bool $specialCharacters = false): ?string
    {
        if (isset($this->lastname) && is_string($this->lastname)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->lastname);
            } else {
                return $this->lastname;
            }
        }
        return '';
    }

    public function getFirstname(bool $specialCharacters = false): ?string
    {
        if (isset($this->firstname) && is_string($this->firstname)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->firstname);
            } else {
                return $this->firstname;
            }
        }
        return '';
    }

    public function getUsername(bool $specialCharacters = false): ?string
    {
        if (isset($this->username) && is_string($this->username)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->username);
            } else {
                return $this->username;
            }
        }
        return '';
    }

    public function getEmail(bool $specialCharacters = false): ?string
    {
        if (isset($this->email) && is_string($this->email)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->email);
            } else {
                return $this->email;
            }
        }
        return '';
    }

    public function getIsTeacher(): ?bool
    {
        if (isset($this->isTeacher) && is_bool($this->isTeacher)) {
            return $this->isTeacher;
        }
        return null;
    }

    public function getPasswordHash(): ?string
    {
        if (isset($this->passwordHash) && is_string($this->passwordHash)) {
            return $this->passwordHash;
        }
        return null;
    }

    public function getEntredPassword(): ?string
    {
        if (isset($this->entredPassword) && is_string($this->entredPassword)) {
            return $this->entredPassword;
        }
        return null;
    }
}
