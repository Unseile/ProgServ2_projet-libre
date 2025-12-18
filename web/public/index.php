<?php

session_start();

include __DIR__ . '/../src/Includes/header.php';

//Page d'accueil / liste de tous les cours


use Controllers\CoursesController;

try {
    $courseController = new CoursesController();
} catch (Exception $e) {
    $errors = ["erreur lors de la connexion à al base de donnée"]; //A MODIFIER LA LANGUE
}

try {
    $courses = $courseController->getCourses();
} catch (Exception $e) {
    $errors = ["erreur lors de la récupération des cours"]; // A MODIFIER LA LANGUE
}

$homeContent = $language->getContent($lang, 'index');
?>

<h2><?= $homeContent["welcome"] ?></h2>
<div>
    <h3><?= $homeContent["available-courses"] ?></h3>
    <?php foreach ($courses as $course) { ?>
        <a href="/course.php?id=<?= $course->getId(true) ?>" class="coursebox">
            <h2 class="title"><?= $course->getTitle(true) ?></h2>
            <p class="shortdescr"><?= $course->getDescr(true) ?></p>
            <div class="attributes">
                <p class="teacher"><?= $homeContent["teacher"] ?>: <?= $course->getTeacherFirstname(true) . " " . $course->getTeacherLastname(true) ?></p>
                <p class="subject"><?= $homeContent["subject"] ?>: <?= $course->getSubject(true) ?></p>
                <p class="startdatetime"><?= $homeContent["on"] ?>: <?= htmlspecialchars(date('d M', strtotime($course->getStartDatetime()))) ?> <?= $homeContent["at"] ?> <?= htmlspecialchars(date('G', strtotime($course->getStartDatetime()))) ?> <?= $homeContent["hour"] ?> <?= htmlspecialchars(date('i', strtotime($course->getStartDatetime()))) ?> </p>
                <p class="subscriptions"><?= $homeContent["subscriptions"] ?>: <?= $course->getSubStudents(true) ?></p>
            </div>
        </a>
    <?php } ?>
</div>
<?php include __DIR__ . '/../src/Includes/footer.php'; ?>