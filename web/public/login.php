<?php

//Page de connexion
session_start();
require_once __DIR__ . '/../src/Config/autoloader.php';
include __DIR__ . '/../src/includes/header.php';

use Controllers\UsersController;

$languageLogin = $language->getContent($lang, 'login');
$loginError = null;

// Handle login POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';

    $userController = new UsersController();
    $user = $userController->getUser($username);
    
    if ($user && !empty($user->getUsername()) && password_verify($password, $user->getPasswordHash())) {
        // Authentication successful
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['lastname'] = $user->getLastname();
        $_SESSION['firstname'] = $user->getFirstname();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['emailVerified'] = $user->getIsEmailVerified();
        $_SESSION['isTeacher'] = $user->getIsTeacher();

        header('Location: profile.php');
        exit();
    } else {
        $loginError = $languageLogin['error_invalid'] ?? 'Invalid username or password';
    }
}
?>

<h2><?= $languageLogin['title'] ?></h2>

<?php if ($loginError) {
    echo '<p class="error">' . htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8') . '</p>';
} ?>

<form action="login.php" method="POST">
    <label><?= $languageLogin['username'] ?></label>
    <input type="text" name="username" required><br><br>

    <label><?= $languageLogin['password'] ?></label>
    <input type="password" name="password" required><br><br>

    <button type="submit"><?= $languageLogin['button'] ?></button>
</form>

</body>

</html>
<?php include __DIR__ . '/../src/includes/footer.php'; ?>