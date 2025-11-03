<?php

use Utils\Language;

require_once __DIR__ . '/../../src/Config/autoloader.php';

$language = new Language();
$lang = $language->setCookieLanguage();
$headerContent = $language->getContent($lang, "header");

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>SPEEP</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <header>
        <nav>
            <ul>
                <li><a href="index.php"><?= $headerContent["home"] ?></a></li>
                <li><a href="profile.php"><?= $headerContent["profile"] ?></a></li>
                <li><a href="logout.php"><?= $headerContent["signin"] ?></a></li>
            </ul>
        </nav>
    </header>

    <main>