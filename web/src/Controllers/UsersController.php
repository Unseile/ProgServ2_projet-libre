<?php

//Implémentations du gestionnaire d'utilisateurs
namespace Controllers;

require_once __DIR__ . '/../Config/autoloader.php';

use Config\Database, PDO, Models\User;

class UsersController
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new Database()->getPDO();
    }

    public function addUser(User $user): void {}
    /*public function getUser(int $id): ?User
    {
        return null;
    }*/
    public function getUserCourses(int $id): ?array
    {
        return null;
    }
    public function followCourse(int $courseId, string $username): void {}
    public function unfollowCourse(int $courseId, string $username): void {}
    public function getUser(string $username): ?User
    {
        return null;
    }
    public function deleteUser(string $username): void {}
    public function updateUser(User $user): void {}
}
