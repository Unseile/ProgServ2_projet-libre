<?php

//Page d'accueil / liste de tous les cours

require_once __DIR__ . '../src/utils/autoloader.php';

use datas\LessonsManager;

$lessonsManager = new LessonsManager();

$lessons = $lessonsManager->getLessons();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php foreach ($lessons as $lesson) { ?>
        <?php echo $lesson->getTitle(true) ?>
    <?php } ?>
</body>

</html>