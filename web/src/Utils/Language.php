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
                "description" => "Où chaque élève peut être à la fois enseignant et apprenant, en donnant ou recevant du soutien dans les matières de son choix. Simple, collaboratif et efficace, SPEEP transforme l’entraide entre élèves en véritable force de réussite.",
                "available-courses" => "Tous les cours disponibles",
                "subject" => "sujet",
                "teacher" => "enseignant",
                "subscriptions" => "inscriptions",
                "on" => "le",
                "at" => "à",
                "hour" => "heure"
            ],
            "course" => [
                "back" => "retour",
                "subject" => "sujet",
                "teacher" => "enseignant",
                "subscriptions" => "inscriptions",
                "on" => "le",
                "at" => "à",
                "hour" => "heure",
                // "starts" => "commence",
                // "ends" => "fini",
                "course-description" => "description du cours",
                "duration" => "durée",
                "in-room" => "en salle",
                "price" => "prix",
                "login" => "se connecter",
                "subscribe" => "s'inscrire",
                "unsubscribe" => "se désinscrire",
                "your_are_teaching" => "Vous ne pouvez pas vous inscrire a votre propre cours"
            ],
            "subscriptions" => [
                "user-courses" => "Vos précédents cours suivis",
                "subject" => "sujet",
                "teacher" => "enseignant",
                "subscriptions" => "inscriptions",
                "on" => "le",
                "at" => "à",
                "hour" => "heure",
                "course" => "Voir le cours",
                "connexion_err" => "Erreur lors de la connexion à la base de donnée",
                "fetch_err" => "Erreur lors de la récupération de vos cours",
                "no_course" => "Vous n'avez pas encore pris de cours",
                "no_course_given" => "Vous ne donnez pas de cours pour le moment",
                "history-title" => "Vos cours suivis",
                "history-title-teacher" => "Vos cours donnés"
            ],
            "header" => [
                "home" => "Accueil",
                "profile" => "Profil",
                "create-course" => "Créer un cours",
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
                "username" => "Nom d'utilisateur",
                "password" => "Mot de passe",
                "button" => "Se connecter"
            ],
            "logout" => [
                "deconnexion" => "Déconnexion",
                "deconnexionText" => "Vous vous êtes bien déconnecté."
            ],
            "signin" => [
                "title" => "Inscription",
                "lastname" => "Nom",
                "firstname" => "Prénom",
                "username" => "Nom d'utilisateur",
                "password" => "Mot de passe",
                "rePassword" => "Reconfirmer le mot de passe",
                "mail" => "Mail",
                "button" => "S'inscrire",
                "err_password" => "Soyez sûr de taper le bon mot de passe dans les deux champs.",
                "err_exist_user" => "Le nom d'utilisateur est déjà pris.",
                "err_add_user" => "Erreur lors de l'ajout de l'utilisateur.",
                "err_unexpected" => "Erreur inatendue.",
                "email_error" => "Email pas envoyé",
                "email_sucess" => "Email envoyé avec succès",
                "email_subject" => "Verifiez votre adresse email",
                "email_content" => "Bienvenue sur SPEEP ! Votre compte à été créé avec succès. Merci de saisir le code ci-dessous pour valider votre adresse email.",
                "send_code" => "Vérifier",
                "code" => "Votre code reçu par email",
                "invalide_code" => "Code invalide",
                "valide_code" => "Succès, votre email est maintenant vérifié",
                "return_home" => "Retourner à l'accueil",
                "is_teacher" => "Je m'inscris en tant qu'enseignant",
                "email_err" => "Erreur lors de l'envoie de l'emails"
            ],
            "create_course" => [
                "title" => "Créer un cours",
                "course_title" => "Titre du cours*",
                "course_subject" => "Matière du cours*",
                "course_description" => "Description*",
                "course_price" => "Prix par étudiant (max CHF30.00)*",
                "course_place" => "Lieu du cours*",
                "course_start_datetime" => "Date et heure de début*",
                "course_duration" => "Durée du cours (entre 15 et 300 minutes)*",
                "course_max_students" => "Nombre maximum d'étudiants (entre 1 et 30) *",
                "create_button" => "Créer le cours",
                "cancel_button" => "Annuler",
                "error_title" => "Le titre est requis",
                "error_subject" => "La matière est requise",
                "error_date" => "La date de début est requise",
                "error_duration" => "La durée doit être d'au moins 15 minutes",
                "error_location" => "Le lieu est requis",
                "error_price" => "Le prix doit être un nombre valide (0 pour gratuit)",
                "error_max_students" => "Le nombre d'étudiants doit être entre 1 et 30",
                "error_unexpected" => "Une erreur inattendue s'est produite",
                "success_message" => "Cours créé avec succès !",
                "select_subject" => "Choisir une matière"
            ],
            "profile" => [
                "title" => "Profil Utilisateur",
                "user_lastname" => "Nom:",
                "user_firstname" => "Prénom:",
                "user_username" => "Pseudo:",
                "user_email" => "Email:",
                "user_role" => "Rôle",
                "teacher" => "Professeur",
                "student" => "Étudiant",
                "user_email_verified" => " est vérifié.",
                "user_email_not_verified" => " n'est pas vérifié.",
                "subscriptions" => "Mes inscriptions",
                "verify_email" => "Vérifier mon email"
            ],
            "common_errors" => [
                "connecting_db" => "Erreur de connexion à la base de donnée",
                "fetch_data" => "Erreur lors de la récupération des données",
                "adding_data" => "Erreur lors de l'ajout de données",
                "updating_data" => "Erreur lors de la mise à jour des données",
                "subscribe_own_course" => "Vous ne pouvez pas vous inscrire à votre propre cours",
                "unsubscribe_own_course" => "impossible de se désinscrire, vous êtes l'enseignant"
            ]
        ],
        "en" => [
            "index" => [
                "welcome" => "Welcome to SPEEP.CH, your go-to platform for tutoring courses!",
                "description" => "Where every student can be both a teacher and a learner, giving or receiving support in the subjects of their choice. Simple, collaborative, and effective, SPEEP transforms peer assistance into a true force for success.",
                "available-courses" => "All available courses",
                "subject" => "subject",
                "teacher" => "teacher",
                "subscriptions" => "subscriptions",
                "on" => "on",
                "at" => "at",
                "hour" => "hour"
            ],
            "course" => [
                "back" => "back",
                "subject" => "subject",
                "teacher" => "teacher",
                "subscriptions" => "subscriptions",
                "on" => "on",
                "at" => "at",
                "hour" => "hour",
                // "starts" => "starts",
                // "ends" => "ends",
                "course-description" => "course description",
                "duration" => "duration",
                "in-room" => "in room",
                "price" => "price",
                "login" => "log in",
                "subscribe" => "subscribe",
                "unsubscribe" => "unsubscribe",
                "your_are_teaching" => "Your can't subscribe to your own course"
            ],
            "subscriptions" => [
                "user-courses" => "Your previous enrolled courses",
                "subject" => "subject",
                "teacher" => "teacher",
                "subscriptions" => "subscriptions",
                "on" => "on",
                "at" => "at",
                "hour" => "hour",
                "course" => "View course",
                "connexion_err" => "Error when connecting to databasse",
                "fetch_err" => "Error when trying to fetch courses",
                "no_course" => "You don't have course",
                "no_course_given" => "You didn't created course",
                "history-title" => "Your following courses",
                "history-title-teacher" => "Your teaching courses"
            ],
            "header" => [
                "home" => "Home",
                "profile" => "Profile",
                "create-course" => "Create course",
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
                "username" => "Username",
                "password" => "Password",
                "button" => "Login"
            ],
            "logout" => [
                "deconnexion" => "Deconnexion",
                "deconnexionText" => "You are well deconnected"
            ],
            "signin" => [
                "title" => "Inscription",
                "lastname" => "Last Name",
                "firstname" => "First Name",
                "username" => "Username",
                "password" => "Password",
                "rePassword" => "Confirm Password:",
                "mail" => "Email",
                "button" => "Sign in",
                "err_password" => "Be sure to type the correct password in the two fields.",
                "err_exist_user" => "The username is taken.",
                "err_add_user" => "Error when adding new user.",
                "err_unexpected" => "Unexpected error.",
                "email_error" => "Email not sent",
                "email_sucess" => "Email sent",
                "email_subject" => "Verify your email address",
                "email_content" => "Welcome to SPEEP ! Your account was successfuly created. Please, enter the code bellow to validate your email address.",
                "send_code" => "Check",
                "code" => "Your code received on your email",
                "invalide_code" => "Invalide code",
                "valide_code" => "Success, your email is now verified",
                "return_home" => "Return to home",
                "is_teacher" => "I register as teacher",
                "email_err" => "error when trying to send the email"

            ],
            "create_course" => [
                "title" => "Create a course",
                "course_title" => "Course Title*",
                "course_subject" => "Course Subject*",
                "course_description" => "Description*",
                "course_price" => "Price per student (max CHF30.00)*",
                "course_place" => "Course Location*",
                "course_start_datetime" => "Start Date and Time*",
                "course_duration" => "Course Duration (between 15 and 300 minutes)*",
                "course_max_students" => "Maximum Number of Students* (between 1 and 30)",
                "create_button" => "Create Course",
                "cancel_button" => "Cancel",
                "error_title" => "Title is required",
                "error_subject" => "Subject is required",
                "error_date" => "Start date is required",
                "error_duration" => "Duration must be at least 15 minutes",
                "error_location" => "Location is required",
                "error_price" => "Price must be a valid number (0 for free)",
                "error_max_students" => "Number of students must be between 1 and 30",
                "error_unexpected" => "An unexpected error occurred",
                "success_message" => "Course created successfully!",
                "select_subject" => "Choose a subject"
            ],
            "profile" => [
                "title" => "User Profile",
                "user_lastname" => "Last Name",
                "user_firstname" => "First Name",
                "user_username" => "Username",
                "user_email" => "Email",
                "user_role" => "Role",
                "teacher" => "Teacher",
                "student" => "Student",
                "user_email_verified" => " is verified.",
                "user_email_not_verified" => " is not verified.",
                "subscriptions" => "My subscriptions",
                "verify_email" => "Verify my email"
            ],
            "common_errors" => [
                "connecting_db" => "Error when connecting to db",
                "fetch_data" => "Error when trying to fetch data",
                "adding_data" => "Error when adding data",
                "updating_data" => "Error when updating data"
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language'])) {
            $lang = $_POST['language'] ?? $lang;
            setcookie('language', $lang, time() + 3600);
        }
        return $lang;
    }

    public function getCookieLanguage(): ?string
    {
        if (isset($_COOKIE["language"]) && ($_COOKIE['language'] === "fr" || $_COOKIE['language'] === "en")) {
            return $_COOKIE['language'];
        }
        return "fr";
    }

    public function getAvailableLanguages(): array
    {
        return array_keys($this->content);
    }
}
