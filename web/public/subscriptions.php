<?php
session_start();

include __DIR__ . '/../src/Includes/header.php';

// Vérifie si l'utilisateur est authentifié
$username = $_SESSION['username'] ?? null;

// L'utilisateur n'est pas authentifié
if (!$username) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    header('Location: login.php');
    exit();
}

use Controllers\UsersController;

$subscriptionsContent = $language->getContent($lang, 'subscriptions');

try {
    $usersController = new UsersController();
} catch (Exception $e) {
    $errors = $subscriptionsContent["connexion_err"];
}

try {
    // Récupérer les cours de l'utilisateur
    $userCourses = $usersController->getUserCourses($username);
    $teacherCourses = $usersController->getTeacherCourses($username);
} catch (Exception $e) {
    $errors = $subscriptionsContent["fetch_err"];
}
?>

<?php if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p class=\"error\">$error</p>";
    }
} ?>
<?php if (empty($userCourses)): ?>
    <p><?= $subscriptionsContent["no_course"] ?></p>
<?php else: ?>
    <h2><?= $subscriptionsContent["history-title"] ?></h2>
    <div class="course-list">
        <?php foreach ($userCourses as $course) { ?>
            <a href="/course.php?id=<?= $course->getId(true) ?>" class="coursebox">
                <h2 class="title"><?= $course->getTitle(true) ?></h2>
                <p class="shortdescr"><?= $course->getDescr(true) ?></p>
                <div class="attributes">
                    <p class="teacher"><?= $subscriptionsContent["teacher"] ?>: <?= $course->getTeacherFirstname(true) . " " . $course->getTeacherLastname(true) ?></p>
                    <p class="subject"><?= $subscriptionsContent["subject"] ?>: <?= $course->getSubject(true) ?></p>
                    <p class="startdatetime"><?= $subscriptionsContent["on"] ?>: <?= htmlspecialchars(date('d M', strtotime($course->getStartDatetime()))) ?> <?= $subscriptionsContent["at"] ?> <?= htmlspecialchars(date('G', strtotime($course->getStartDatetime()))) ?> <?= $subscriptionsContent["hour"] ?> <?= htmlspecialchars(date('i', strtotime($course->getStartDatetime()))) ?> </p>
                    <p class="subscriptions"><?= $subscriptionsContent["subscriptions"] ?>: <?= $course->getSubStudents(true) ?></p>
                </div>
            </a>
        <?php } ?>
    </div>
<?php endif; ?>

<?php if (empty($userCourses)): ?>
    <p><?= $subscriptionsContent["no_course_given"] ?></p>
<?php else: ?>
    <h2><?= $subscriptionsContent["history-title-teacher"] ?></h2>
    <div class="course-list">
        <?php foreach ($teacherCourses as $course) { ?>
            <a href="/course.php?id=<?= $course->getId(true) ?>" class="coursebox">
                <h2 class="title"><?= $course->getTitle(true) ?></h2>
                <p class="shortdescr"><?= $course->getDescr(true) ?></p>
                <div class="attributes">
                    <p class="teacher"><?= $subscriptionsContent["teacher"] ?>: <?= $course->getTeacherFirstname(true) . " " . $course->getTeacherLastname(true) ?></p>
                    <p class="subject"><?= $subscriptionsContent["subject"] ?>: <?= $course->getSubject(true) ?></p>
                    <p class="startdatetime"><?= $subscriptionsContent["on"] ?>: <?= htmlspecialchars(date('d M', strtotime($course->getStartDatetime()))) ?> <?= $subscriptionsContent["at"] ?> <?= htmlspecialchars(date('G', strtotime($course->getStartDatetime()))) ?> <?= $subscriptionsContent["hour"] ?> <?= htmlspecialchars(date('i', strtotime($course->getStartDatetime()))) ?> </p>
                    <p class="subscriptions"><?= $subscriptionsContent["subscriptions"] ?>: <?= $course->getSubStudents(true) ?></p>
                </div>
            </a>
        <?php } ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../src/Includes/footer.php'; ?>