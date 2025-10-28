<?php

//Implémentation du gestionnaire de cours
namespace Controllers;

require_once __DIR__ . '/../Config/autoloader.php';

use Config\Database, PDO, Models\Course;


class CoursesController
{
    private PDO $pdo;

    public function __construct(): void
    {
        $this->pdo = new Database()->getPDO();
    }

    public function addCourse(Course $course): void {}
    public function followCourse(int $courseId, int $userId): void {}
    public function unfollowCourse(int $courseId, int $userId): void {}
    public function getCourse(int $id): ?Course
    {
        return null;
    }
    public function getCourses(): array
    {
        $sql = "SELECT * FROM course INNER JOIN user ON user.id = course.user_id WHERE course.end_datetime > now() ORDER BY course.start_datetime ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
