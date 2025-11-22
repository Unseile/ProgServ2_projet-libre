<?php

//Implémentation du gestionnaire de cours
namespace Controllers;

require_once __DIR__ . '/../Config/autoloader.php';

use Config\Database, PDO, Models\Course;


class CoursesController
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getPDO();
    }

    public function addCourse(Course $course): void
    {
        $sql = "INSERT INTO course (
            teacherId,
            title,
            subject, 
            start_datetime, 
            duration, 
            descr, 
            location, 
            price_per_student, 
            number_stud_max, 
            number_stud_sub
        ) VALUES (
            :teacherId,
            :title,
            :subject, 
            :start_datetime, 
            :duration, 
            :descr, 
            :location, 
            :price_per_student, 
            :number_stud_max, 
            :number_stud_sub
        )";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":teacherId" => $course->getTeacherId(),
            ":title" => $course->getTitle(),
            ":subject" => $course->getSubject(),
            ":start_datetime" => $course->getStartDatetime(),
            ":duration" => $course->getDuration(),
            ":descr" => $course->getDescr(),
            ":location" => $course->getLocation(),
            ":price_per_student" => $course->getPricePerStudent(),
            ":number_stud_max" => $course->getMaxStudents(),
            ":number_stud_sub" => $course->getSubStudents()
        ]);
    }
    public function getCourse(int $id): ?Course
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
        FROM course
        INNER JOIN user ON user.id = fk_teacher_id.course
        WHERE id.course = :id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $course = $stmt->fetch();
        return $course;
    }
    public function getCourses(): array
    {
        $sql = "SELECT * FROM course ORDER BY course.start_datetime ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $courses = $stmt->fetchAll();
        return $courses;
    }
    public function updateCourse(Course $course): void
    {
        $sql = "UPDATE course SET 
            teacherId = :teacherId,
            title = :title,
            subject = :subject,
            start_datetime = :start_datetime,
            duration = :duration,
            descr = :descr,
            location = :location,
            price_per_student = :price_per_student,
            number_stud_max = :number_stud_max,
            number_stud_sub = :number_stud_sub
        WHERE id.course = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":teacherId" => $course->getTeacherId(),
            ":title" => $course->getTitle(),
            ":subject" => $course->getSubject(),
            ":start_datetime" => $course->getStartDatetime(),
            ":duration" => $course->getDuration(),
            ":descr" => $course->getDescr(),
            ":location" => $course->getLocation(),
            ":price_per_student" => $course->getPricePerStudent(),
            ":number_stud_max" => $course->getMaxStudents(),
            ":number_stud_sub" => $course->getSubStudents()
        ]);
    }
    public function deleteCourse(int $id): void
    {
        $sql = "DELETE course WHERE id = :id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }
}
