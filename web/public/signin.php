<?php

//Page de création de compte
require_once __DIR__ . '/../src/Config/autoloader.php';

include __DIR__ . '/../src/includes/header.php';
include __DIR__ . '/../src/includes//footer.php';

?>

<<h2><?= $language->getContent($lang, 'signin')['title'] ?></h2>

<form action="managerLogin.php" method="POST">
    <label><?= $language->getContent($lang, 'signin')['lastname'] ?></label>
    <input type="text" name="lastName" required><br><br>
    
    <label><?= $language->getContent($lang, 'signin')['firstname'] ?></label>
    <input type="text" name="firstName" required><br><br>
    
    <label><?= $language->getContent($lang, 'signin')['pseudo'] ?></label>
    <input type="text" name="username" required><br><br>

    <label><?= $language->getContent($lang, 'signin')['password'] ?></label>
    <input type="password" name="password" required><br><br>

    <label><?= $language->getContent($lang, 'signin')['rePassword'] ?></label>
    <input type="password" name="password" required><br><br>

    <label><?= $language->getContent($lang, 'signin')['mail'] ?></label>
    <input type="email" name="email" required><br><br>

    <input type="submit" value="inscription">
</form>

</body>
</html>
