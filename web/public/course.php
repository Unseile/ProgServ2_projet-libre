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

use Controllers\CoursesController;

$courseController = new CoursesController();
$courses = $courseController->getCourses();

$course = null;
foreach ($courses as $c) {
    if ($c->getId(true) == $courseId) {
        $course = $c;
        break;
    }
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
<?php if (isset($_SESSION['user_id'])) { ?>
    <button><?= $courseContent["subscribe"] ?></button>
<?php } else if ($course->getSubStudents($_SESSION["user"]["id"] ?? null)) { ?>
    <button><?= $courseContent["unsubscribe"] ?></button>
<?php } else { ?>
    <button><?= $courseContent["login"] ?></button>
<?php } ?>

<?php include __DIR__ . '/../src/includes/footer.php';?>