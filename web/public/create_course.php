<?php

//Page de création d'un cours
require_once __DIR__ . '/../src/Config/autoloader.php';

use Config\Database;
use Utils\Language;

$database = new Database();

$language = new Language();
$lang = $language->getCookieLanguage();
?>

<?php include __DIR__ . '/../src/includes//header.php'; ?>

<div class="container mt-5">
    <h2>Créer un nouveau cours</h2>
    
    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div>
            <label for="title">Titre du cours*</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div>
            <label for="course">Matière du cours*</label>
            <input type="text" id="course" name="course" required>
        </div>

        <div>
            <label for="description">Description*</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div>
            <label for="price">Prix par étudiant (CHF)*</label>
            <input type="number" id="price" name="price" step="0.01" required>
        </div>

        <div>
            <label for="place">Lieu du cours*</label>
            <input type="text" id="place" name="place" required>
        </div>

        <div>
            <label for="start_datetime">Date et heure de début*</label>
            <input type="datetime" id="start_date" name="start_date" required>
        </div>

        <div>
            <label for="duration">Durée du cours*</label>
            <input type="number" id="duration" name="duration" required>
        </div>

        <div>
            <label for="max_students">Nombre maximum d'étudiants*</label>
            <input type="number" id="max_students" name="max_students" min="1" required>
        </div>

        <button type="submit">Créer le cours</button>
        <a href="user_courses.php">Annuler</a>
    </form>
</div>

<?php include __DIR__ . '/../src/includes//footer.php'; ?>
