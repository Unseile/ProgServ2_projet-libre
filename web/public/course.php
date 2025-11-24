<?php
session_start();
//Page d'affichage d'UN cours
require_once __DIR__ . '/../src/Config/autoloader.php';
include __DIR__ . '/../src/includes/header.php';

$courseContent = $language->getContent($lang, 'course');

$courseId = $_GET['id'] ?? null;
if (!$courseId) {
    exit;
}

$userUsername = $_SESSION['username'] ?? null;

use Controllers\CoursesController;
use Controllers\UsersController;

$usersController = new UsersController();
$courseController = new CoursesController();
$courses = $courseController->getCourses();

$course = null;
foreach ($courses as $c) {
    if ($c->getId(true) == $courseId) {
        $course = $c;
        break;
    }
}

$isSubscribed = false;
if ($userUsername) {
    $isSubscribed = $usersController->followCourse($courseId, $userUsername);
}
?>

<h2 class="title"><?= $course->getTitle(true) ?></h2>
<p class="shortdescr"><?= $course->getDescr(true) ?></p>
<div class="attributes">
    <p class="teacher"><?= $courseContent["teacher"] ?>: <?= $course->getTeacherFirstname(true) . " " . $course->getTeacherLastname(true) ?></p>
    <p class="subject"><?= $courseContent["subject"] ?>: <?= $course->getSubject(true) ?></p>
    <p class="course-description"><?= $courseContent["course-description"] ?>: <?= htmlspecialchars($course->getDescr(true)) ?></p>
    <p class="startdatetime"><?= $courseContent["on"] ?> <?= htmlspecialchars(date('d M', strtotime($course->getStartDatetime()))) ?> <?= $courseContent["at"] ?> <?= htmlspecialchars(date('G', strtotime($course->getStartDatetime()))) ?> <?= $courseContent["hour"] ?> <?= htmlspecialchars(date('i', strtotime($course->getStartDatetime()))) ?> </p>
    <p class="subscriptions"><?= $courseContent["subscriptions"] ?>: <?= $course->getSubStudents(true) ?></p>
    <p class="duration"><?= $courseContent["duration"] ?>: <?= htmlspecialchars($course->getDuration(true)) ?></p>
    <p class="price"><?= $courseContent["price"] ?>: <?= htmlspecialchars($course->getPricePerStudent(true)) ?> CHF</p>
</div>
<?php if (isset($_SESSION['username'])) { ?>
    <button><?= $courseContent['subscribe'] ?></button>
<?php $usersController->followCourse($courseId, $userUsername);
} else if ($isSubscribed) { ?>
    <button><?= $courseContent['unsubscribe'] ?></button>
<?php $usersController->unfollowCourse($courseId, $userUsername);
} else { ?>
<a href="login.php">
    <button><?= $courseContent['login'] ?></button>
</a>
<?php } ?>

<?php include __DIR__ . '/../src/includes/footer.php';?>