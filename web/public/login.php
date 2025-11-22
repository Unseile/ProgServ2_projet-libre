<?php

//Page de connexion
require_once __DIR__ . '/../src/Config/autoloader.php';

include __DIR__ . '/../src/includes/header.php';

$languageLogin = $language->getContent($lang, 'login');
?>

<h2><?= $languageLogin['title'] ?></h2>

<form action="index.php" method="POST">
    <label><?= $languageLogin['pseudo'] ?></label>
    <input type="text" name="username" required><br><br>

    <label><?= $languageLogin['password'] ?></label>
    <input type="password" name="password" required><br><br>

    <button type="submit"><?= $languageLogin['button']?></button>
</form>

</body>

</html>
<?php include __DIR__ . '/../src/includes/footer.php'; ?>