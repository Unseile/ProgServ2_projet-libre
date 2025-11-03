<?php

require_once __DIR__ . '/../../src/Config/autoloader.php';

$availableLangs = $language->getAvailableLanguages();
$footerContent = $language->getContent($lang, "footer");

?>
</main>

<footer>
    <p>&copy; <?= date('Y') . " " . $footerContent["project"] ?></p>
    <form method="post" action="">
        <label for="language"><?= $footerContent["lang-choice"] ?></label>
        <select name="language" id="language">
            <?php foreach ($availableLangs as $availableLang) { ?>
                <option value="<?= $availableLang ?>" <?= $lang === $availableLang ? ' selected' : '' ?>><?= $footerContent[$availableLang] ?></option>
            <?php } ?>
        </select>
        <button type="submit"><?= htmlspecialchars($footerContent["change"]) ?></button>
    </form>
</footer>

</body>

</html>