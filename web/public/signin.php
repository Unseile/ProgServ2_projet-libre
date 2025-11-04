<?php

//Page de création de compte
require_once __DIR__ . '/../src/Config/autoloader.php';

include __DIR__ . '/../src/includes/header.php';
include __DIR__ . '/../src/includes//footer.php';

?>

<<h2><?= $languageSignin = $language->getContent($lang, 'signin')['title'] ?></h2>

<form action="managerLogin.php" method="POST">
    <label><?= $languageSignin['lastname'] ?></label>
    <input type="text" name="lastName" required><br><br>
    
    <label><?= $languageSignin['firstname'] ?></label>
    <input type="text" name="firstName" required><br><br>
    
    <label><?= $languageSignin['pseudo'] ?></label>
    <input type="text" name="username" required><br><br>

    <label><?= $languageSignin['password'] ?></label>
    <input type="password" name="password" required><br><br>

    <label><?= $languageSignin['rePassword'] ?></label>
    <input type="password" name="password" required><br><br>

    <label><?= $languageSignin['mail'] ?></label>
    <input type="email" name="email" required><br><br>

    <button type="submit"><?= $languageSignin['button']?></button>
</form>

</body>
</html>
