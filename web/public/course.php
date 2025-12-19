<?php
session_start();
//Page d'affichage d'UN cours
require_once __DIR__ . '/../src/Config/autoloader.php';
include __DIR__ . '/../src/Includes/header.php';

$courseContent = $language->getContent($lang, 'course');
$errorContent = $language->getContent($lang, 'common_errors');

$courseId = $_GET['id'] ?? null;
if (!$courseId) {
    header("Location: index.php");
    exit;
}

$userUsername = $_SESSION['username'] ?? null;

use Controllers\CoursesController;
use Controllers\UsersController;

try {
    $usersController = new UsersController();
    $courseController = new CoursesController();
} catch (Exception $e) {
    $errors = [$errorContent["connecting_db"]];
}
try {
    $course = $courseController->getCourse($courseId);
} catch (Exception $e) {
    $errors =[$errorContent["fetch_data"]];
}

if (!$course) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['subscribe'])) {
        if ($course->getTeacherId() === $_SESSION["user_id"]) {
            echo "Vous ne pouvez pas vous inscrire à votre propre cours."; // CHANGER LA LANGUE ET AJOUTER DANS UNE $ERRORS
        } else {
            $usersController->followCourse($courseId, $_SESSION['username']);
        }
    }
    if (isset($_POST['unsubscribe'])) {
        if ($course->getTeacherId() === $_SESSION["user_id"]) {
            echo "impossible de se désinscrire, vous êtes l'enseignant";
        } else {
            $usersController->unfollowCourse($courseId, $_SESSION['username']);
        }
        $isSubscribed = false;

        if (isset($_SESSION['username'])) {
            $isSubscribed = $usersController->isSubscribed($courseId, $_SESSION['username']);
        }
    }
    header("Location: course.php?id=" . $courseId);
    exit();
}

$isSubscribed = false;

if ($userUsername) {
    $isSubscribed = $usersController->isSubscribed($courseId, $userUsername);
}

?>

<a href="index.php">
    <?= $courseContent['back'] ?>
</a>

<?php if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p class=\"error\">$error</p>";
    }
} ?>

<h2 class="title"><?= $course->getTitle(true) ?></h2>
<p class="shortdescr"><?= $course->getDescr(true) ?></p>
<div class="attributes">
    <p class="teacher"><?= $courseContent["teacher"] ?>: <?= $course->getTeacherFirstname(true) . " " . $course->getTeacherLastname(true) ?></p>
    <p class="subject"><?= $courseContent["subject"] ?>: <?= $course->getSubject(true) ?></p>
    <p class="course-description"><?= $courseContent["course-description"] ?>: <?= $course->getDescr(true) ?></p>
    <p class="startdatetime"><?= $courseContent["on"] ?> <?= htmlspecialchars(date('d M', strtotime($course->getStartDatetime()))) ?> <?= $courseContent["at"] ?> <?= htmlspecialchars(date('G', strtotime($course->getStartDatetime()))) ?> <?= $courseContent["hour"] ?> <?= htmlspecialchars(date('i', strtotime($course->getStartDatetime()))) ?> </p>
    <p class="subscriptions"><?= $courseContent["subscriptions"] ?>: <?= $course->getSubStudents(true) ?></p>
    <p class="duration"><?= $courseContent["duration"] ?>: <?= $course->getDuration(true) ?></p>
    <p class="price"><?= $courseContent["price"] ?>: <?= $course->getPricePerStudent(true) ?> CHF</p>
</div>
<?php if ($userUsername): ?>

    <?php if ($isSubscribed): ?>

        <form method="post">
            <button type="submit" name="unsubscribe">
                <?= $courseContent['unsubscribe'] ?>
            </button>
        </form>

    <?php else: ?>
        <?php if (isset($_SESSION["user_id"]) && $course->getTeacherId() === $_SESSION["user_id"]): ?>
            <form action="">
                <button type="button" name="">
                    <?= $courseContent['your_are_teaching'] ?>
                </button>
            </form>
        <?php else: ?>
            <form method="post">
                <button type="submit" name="subscribe">
                    <?= $courseContent['subscribe'] ?>
                </button>
            </form>
        <?php endif; ?>
    <?php endif; ?>

<?php else: ?>
    <a href="login.php">
        <button><?= $courseContent['login'] ?></button>
    </a>
<?php endif; ?>

<?php include __DIR__ . '/../src/Includes/footer.php'; ?>