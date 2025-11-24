<?php
session_start();
require_once __DIR__ . '/../src/Config/autoloader.php';

include __DIR__ . '/../src/includes/header.php'; 

use Controllers\CoursesController;

// Vérifier que l'utilisateur est connecté
$userUsername = $_SESSION['username'] ?? null;
if (!$userUsername) {
    header('Location: index.php');
    exit;
}

use Controllers\UsersController;

$usersController = new UsersController();
$subscriptionsContent = $language->getContent($lang, 'subscriptions');

// Récupérer les cours de l'utilisateur
$userCourses = $usersController->getUserCourses($userId);
?>

<h2><?= $subscriptionsContent["history-title"] ?? "Mes cours" ?></h2>

<?php if (empty($userCourses)): ?>
    <p>Vous n'êtes inscrit à aucun cours pour le moment.</p>
<?php else: ?>
    <div class="course-list">
        <?php foreach ($userCourses as $course): ?>
            <div class="coursebox">
                <h2><?= htmlspecialchars($course['user-courses']) ?></h2>
                <p><?= htmlspecialchars($course['teacher']) ?>: <?= $course->getTeacherFirstname(true) . " " . $course->getTeacherLastname(true) ?></p>
                <p><?= htmlspecialchars($course['subject']) ?>: <?= $course->getSubject(true) ?></p>
                <p><?= $subscriptionsContent["on"] ?>: <?= htmlspecialchars(date('d M', strtotime($course->getStartDatetime()))) ?> <?= $subscriptionsContent["at"] ?> <?= htmlspecialchars(date('G', strtotime($course->getStartDatetime()))) ?> <?= $subscriptionsContent["hour"] ?> <?= htmlspecialchars(date('i', strtotime($course->getStartDatetime()))) ?> </p>

                <a href="/course.php?id=<?= $course['id'] ?>"><?= $subscriptionsContent["course"] ?></a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../src/includes/footer.php'; ?>

