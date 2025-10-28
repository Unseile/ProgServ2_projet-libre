<?php

//Implémentations du gestionnaire d'utilisateurs
namespace Controllers;

require_once __DIR__ . '../Config/autoloader.php';

use Config\Database, PDO, Models\User;

class UsersController
{
    private PDO $pdo;

    public function __construct(): void
    {
        $this->pdo = new Database()->getPDO();
    }

    public function addUser(User $user): void {}
    public function getUser(int $id): ?User
    {
        return null;
    }
}
