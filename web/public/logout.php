<?php
session_start();
session_destroy();


//Page de déconnexion
require_once __DIR__ . '/../src/Config/autoloader.php';
include __DIR__ . '/../src/includes/header.php';

$languageLogout = $language->getContent($lang, 'logout')
?>

<form action="index.php" method="POST">
    <h2><?= $languageLogout['deconnexion'] ?></h2>
    <p><?= $languageLogout['deconnexionText'] ?></p>
    <button type="submit">Ok</button>
</form>

<?php include __DIR__ . '/../src/includes/footer.php';?>
