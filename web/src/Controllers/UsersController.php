<?php

//Implémentations du gestionnaire d'utilisateurs
namespace Controllers;

require_once __DIR__ . '/../Config/autoloader.php';

use Config\Database, PDO, Models\User, Models\Course;

class UsersController
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new Database()->getPDO();
    }

    public function addUser(User $user): void
    {
        $sql = "INSERT INTO user (firstname, lastname, username, email, email_verified, is_teacher)
        VALUES (:firstname, :lastname, :username, :email, 0, 0);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":firstname" => $user->getFirstname(),
            ":lastname" => $user->getLastname(),
            ":username" => $user->getUsername(),
            ":email" => $user->getEmail()
        ]);
    }
    /*public function getUser(int $id): ?User { return null; }*/
    public function getUserCourses(int $id): array
    {
        $sql = "SELECT 
        id.course,
        firstname AS \"teacher_firstname\",
        lastname AS \"teacher_lastname\",
        title, subject,
        start_datetime,
        duration,
        descr,
        location,
        price_per_student,
        number_stud_max,
        number_stud_sub
        FROM subscription 
        INNER JOIN course ON subscription.fk_course_id = course.id
        WHERE subscription.id = :id
        ORDER BY course.start_datetime ASC;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $userCourses = $stmt->fetchAll();
        return $userCourses;
    }

    public function getTeacherCourses(int $id): array
    {
        $sql = "SELECT * FROM course WHERE fk_teacher_id = :id ORDER BY course.start_datetime ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $teacherCourses = $stmt->fetchAll();
        return $teacherCourses;
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
