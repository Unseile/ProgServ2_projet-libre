<?php

//Page de connexion
require_once __DIR__ . '/../src/Config/autoloader.php';
use Includes\Header, Includes\Footer;
?>
<?= Header::content(); ?>
<?= Footer::content(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>

<h2>Connexion</h2>

<form action="managerLogin.php" method="POST">
    <label>Nom:</label>
    <input type="text" name="lastName" required><br><br>
    
    <label>Prénom:</label>
    <input type="text" name="firstName" required><br><br>
    
    <label>Nom d'utilisateur:</label>
    <input type="text" name="username" required><br><br>

    <label>Mot de passe:</label>
    <input type="password" name="password" required><br><br>

    <label>Mail:</label>
    <input type="email" name="email" required><br><br>

    <input type="submit" value="Se connecter">
</form>

</body>
</html>