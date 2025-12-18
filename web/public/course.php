<?php
session_start();
//Page d'affichage d'UN cours
require_once __DIR__ . '/../src/Config/autoloader.php';
include __DIR__ . '/../src/Includes/header.php';

$courseContent = $language->getContent($lang, 'course');

$courseId = $_GET['id'] ?? null;
if (!$courseId) {
    exit;
}

$userUsername = $_SESSION['username'] ?? null;

use Controllers\CoursesController;
use Controllers\UsersController;

try {
    $usersController = new UsersController();
    $courseController = new CoursesController();
} catch (Exception $e) {
    $errors = ["Erreur lors de la connexion à la base de donnée"]; //A CHANGER LA LANGUE
}
try {
    $courses = $courseController->getCourses();
} catch (Exception $e) {
    $errors = ["Erreur lors de la récupération du cours"]; //A CHANGER LA LANGUE
}

$course = null;
foreach ($courses as $c) {
    if ($c->getId(true) == $courseId) {
        $course = $c;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['subscribe']) && isset($_SESSION['username'])) {
        $usersController->followCourse($courseId, $_SESSION['username']);
    }

    if (isset($_POST['unsubscribe']) && isset($_SESSION['username'])) {
        $usersController->unfollowCourse($courseId, $_SESSION['username']);
    }
    $isSubscribed = false;

    if (isset($_SESSION['username'])) {
        $isSubscribed = $usersController->isSubscribed($courseId, $_SESSION['username']);
    }

    if (isset($_POST['back'])) {
        header("Location: index.php");
        exit;
    }

    header("Location: course.php?id=" . $courseId);
    exit;
}

$isSubscribed = false;

if ($userUsername) {
    $isSubscribed = $usersController->isSubscribed($courseId, $userUsername);
}

?>

<form method="post">
    <button type="submit" name="back">
        <?= $courseContent['back'] ?>
    </button>
</form>

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
        <form method="post">
            <button type="submit" name="subscribe">
                <?= $courseContent['subscribe'] ?>
            </button>
        </form>
    <?php endif; ?>

<?php else: ?>
    <a href="login.php">
        <button><?= $courseContent['login'] ?></button>
    </a>
<?php endif; ?>

<?php include __DIR__ . '/../src/includes/footer.php'; ?>