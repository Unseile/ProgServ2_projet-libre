<?php
//Page du profil utilisateur
require_once __DIR__ . '/../src/Config/autoloader.php';

include __DIR__ . '/../src/includes//header.php';

$profileContent = $language->getContent($lang, 'profile');

$user = $userController->getUserById($_SESSION['user']['id']);
?>

<body>
    <h2 class="title"><?= $profileContent["title"]?></h2>

    <?php if ($message): ?>
        <div><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="user_informations">
        <div class="user_lastname">
            <strong><?= $profileContent["user_information"]?></strong>
            <?= htmlspecialchars($user['lastname']) ?>
        </div>

        <div class="user_firstname">
            <strong><?= $profileContent["user_firstname"]?></strong>
            <?= htmlspecialchars($user['firstname']) ?>
        </div>

        <div class="user_username">
            <strong><?= $profileContent["user_username"]?></strong>
            <?= htmlspecialchars($user['username']) ?>
        </div>

        <div class="user_email">
            <strong><?= $profileContent["user_email"]?></strong>
            <?= htmlspecialchars($user['email']) ?>
        </div>

        <div class="user_role">
            <strong>Rôle:</strong>
            <?= htmlspecialchars($user['is_teacher'] ? $profileContent["teacher"] : $profileContent["student"]) ?>
        </div>
    </div>
</body>



<?php include __DIR__ . '/../src/includes/footer.php'; ?>