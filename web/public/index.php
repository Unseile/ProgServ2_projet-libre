<?php
include __DIR__ . '/../src/includes/header.php';

//Page d'accueil / liste de tous les cours
require_once __DIR__ . '/../src/Config/autoloader.php';

use Config\Database;

$database = new Database();
$homeContent = $language->getContent($lang, 'index');
?>

<h2><?= $homeContent["welcome"] ?></h2>
<div>
    <h3><?= $homeContent["available-courses"] ?></h3>
    <a href="" class="coursebox">
        <h2 class="title">Cours d'appui en vue du 2eme examen</h2>
        <p class="shortdescr">Cours d'appui en mathématiques pour préparer le 2eme examen de mathématiques de l'année académique 2025-2026.</p>
        <div class="attributes">
            <p class="teacher"><?= $homeContent["teacher"] ?>: Laurent Boli</p>
            <p class="subject"><?= $homeContent["subject"] ?>: BaseMath2</p>
            <p class="startdatetime"><?= $homeContent["on"] ?>: 12 déc <?= $homeContent["at"] ?> 15 <?= $homeContent["hour"] ?> </p>
            <p class="subscriptions"><?= $homeContent["subscriptions"] ?>: 7</p>

        </div>
    </a>
</div>
<?php include __DIR__ . '/../src/includes/footer.php'; ?>