<?php

//Page d'affichage d'UN cours
require_once __DIR__ . '/../src/Config/autoloader.php';
?>
<?php include __DIR__ . '/../src/includes/header.php'; ?>
<?php include __DIR__ . '/../src/includes/footer.php'; ?>


<h2 class="title"><?= $course->getTitle(true) ?></h2>
<p class="shortdescr"><?= $course->getDescr(true) ?></p>
<div class="attributes">
    <p class="teacher"><?= $homeContent["teacher"] ?>: <?= $course->getTeacherFirstname(true) . " " . $course->getTeacherLastname(true) ?></p>
    <p class="subject"><?= $homeContent["subject"] ?>: <?= $course->getSubject(true) ?></p>
    <p class="startdatetime"><?= $homeContent["on"] ?>: <?= htmlspecialchars(date('d M', strtotime($course->getStartDatetime()))) ?> <?= $homeContent["at"] ?> <?= htmlspecialchars(date('G', strtotime($course->getStartDatetime()))) ?> <?= $homeContent["hour"] ?> <?= htmlspecialchars(date('i', strtotime($course->getStartDatetime()))) ?> </p>
    <p class="subscriptions"><?= $homeContent["subscriptions"] ?>: <?= $course->getSubStudents(true) ?></p>
</div>
<button>S'inscrire à ce cours</button>
<button>Se désinscrire de ce cours</button>