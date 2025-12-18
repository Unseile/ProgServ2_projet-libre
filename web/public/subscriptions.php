<?php
session_start();


include __DIR__ . '/../src/Includes/header.php';

use Controllers\CoursesController;

// Vérifie si l'utilisateur est authentifié
$username = $_SESSION['username'] ?? null;

// L'utilisateur n'est pas authentifié
if (!$username) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    header('Location: login.php');
    exit();
}

use Controllers\UsersController;

try {
    $usersController = new UsersController();
} catch (Exception $e) {
    $errors = ["erreur lors de la connexion à la base de donnée"]; // A MODIFIER LA LANGUE
}
$subscriptionsContent = $language->getContent($lang, 'subscriptions');

try {
    // Récupérer les cours de l'utilisateur
    $userCourses = $usersController->getUserCourses($username);
} catch (Exception $e) {
    $errors = ["erreur lors de la récupération de vos cours"]; // A MODIFIER LA LANGUE
}
?>

<h2><?= $subscriptionsContent["history-title"] ?? "Mes cours" ?></h2>

<?php if (empty($userCourses)): ?>
    <p>Vous n'êtes inscrit à aucun cours pour le moment.</p>
<?php else: ?>
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

<?php include __DIR__ . '/../src/Includes/footer.php'; ?>