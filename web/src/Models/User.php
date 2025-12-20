<?php

//Implémentations de la logique de l'objet utilisateur
namespace Models;

require_once __DIR__ . '/../Config/autoloader.php';

use Utils\Language;

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
    private Language $language;
    private array $translations;

    public function __construct($lastname, $firstname, $username, $email, $isTeacher = false)
    {
        $this->lastname = trim($lastname);
        $this->firstname = trim($firstname);
        $this->username = trim($username);
        $this->email = trim($email);
        $this->isEmailVerified = false;
        $this->isTeacher = $isTeacher;
        $this->language = new Language();
        $lang = $this->language->getCookieLanguage();
        $this->translations = $this->language->getContent($lang, 'validation_user');
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
    public function setEmailVerified($isEmailVerified): void
    {
        $this->isEmailVerified = boolval($isEmailVerified);
    }

    public function verify(): array
    {
        $errors = [];
        if (empty($this->lastname) || strlen($this->lastname) < 1) {
            array_push($errors, $this->translations['lastname_required']);
        }
        if (empty($this->firstname) || strlen($this->firstname) < 1) {
            array_push($errors, $this->translations['firstname_required']);
        }
        if (strlen($this->username) < 2) {
            array_push($errors, $this->translations['username_too_short']);
        }
        if (!isset($this->isTeacher) || ($this->isTeacher != true && $this->isTeacher != false)) {
            array_push($errors, $this->translations['teacher_value_invalid']);
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, $this->translations['email_invalid']);
        }
        if (empty($this->entredPassword) || strlen($this->entredPassword) < 5) {
            array_push($errors, $this->translations['password_too_short']);
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
