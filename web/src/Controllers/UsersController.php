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
        $database = new Database();
        $this->pdo = $database->getPDO();
    }

    public function addUser(User $user): void
    {
        $sql = "INSERT INTO user (first_name, last_name, password, username, email, email_verified, is_teacher)
        VALUES (:firstname, :lastname, :password, :username, :email, 0, :is_teacher);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(
            [
                ":firstname" => $user->getFirstname(),
                ":lastname" => $user->getLastname(),
                ":username" => $user->getUsername(),
                ":email" => $user->getEmail(),
                ":password" => password_hash($user->getEntredPassword(), PASSWORD_DEFAULT),
                ":is_teacher" => $user->getIsTeacher()
            ]
        );
    }
    /*public function getUser(int $id): ?User { return null; }*/
    public function getUserCourses(string $username): array
    {
        $sql = "SELECT 
        course.id,
        course.fk_teacher_id,
        user.first_name AS \"teacher_firstname\",
        user.last_name AS \"teacher_lastname\",
        course.title, 
        course.subject,
        course.start_datetime,
        course.duration,
        course.descr,
        course.location,
        course.price_per_student,
        course.number_stud_max,
        course.number_stud_sub
        FROM subscription 
        INNER JOIN course ON subscription.fk_course_id = course.id
        INNER JOIN user ON user.id = course.fk_teacher_id
        WHERE subscription.fk_student_id = (SELECT id FROM user WHERE username = :username)
        ORDER BY course.start_datetime ASC;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":username", $username);
        $stmt->execute();
        $userCourses = $stmt->fetchAll();
        $courses = $this->toCourses($userCourses);
        return $courses;
    }

    public function getTeacherCourses(string $username): array
    {
        $sql = "SELECT 
        course.id,
        course.fk_teacher_id,
        user.first_name AS \"teacher_firstname\",
        user.last_name AS \"teacher_lastname\",
        course.title, 
        course.subject,
        course.start_datetime,
        course.duration,
        course.descr,
        course.location,
        course.price_per_student,
        course.number_stud_max,
        course.number_stud_sub
        FROM course
        INNER JOIN user ON user.id = course.fk_teacher_id
        WHERE fk_teacher_id = (SELECT id FROM user WHERE username = :username) 
        ORDER BY course.start_datetime ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":username", $username);
        $stmt->execute();
        $teacherCourses = $stmt->fetchAll();
        $courses = $this->toCourses($teacherCourses);
        return $courses;
    }
    public function followCourse(int $courseId, string $username): void //A CHANGER IMPÉRATIVEMENT !!!!!
    {
        // 1) Récupérer l'ID de l'utilisateur à partir du username
        $sql = "SELECT id FROM user WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":username" => $username]);
        $userId = $stmt->fetchColumn();

        if (!$userId) {
            throw new \Exception("Utilisateur introuvable");
        }

        // 2) Inscrire l'utilisateur au cours
        $sql = "INSERT INTO subscription (fk_course_id, fk_student_id)
            VALUES (:course, :user)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":user" => $userId,
            ":course" => $courseId
        ]);

        $sql = "UPDATE course
            SET number_stud_sub = number_stud_sub + 1
            WHERE id = :course";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":course" => $courseId
        ]);
    }
    public function unfollowCourse(int $courseId, string $username): void //A CHANGER IMPÉRATIVEMENT !!!!!
    {
        $user = $this->getUser($username);
        if (!$user) {
            return;
        }

        $userId = $user->getId();

        $sql = "DELETE FROM subscription
            WHERE fk_course_id = :course
            AND fk_student_id = :user";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':course' => $courseId,
            ':user'   => $userId
        ]);

        $sql = "UPDATE course
            SET number_stud_sub = number_stud_sub - 1
            WHERE id = :course";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":course" => $courseId
        ]);
    }

    public function isSubscribed(int $courseId, string $username): bool
    {
        $user = $this->getUser($username);

        if (!$user) {
            return false;
        }

        $userId = $user->getId();

        $stmt = $this->pdo->prepare(
            "SELECT 1 FROM subscription WHERE fk_course_id = ? AND fk_student_id = ?"
        );
        $stmt->execute([$courseId, $userId]);

        return (bool) $stmt->fetchColumn();
    }


    public function getUser(string $username): ?User
    {
        $sql = "SELECT *
                FROM user
                WHERE username = :username
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":username" => $username]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            $user = new User(
                $result["last_name"],
                $result["first_name"],
                $result["username"],
                $result["email"],
                $result["is_teacher"]
            );
            $user->setId($result['id']);
            $user->setEmailVerified($result["email_verified"]);
            $user->setHashPassword($result["password"]);
            return $user;
        }
        return null;
    }
    public function setEmailValidate($username): void
    {
        $sql = "UPDATE user
                SET email_verified = 1 
                WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":username" => $username]);
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
