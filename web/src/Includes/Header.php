<?php

namespace Includes;

require_once __DIR__ . '/../../src/Config/autoloader.php';

class Header
{
    public static function content(): string
    {
        return `
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>SPEEP</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>`;
    }
}
