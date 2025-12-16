<?php
session_start();
session_destroy();
$_SESSION = [];

//Page de déconnexion
require_once __DIR__ . '/../src/Config/autoloader.php';
header('Location: login.php');
exit();
?>
