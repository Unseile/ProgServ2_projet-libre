<?php

//Page d'accueil / liste de tous les cours
require_once __DIR__ . '/../src/Config/autoloader.php';

use Includes\Header, Includes\Footer, Utils\Language;

$language = new Language();
?>
<?= Header::content(); ?>
<h2><?= $language->getContent('fr', 'home') ?></h2>

<a href="" class="coursebox">
    <h2 class="title">Cours d'appui en vue du 2eme examen</h2>
    <p class="shortdescr">Cours d'appui en mathématiques pour préparer le 2eme examen de mathématiques de l'année académique 2025-2026.</p>
    <div class="attributes">
        <p class="price">Prix: 25 CHF</p>
        <p class="subject">Sujet: BaseMath2</p>
        <p class="startdatetime">Début: 12 déc à 15:00</p>
        <p class="enddatetime">Fin: 12 déc à 17:00</p>
        <p class="duration">Durée: 2h</p>
    </div>
</a>
<?= Footer::content(); ?>