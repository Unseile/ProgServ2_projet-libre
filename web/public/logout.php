<?php

session_destroy();


//Page de déconnexion
require_once __DIR__ . '/../src/Config/autoloader.php';
?>
<?php include __DIR__ . '/../src/includes/footer.php'; ?>
<?php include __DIR__ . '/../src/includes/header.php'; ?>

<form action="index.php" method="POST">
    <h2><? $languageLogout = $language->getContent($lang, 'logout')['deconnexion'] ?></h2>
    <p><? $languageLogout['deconnexionText'] ?></p>
    <button type="submit">Ok</button>
</form>