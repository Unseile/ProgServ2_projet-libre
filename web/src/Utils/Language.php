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
                "home" => "Accueil",
                "profile" => "Profil",
                "login" => "Se connecter",
                "signin" => "S'inscrire",
                "logout" => "Se déconnecter"
            ],
            "footer" => [
                "fr" => "français",
                "en" => "anglais",
                "lang-choice" => "Choisissez votre langue",
                "change" => "Changer",
                "project" => "SPEEP est un projet d'étudiant de la HEIG-VD, tous droits résérvés."
            ],
            "login" => [
                "title" => "Connexion",
                "pseudo" => "Nom d'utilisateur:",
                "password" => "Pseudo:",
                "button" => "Se connecter"
            ],
            "logout" => [
                "deconnexion" => "Déconnexion",
                "deconnexionText" => "Vous vous êtes bien déconnecté"
            ],
            "signin" => [
                "title" => "Inscription",
                "lastname" => "Nom:",
                "firstname" => "Prénom:",
                "pseudo" => "Nom d'utilisateur:",
                "password" => "Mot de passe:",
                "rePassword" => "Reconfirmer le mot de passe:",
                "mail" => "Mail:",
                "button" => "S'inscrire"
            ],
            "create_course" => [
                "title" => "Créer un cours",
                "course_title" => "Titre du cours*",
                "course_subject" => "Matière du cours*",
                "course_description" => "Description*",
                "course_price" => "Prix par étudiant (CHF)*",
                "course_place" => "Lieu du cours*",
                "course_start_datetime" => "Date et heure de début*",
                "course_duration" => "Durée du cours*",
                "course_max_students" => "Nombre maximum d'étudiants*",
                "create_button" => "Créer le cours",
                "cancel_button" => "Annuler"
            ],
            "profile" => [
                "title" => "Profil Utilisateur",
                "user_lastname" => "Nom:",
                "user_firstname" => "Prénom:",
                "user_username" => "Pseudo:",
                "user_email" => "Email:",
                "teacher" => "Professeur",
                "student" => "Étudiant"
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
                "home" => "Home",
                "profile" => "Profile",
                "login" => "Log in",
                "signin" => "Sign in",
                "logout" => "Log out"
            ],
            "footer" => [
                "fr" => "french",
                "en" => "english",
                "lang-choice" => "Choose your language",
                "change" => "Change",
                "project" => "SPEEP is a project made by students at HEIG-VD, all rights reserved."
            ],
            "login" => [
                "title" => "Login",
                "pseudo" => "Username:",
                "password" => "Password:",
                "button" => "Login"
            ],
            "logout" => [
                "deconnexion" => "Deconnexion",
                "deconnexionText" => "You are well deconnected"
            ],
            "signin" => [
                "title" => "Inscription",
                "lastname" => "Last Name:",
                "firstname" => "First Name:",
                "pseudo" => "Username:",
                "password" => "Password:",
                "rePassword" => "Confirm Password:",
                "mail" => "Email:",
                "button" => "Sign-in"
            ],
            "create_course" => [
                "title" => "Create a course",
                "course_title" => "Course Title*",
                "course_subject" => "Course Subject*",
                "course_description" => "Description*",
                "course_price" => "Price per student (CHF)*",
                "course_place" => "Course Location*",
                "course_start_datetime" => "Start Date and Time*",
                "course_duration" => "Course Duration*",
                "course_max_students" => "Maximum Number of Students*",
                "create_button" => "Create Course",
                "cancel_button" => "Cancel"
            ],
            "profile" => [
                "title" => "User Profile",
                "user_lastname" => "Last Name:",
                "user_firstname" => "First Name:",
                "user_username" => "Username:",
                "user_email" => "Email:",
                "teacher" => "Teacher",
                "student" => "Student"
            ]
        ]
    ];

    public function getContent(string $lang, string $page): ?array
    {
        return $this->content[$lang][$page];
    }

    public function setCookieLanguage(string $lang = ''): string
    {
        if (empty($lang)) {
            $lang = $this->getCookieLanguage();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['language']) {
            $lang = $_POST['language'] ?? $lang;
            setcookie('language', $lang, time() + 10);
        }
        return $lang;
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
