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
$message = null;

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

    // Create Course object with all required parameters
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
            $maxStudents
        );

        // Set teacher info for the course object
        $courseObj->setTeacher($_SESSION['firstname'], $_SESSION['lastname']);

        // Verify the course data
        $errors = $courseObj->verify();

        // If no errors, save the course
        if (empty($errors)) {
            $coursesController = new CoursesController();
            $coursesController->addCourse($courseObj);

            $message = $createCourseContent['success_message'] ?? 'Course created successfully';
            header('Location: user_courses.php');
            exit();
        }
    } catch (Exception $e) {
        $errors[] = $createCourseContent['error_unexpected'] ?? 'An error occurred: ' . $e->getMessage();
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
            <label for="course"><?= $createCourseContent["course_subject"]?></label>
            <input type="text" id="course" name="course" value="<?= htmlspecialchars($_POST['course'] ?? '') ?>" required>
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
            <label for="place"><?= $createCourseContent["course_place"]?></label>
            <input type="text" id="place" name="place" value="<?= htmlspecialchars($_POST['place'] ?? '') ?>" required>
        </div>

        <div class ="course_start_datetime">
            <label for="start_date"><?= $createCourseContent["course_start_datetime"]?></label>
            <input type="datetime-local" id="start_date" name="start_date" value="<?= htmlspecialchars($_POST['start_date'] ?? '') ?>" required>
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
        <a class="cancel_button" href="user_courses.php"><?= $createCourseContent["cancel_button"]?></a>
    </form>
</body>

<?php include __DIR__ . '/../src/includes/footer.php'; ?>
