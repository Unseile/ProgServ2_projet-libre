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
        VALUES (:firstname, :lastname, :password, :username, :email, 0, 0);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(
            [
                ":firstname" => $user->getFirstname(),
                ":lastname" => $user->getLastname(),
                ":username" => $user->getUsername(),
                ":email" => $user->getEmail(),
                ":password" => password_hash($user->getEntredPassword(), PASSWORD_DEFAULT)
            ]
        );
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
    public function followCourse(int $courseId, string $username): void
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
    public function unfollowCourse(int $courseId, string $username): void
    {
        $sql = "DELETE subscription
                INNER JOIN user
                ON user.id = subscription.fk_student_id
                WHERE subscription.id = :course
                AND user.username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":course" => $courseId,
            ":username" => $username
        ]);

        $sql = "UPDATE course
            SET number_stud_sub = number_stud_sub - 1
            WHERE id = :course";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":course" => $courseId
        ]);
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
}
