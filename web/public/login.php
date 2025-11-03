<?php

//Page de connexion
require_once __DIR__ . '/../src/Config/autoloader.php';

include __DIR__ . '/../src/includes//footer.php';
include __DIR__ . '/../src/includes//header.php'; 

use Config\Database;
use Utils\Language;

$language = new Language();
$lang = $language->getCookieLanguage();
?>

<h2><?= $language->getContent($lang, 'login')['title'] ?></h2>

<form action="managerLogin.php" method="POST">
    <label><?= $language->getContent($lang, 'login')['pseudo'] ?></label>
    <input type="text" name="username" required><br><br>

    <label><?= $language->getContent($lang, 'login')['password'] ?></label>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="connexion">
</form>

</body>
</html>
<?php include __DIR__ . '/../src/includes//footer.php'; ?>
<?php include __DIR__ . '/../src/includes//header.php'; ?>
