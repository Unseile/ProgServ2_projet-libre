<?php
session_start();

// Vérifie si l'utilisateur est authentifié
$username = $_SESSION['username'] ?? null;

// L'utilisateur n'est pas authentifié
if (!$username) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    header('Location: login.php');
    exit();
}

// Sinon, récupère les autres informations de l'utilisateur
$lastname = $_SESSION['lastname'];
$firstname = $_SESSION['firstname'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$emailVerified = $_SESSION['emailVerified'];
$isTeacher = $_SESSION['isTeacher'];

//Page du profil utilisateur
require_once __DIR__ . '/../src/Config/autoloader.php';

include __DIR__ . '/../src/Includes/header.php';

$profileContent = $language->getContent($lang, 'profile');
?>

<body>
    <h2 class="title"><?= $profileContent["title"]?></h2>

    <div class="user_informations">
        <div class="user_lastname">
            <strong><?= $profileContent["user_lastname"]?></strong>
            <?= htmlspecialchars($lastname) ?>
        </div>

        <div class="user_firstname">
            <strong><?= $profileContent["user_firstname"]?></strong>
            <?= htmlspecialchars($firstname) ?>
        </div>

        <div class="user_username">
            <strong><?= $profileContent["user_username"]?></strong>
            <?= htmlspecialchars($username) ?>
        </div>

        <div class="user_email">
            <strong><?= $profileContent["user_email"]?></strong>
            <?= htmlspecialchars($emailVerified ? $email . $profileContent["user_email_verified"] : $email . $profileContent["user_email_not_verified"]) ?>
            <?php if (!$emailVerified): ?>
                <a href="signin.php"><?= $profileContent["verify_email"] ?></a>
            <?php endif; ?>
        </div>

        <div class="user_role">
            <strong><?= $profileContent["user_role"]?></strong>
            <?= htmlspecialchars($isTeacher ? $profileContent["teacher"] : $profileContent["student"]) ?>
        </div>
        <div>
            <a href="subscriptions.php"><?= $profileContent["subscriptions"] ?></a>
        </div>
    </div>
</body>



<?php include __DIR__ . '/../src/Includes/footer.php'; ?>