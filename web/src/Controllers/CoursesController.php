<?php

//Implémentation du gestionnaire de cours
namespace datas;

require_once __DIR__ . '../utils/autoloader.php';

use datas\Database, PDO, classes\Lesson;


class CoursesController
{
    private PDO $pdo;

    public function __construct(): void
    {
        $this->pdo = new Database()->getPDO();
    }

    public function addLesson(Lesson $lesson): void {}
    public function followLesson(int $lessonId, int $userId): void {}
    public function unfollowLesson(int $lessonId, int $userId): void {}
    public function getLesson(int $id): ?Lesson
    {
        return null;
    }
    public function getLessons(): array
    {
        $sql = "SELECT * FROM lesson INNER JOIN user ON user.id = lesson.user_id WHERE lesson.end_datetime > now() ORDER BY lesson.start_datetime ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
