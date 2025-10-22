<?php

//Implémentations de la logique de l'objet utilisateur
namespace classes;

require_once __DIR__ . '../utils/autoloader.php';

class User
{
    private int $id;
    private string $lastname;
    private string $firstname;
    private string $username;
    private string $email;
    private bool $isTeacher;

    public function __construct(/* args*/): void {}
    public function verify(): array
    {
        return [];
    }
}
