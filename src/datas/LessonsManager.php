<?php

//Implémentation du gestionnaire de cours
namespace datas;

require_once __DIR__ . '../utils/autoloader.php';

use datas\Database, PDO, classes\Lesson;


class LessonsManager
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
}
