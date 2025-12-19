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
            fk_teacher_id,
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
        course.id,
        fk_teacher_id,
        first_name AS \"teacher_firstname\",
        last_name AS \"teacher_lastname\",
        title, subject,
        start_datetime,
        duration,
        descr,
        location,
        price_per_student,
        number_stud_max,
        number_stud_sub
        FROM course
        INNER JOIN user ON user.id = course.fk_teacher_id
        WHERE course.id = :id
        ORDER BY course.start_datetime ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }
        return $this->toCourse($result);
    }

    public function getCourses(): array
    {
        $sql = "SELECT 
        course.id,
        fk_teacher_id,
        first_name AS \"teacher_firstname\",
        last_name AS \"teacher_lastname\",
        title, subject,
        start_datetime,
        duration,
        descr,
        location,
        price_per_student,
        number_stud_max,
        number_stud_sub
        FROM course
        INNER JOIN user ON user.id = course.fk_teacher_id
        ORDER BY course.start_datetime ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $courses = $stmt->fetchAll();
        return $this->toCourses($courses);
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

    private function toCourses($results): array
    {
        $courses = [];
        foreach ($results as $result) {
            array_push($courses, $this->toCourse($result));
        }
        return $courses;
    }

    private function toCourse($result): Course
    {
        $course = new Course(
            $result['fk_teacher_id'],
            $result['title'],
            $result['subject'],
            $result['start_datetime'],
            $result['duration'],
            $result['descr'],
            $result['location'],
            $result['price_per_student'],
            $result['number_stud_max'],
            $result['number_stud_sub']
        );
        $course->setId($result['id']);
        $course->setTeacher($result['teacher_firstname'], $result['teacher_lastname']);
        return $course;
    }
}
