<?php

//Page de déconnexion
require_once __DIR__ . '/../src/Config/autoloader.php';
?>
<?php include __DIR__ . '/../src/includes//footer.php'; ?>
<?php include __DIR__ . '/../src/includes//header.php'; ?>

<form action="logout.php" method="POST">
    <button type="submit">Déconnexion</button>
</form>