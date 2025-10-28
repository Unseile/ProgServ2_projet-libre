<?php
require_once __DIR__ . '/../src/Config/autoloader.php';

use Includes\Header, Includes\Footer, Utils\Language;

$language = new Language();
$languages = $language->getAvailableLanguages();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language'])) {
    if (in_array($_POST['language'], ['fr', 'en'])) {
        $language->setCookieLanguage($_POST['language']);
        header("Location: /");
        exit();
    }
}

?>
<?= Header::content(); ?>
<div class="language-switcher">
    <?php foreach ($languages as $lang) { ?>
        <form action="" method="post">
            <input type="hidden" name="language" value="<?= $lang ?>">
            <button type="submit"><?= $lang ?></button>
        </form>

    <?php } ?>
</div>
<?= Footer::content(); ?>