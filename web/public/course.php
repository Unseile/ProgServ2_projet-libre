<?php
session_start();
//Page d'affichage d'UN cours
require_once __DIR__ . '/../src/Config/autoloader.php';

include __DIR__ . '/../src/includes/header.php';
include __DIR__ . '/../src/includes/footer.php';

$courseContent = $language->getContent($lang, 'course');
?>

<h2 class="title"><?= $course->getTitle(true) ?></h2>
<p class="shortdescr"><?= $course->getDescr(true) ?></p>
<div class="attributes">
    <p class="teacher"><?= $homeContent["teacher"] ?>: <?= $course->getTeacherFirstname(true) . " " . $course->getTeacherLastname(true) ?></p>
    <p class="subject"><?= $homeContent["subject"] ?>: <?= $course->getSubject(true) ?></p>
    <p class="course-description"><?= $courseContent["course-description"] ?>: <?= htmlspecialchars($course->getDescr(true)) ?></p>
    <p class="startdatetime"><?= $homeContent["on"] ?>: <?= htmlspecialchars(date('d M', strtotime($course->getStartDatetime()))) ?> <?= $homeContent["at"] ?> <?= htmlspecialchars(date('G', strtotime($course->getStartDatetime()))) ?> <?= $homeContent["hour"] ?> <?= htmlspecialchars(date('i', strtotime($course->getStartDatetime()))) ?> </p>
    <p class="subscriptions"><?= $homeContent["subscriptions"] ?>: <?= $course->getSubStudents(true) ?></p>
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