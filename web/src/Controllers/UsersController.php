<?php

//Implémentations du gestionnaire d'utilisateurs
namespace datas;

require_once __DIR__ . '../utils/autoloader.php';

use datas\Database, PDO, classes\User;

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
