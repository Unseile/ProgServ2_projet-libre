<?php
//Page de création d'un cours
require_once __DIR__ . '/../src/Config/autoloader.php';

include __DIR__ . '/../src/includes//header.php';

$createCourseContent = $language->getContent($lang, 'create_course');?>

<body>
    <h2 class="title"><?= $createCourseContent["title"]?></h2>
    
    <?php if ($message): ?>
        <div class="error_message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form class="new_course" method="POST">
        <div class="course_title">
            <label for="title"><?= $createCourseContent["course_title"]?></label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="course_subject">
            <label for="course"><?= $createCourseContent["course_subject"]?></label>
            <input type="text" id="course" name="course" required>
        </div>

        <div class="course_description">
            <label for="description"><?= $createCourseContent["course_description"]?></label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div class="course_price">
            <label for="price"><?= $createCourseContent["course_price"]?></label>
            <input type="number" id="price" name="price" step="0.05" required>
        </div>

        <div class="course_place">
            <label for="place"><?= $createCourseContent["course_place"]?></label>
            <input type="text" id="place" name="place" required>
        </div>

        <div class ="course_start_datetime">
            <label for="start_datetime"><?= $createCourseContent["course_start_datetime"]?></label>
            <input type="datetime" id="start_date" name="start_date" required>
        </div>

        <div class="course_duration">
            <label for="duration"><?= $createCourseContent["course_duration"]?></label>
            <input type="number" id="duration" name="duration" required>
        </div>

        <div class="course_max_students">
            <label for="max_students"><?= $createCourseContent["course_max_students"]?></label>
            <input type="number" id="max_students" name="max_students" min="1" required>
        </div>

        <button class="create_button" type="submit"><?= $createCourseContent["create_button"]?></button>
        <a class="cancel_button" href="user_courses.php"><?= $createCourseContent["cancel_button"]?></a>
    </form>
</body>

<?php include __DIR__ . '/../src/includes//footer.php'; ?>
