<?php

//Implémentations des variables de langue
namespace Utils;

require_once __DIR__ . '/../Config/autoloader.php';

class Language
{
    private array $content = [
        "fr" => [
            "index" => [
                "welcome" => "Bienvenue sur SPEEP.CH, ta référence pour tes cours d'appui !",
                "available-courses" => "Tous les cours disponibles",
                "subject" => "sujet",
                "teacher" => "enseignant",
                "subscriptions" => "inscriptions",
                "on" => "le",
                "at" => "à",
                "hour" => "heure"
            ],
            "course" => [
                "subject" => "sujet",
                "teacher" => "enseignant",
                "subscriptions" => "inscriptions",
                "on" => "le",
                "at" => "à",
                "hour" => "heure",
                "starts" => "commence",
                "ends" => "fini",
                "course-description" => "description du cours",
                "duration" => "durée",
                "in-room" => "en salle",
                "price" => "prix",
                "login" => "se connecter",
                "subscribe" => "s'inscrire"
            ],
            "subscriptions" => [
                "user-courses" => "Vos précédents cours suivis",
                "subject" => "sujet",
                "teacher" => "enseignant",
                "subscriptions" => "inscriptions",
                "on" => "le",
                "at" => "à",
                "hour" => "heure"
            ],
            "header" => [
                "home" => "Accueil"
            ],
            "login" => [
                "title" => "Connexion",
                "pseudo" => "Nom d'utilisateur:",
                "password" => "Pseudo:"
            ],
            "logout" => [
                "deconnexion" => "Déconnexion",
            ],
            "signin" => [
                "title" => "S'inscrire",
                "lastname" => "Nom:",
                "firstname" => "Prénom:",
                "pseudo" => "Nom d'utilisateur:",
                "password" => "Mot de passe:",
                "rePassword" => "Reconfirmer le mot de passe:",
                "mail" => "Mail:",
            ]
        ],
        "en" => [
            "index" => [
                "welcome" => "Welcome to SPEEP.CH, your go-to platform for tutoring courses!",
                "available-courses" => "All available courses",
                "subject" => "subject",
                "teacher" => "teacher",
                "subscriptions" => "subscriptions",
                "on" => "on",
                "at" => "at",
                "hour" => "hour"
            ],
            "course" => [
                "subject" => "subject",
                "teacher" => "teacher",
                "subscriptions" => "subscriptions",
                "on" => "on",
                "at" => "at",
                "hour" => "hour",
                "starts" => "starts",
                "ends" => "ends",
                "course-description" => "course description",
                "duration" => "duration",
                "in-room" => "in room",
                "price" => "price",
                "login" => "log in",
                "subscribe" => "subscribe"
            ],
            "subscriptions" => [
                "user-courses" => "Your previous enrolled courses",
                "subject" => "subject",
                "teacher" => "teacher",
                "subscriptions" => "subscriptions",
                "on" => "on",
                "at" => "at",
                "hour" => "hour"
            ],
            "header" => [
                "home" => "Home"
            ],
            "login" => [
                "title" => "Login",
                "pseudo" => "Username:",
                "password" => "Password:"
            ],
            "logout" => [
                "deconnexion" => "Deconnexion",
            ],
            "signin" => [
                "title" => "Log out",
                "lastname" => "Last Name:",
                "firstname" => "First Name:",
                "pseudo" => "Username:",
                "password" => "Password:",
                "rePassword" => "Confirm Password:",
                "mail" => "Email:",
            ]
        ]
    ];

    public function getContent(string $lang, string $page): ?array
    {
        return $this->content[$lang][$page];
    }

    public function setCookieLanguage(string $lang): void
    {
        setcookie('language', $lang, time() + (86400 * 30));
    }

    public function getCookieLanguage(): ?string
    {
        return $_COOKIE['language'] ?? 'fr';
    }

    public function getAvailableLanguages(): array
    {
        return array_keys($this->content);
    }
}
