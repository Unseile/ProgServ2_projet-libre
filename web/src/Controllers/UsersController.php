<?php

//Implémentations du gestionnaire d'utilisateurs
namespace Controllers;

use Exception;

require_once __DIR__ . '/../Config/autoloader.php';

use Config\Database, PDO, Models\User, Models\Course;
use Utils\Language;

class UsersController
{
    private PDO $pdo;
    private Language $language;
    private array $translations;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getPDO();
        $this->language = new Language();
        $lang = $this->language->getCookieLanguage();
        $this->translations = $this->language->getContent($lang, 'controller_errors');
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

    public function followCourse(int $courseId, string $username): void
    {
        try {
            // Démarrer la transaction
            $this->pdo->beginTransaction();

            // Récupérer l'ID de l'utilisateur à partir du username
            $sql = "SELECT id, is_teacher FROM user WHERE username = :username";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":username" => $username]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$user) {
                throw new Exception($this->translations['user_not_found']);
            }

            $userId = $user['id'];

            // Vérifier que le cours existe et récupérer ses informations
            $sql = "SELECT number_stud_sub, number_stud_max, fk_teacher_id 
                    FROM course 
                    WHERE id = :course";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":course" => $courseId]);
            $course = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$course) {
                throw new Exception($this->translations['course_not_found']);
            }

            // Vérifier qu'il reste de la place dans le cours
            if ($course['number_stud_sub'] >= $course['number_stud_max']) {
                throw new Exception($this->translations['course_full']);
            }

            // Vérifier que l'utilisateur n'est pas déjà inscrit
            $sql = "SELECT COUNT(*) FROM subscription 
                    WHERE fk_course_id = :course AND fk_student_id = :user";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ":course" => $courseId,
                ":user" => $userId
            ]);
            $alreadySubscribed = $stmt->fetchColumn();

            if ($alreadySubscribed > 0) {
                throw new Exception($this->translations['already_subscribed']);
            }

            // Inscrire l'utilisateur au cours
            $sql = "INSERT INTO subscription (fk_course_id, fk_student_id)
                VALUES (:course, :user)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ":user" => $userId,
                ":course" => $courseId
            ]);

            // Incrémenter le compteur d'étudiants
            $sql = "UPDATE course
                SET number_stud_sub = number_stud_sub + 1
                WHERE id = :course";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ":course" => $courseId
            ]);

            // Valider la transaction
            $this->pdo->commit();
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->pdo->rollBack();
            throw $e;
        }
    }
    public function unfollowCourse(int $courseId, string $username): void
    {
        $user = $this->getUser($username);
        if (!$user) {
            return;
        }

        $userId = $user->getId();

        try {
            // Démarrer la transaction
            $this->pdo->beginTransaction();

            // Supprimer l'inscription
            $sql = "DELETE FROM subscription
                WHERE fk_course_id = :course
                AND fk_student_id = :user";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':course' => $courseId,
                ':user'   => $userId
            ]);

            // Décrémenter le compteur d'étudiants
            $sql = "UPDATE course
                SET number_stud_sub = number_stud_sub - 1
                WHERE id = :course";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ":course" => $courseId
            ]);

            // Valider la transaction
            $this->pdo->commit();
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->pdo->rollBack();
            throw $e;
        }
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
