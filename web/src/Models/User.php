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
    private bool $isEmailVerified;
    private bool $isTeacher;
    private string $passwordHash;
    private string $entredPassword;

    public function __construct($lastname, $firstname, $username, $email, $isTeacher = false)
    {
        $this->lastname = trim($lastname);
        $this->firstname = trim($firstname);
        $this->username = trim($username);
        $this->email = trim($email);
        $this->isEmailVerified = false;
        $this->isTeacher = $isTeacher;
    }

    public function setClearPassword(string $entredPassword): void
    {
        $this->entredPassword = trim($entredPassword);
    }
    public function setHashPassword(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }
    public function setId(int $id): void
    {
        $this->id = intval($id);
    }
    public function setEmailVerified(): void
    {
        $this->isEmailVerified = true;
    }

    public function verify(): array
    {
        $errors = [];
        if (empty($this->lastname) || strlen($this->lastname) < 1) {
            array_push($errors, "Nom obligatoire de au moins 1 caractère");
        }
        if (empty($this->firstname) || strlen($this->firstname) < 1) {
            array_push($errors, "Prénom obligatoire de au moins 1 caractère");
        }
        if (strlen($this->username) < 2) {
            array_push($errors, "Le nom d'utilisateur doit avoir plus de 2 caractères");
        }
        if (!isset($this->isTeacher) || ($this->isTeacher != true && $this->isTeacher != false)) {
            array_push($errors, "Valeur d'enseignement invalide");
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email invalide");
        }
        if (empty($this->entredPassword) || strlen($this->entredPassword) < 5) {
            array_push($errors, "Le mot de passe doit avoir au moins 5 caractères");
        }
        return $errors;
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
        return null;
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
        return null;
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
        return null;
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
        return null;
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
        return null;
    }

    public function getIsEmailVerified(): ?bool
    {
        if (isset($this->isEmailVerified) && is_bool($this->isEmailVerified)) {
            return $this->isEmailVerified;
        }
        return null;
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
