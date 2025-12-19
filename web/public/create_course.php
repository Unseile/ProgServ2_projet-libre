<?php
// //Page de création d'un cours
session_start();
require_once __DIR__ . '/../src/Config/autoloader.php';
include __DIR__ . '/../src/Includes/header.php';

use Controllers\CoursesController;
use Models\Course;

$createCourseContent = $language->getContent($lang, 'create_course');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if user is a teacher
if (!($_SESSION['isTeacher'] ?? false)) {
    header('Location: profile.php');
    exit();
}

$errors = [];

// Handle course creation POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT);
    $location = trim($_POST['location'] ?? '');
    $startDatetime = $_POST['start_datetime'] ?? '';
    $duration = filter_var($_POST['duration'] ?? 0, FILTER_VALIDATE_INT);
    $maxStudents = filter_var($_POST['max_students'] ?? 0, FILTER_VALIDATE_INT);

    // Validation basique
    if (empty($title)) {
        $errors[] = $createCourseContent['error_title'];
    }
    if (empty($subject)) {
        $errors[] = $createCourseContent['error_subject'];
    }
    if (empty($startDatetime)) {
        $errors[] = $createCourseContent['error_date'];
    }
    if ($duration === false || $duration < 15) {
        $errors[] = $createCourseContent['error_duration'];
    }
    if (empty($location)) {
        $errors[] = $createCourseContent['error_location'];
    }
    if ($price === false || $price < 0) {
        $errors[] = $createCourseContent['error_price'];
    }
    if ($maxStudents === false || $maxStudents < 1 || $maxStudents > 30) {
        $errors[] = $createCourseContent['error_max_students'];
    }

    // Create Course object with all required parameters
    if (empty($errors)) {
        try {
            $courseObj = new Course(
                $_SESSION['user_id'],  // teacherId
                $title,
                $subject,
                $startDatetime,
                $duration,
                $description,
                $location,
                $price,
                $maxStudents,
                0  // number_stud_sub = 0 au début
            );

            // Set teacher info for the course object
            $courseObj->setTeacher($_SESSION['firstname'], $_SESSION['lastname']);

            // Verify the course data
            $errors = $courseObj->verify();

            // If no errors, save the course
            if (empty($errors)) {
                $coursesController = new CoursesController();
                $coursesController->addCourse($courseObj);
                
                header('Location: index.php');
                exit();
            }
        } catch (Exception $e) {
            $errors[] = $createCourseContent['error_unexpected'] . ' : ' . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<body>
    <h2 class="title"><?= $createCourseContent["title"]?></h2>
    
    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
            <div class="error_message"><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form class="new_course" method="POST">
        <div class="course_title">
            <label for="title"><?= $createCourseContent["course_title"]?></label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
        </div>

        <div class="course_subject">
            <label for="subject"><?= $createCourseContent["course_subject"]?></label>
            <select id="subject" name="subject" required>
                <option value="">-- <?= $createCourseContent["select_subject"] ?> --</option>
                <option value="Anglais" <?= ($_POST['subject'] ?? '') === 'Anglais' ? 'selected' : '' ?>>Anglais</option>
                <option value="AnalysMar" <?= ($_POST['subject'] ?? '') === 'AnalysMar' ? 'selected' : '' ?>>Analyse Marketing</option>
                <option value="MarkDig" <?= ($_POST['subject'] ?? '') === 'MarkDig' ? 'selected' : '' ?>>Marketing Digital</option>
                <option value="ComVisuel" <?= ($_POST['subject'] ?? '') === 'ComVisuel' ? 'selected' : '' ?>>Communication Visuelle</option>
                <option value="EcrireWeb" <?= ($_POST['subject'] ?? '') === 'EcrireWeb' ? 'selected' : '' ?>>Écrire pour le Web</option>
                <option value="ProdCondMé1" <?= ($_POST['subject'] ?? '') === 'ProdCondMé1' ? 'selected' : '' ?>>Production Contenu Média 1</option>
                <option value="BaseProg" <?= ($_POST['subject'] ?? '') === 'BaseProg' ? 'selected' : '' ?>>Bases Programmation</option>
                <option value="BaseMath" <?= ($_POST['subject'] ?? '') === 'BaseMath' ? 'selected' : '' ?>>Bases Mathématiques</option>
                <option value="DeDonAInf" <?= ($_POST['subject'] ?? '') === 'DeDonAInf' ? 'selected' : '' ?>>De Données à Information</option>
                <option value="Droit1" <?= ($_POST['subject'] ?? '') === 'Droit1' ? 'selected' : '' ?>>Droit 1</option>
                <option value="EvolMétMéd" <?= ($_POST['subject'] ?? '') === 'EvolMétMéd' ? 'selected' : '' ?>>Évolution Métiers Médias</option>
                <option value="GesBudget" <?= ($_POST['subject'] ?? '') === 'GesBudget' ? 'selected' : '' ?>>Gestion Budget</option>
                <option value="IntroDura" <?= ($_POST['subject'] ?? '') === 'IntroDura' ? 'selected' : '' ?>>Introduction Durabilité</option>
                <option value="InfraDon1" <?= ($_POST['subject'] ?? '') === 'InfraDon1' ? 'selected' : '' ?>>Infrastructure Données 1</option>
                <option value="ProgServ1" <?= ($_POST['subject'] ?? '') === 'ProgServ1' ? 'selected' : '' ?>>Programmation Serveur 1</option>
            </select>
        </div>

        <div class="course_description">
            <label for="description"><?= $createCourseContent["course_description"]?></label>
            <textarea id="description" name="description" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <div class="course_price">
            <label for="price"><?= $createCourseContent["course_price"]?></label>
            <input type="number" id="price" name="price" step="0.05" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
        </div>

        <div class="course_place">
            <label for="location"><?= $createCourseContent["course_place"]?></label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($_POST['location'] ?? '') ?>" required>
        </div>

        <div class ="course_start_datetime">
            <label for="start_datetime"><?= $createCourseContent["course_start_datetime"]?></label>
            <input type="datetime-local" id="start_datetime" name="start_datetime" value="<?= htmlspecialchars($_POST['start_datetime'] ?? '') ?>" required>
        </div>

        <div class="course_duration">
            <label for="duration"><?= $createCourseContent["course_duration"]?></label>
            <input type="number" id="duration" name="duration" value="<?= htmlspecialchars($_POST['duration'] ?? '') ?>" required>
        </div>

        <div class="course_max_students">
            <label for="max_students"><?= $createCourseContent["course_max_students"]?></label>
            <input type="number" id="max_students" name="max_students" min="1" value="<?= htmlspecialchars($_POST['max_students'] ?? '') ?>" required>
        </div>

        <button class="create_button" type="submit"><?= $createCourseContent["create_button"]?></button>
        <a class="cancel_button" href="subscriptions.php"><?= $createCourseContent["cancel_button"]?></a>
    </form>
</body>

<?php include __DIR__ . '/../src/Includes/footer.php'; ?>
