<?php

use Utils\Language;

require_once __DIR__ . '/../../src/Config/autoloader.php';

$language = new Language();
$lang = $language->setCookieLanguage();
$headerContent = $language->getContent($lang, "header");

?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <title>SPEEP</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php"><?= $headerContent["home"] ?></a></li>
                <li><a href="profile.php"><?= $headerContent["profile"] ?></a></li>
                <?php if (!empty($_SESSION['isTeacher']) && $_SESSION['isTeacher'] === true) { ?>
                    <li><a href="create_course.php"><?= $headerContent["create-course"] ?></a></li>
                <?php } ?>
                <?php if (!isset($_SESSION['username'])) { ?>
                    <li><a href="login.php"><?= $headerContent["login"] ?></a></li>
                    <li><a href="signin.php"><?= $headerContent["signin"] ?></a></li>
                <?php } else { ?>
                    <li><a href="logout.php"><?= $headerContent["logout"] ?></a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <main>