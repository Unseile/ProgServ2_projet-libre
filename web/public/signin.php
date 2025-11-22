<?php
function codeUnique(string $texte): string //fonction pour générer un nombre par rapport à l'username (avec un hash pour être difficile à deviner)
{
    $hash = crc32($texte);
    $num  = $hash % 1000000;
    return str_pad($num, 6, '0', STR_PAD_LEFT);
}

//Page de création de compte
session_start();
require_once __DIR__ . '/../src/Config/autoloader.php';
include __DIR__ . '/../src/includes/header.php';

use Controllers\UsersController;
use Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

const MAIL_CONFIGURATION_FILE = __DIR__ . '/../src/Utils/PHPMailer/mail.ini';
$signInContent = $language->getContent($lang, 'signin');
$usercontroller = new UsersController();
$username = $_SESSION['username'] ?? null;
$emailVerified = $_SESSION["emailVerified"];

if ($username && $emailVerified) { //Si l'utilisateur est connecté et qu'il a l'email vérifié on le renvoie à l'accueil
    header('Location: /');
    exit();
}

if ($username && !$emailVerified && !isset($_POST["send"])) { //si l'utilisateur existe et que l'email est pas vérifé et que l'utilisateur n'a pas tenté d'envoyer le code de vérification
    $config = parse_ini_file(MAIL_CONFIGURATION_FILE, true);

    if (!$config) {
        throw new Exception("Erreur lors de la lecture du fichier de configuration : " .
            MAIL_CONFIGURATION_FILE);
    }

    $host = $config['host'];
    $port = filter_var($config['port'], FILTER_VALIDATE_INT);
    $authentication = filter_var($config['authentication'], FILTER_VALIDATE_BOOLEAN);
    $username = $config['username'];
    $password = $config['password'];
    $from_email = $config['from_email'];
    $from_name = $config['from_name'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->Port = $port;
        $mail->SMTPAuth = $authentication;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";

        // Expéditeur et destinataire
        $mail->setFrom($from_email, $from_name);
        $mail->addAddress($_SESSION["email"], $_SESSION["firstname"] . $_SESSION["lastname"]);

        // Contenu du mail
        $mail->isHTML(true);
        $mail->Subject = $signInContent["email_subject"];

        $uniqueCode = codeUnique($_SESSION["username"]);
        $mail->Body    = $signInContent['email_content'] .  " : <b>$uniqueCode</b>";
        $mail->AltBody = $signInContent['email_content'] . " : $uniqueCode";

        $mail->send();

        $errors = [$signInContent["email_sucess"]];
    } catch (Exception $e) {
        $errors = [$signInContent["email_error"] . ": {$mail->ErrorInfo}"];
    }
}

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && $username
    && !$emailVerified
    && isset($_POST["send"])
    && $_POST["send"] === "true"
) // SI l'utilisateur a envoyé le code de vérification et qu'il n'a pas encore l'email vérifié
{
    if (isset($_POST["code"]) && $_POST["code"] === codeUnique($_SESSION["username"])) {
        $usercontroller->setEmailValidate($username);
    } else {
        $errors = ["INVALIDE CODE"];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && !$username) { //Si l'utilisateur n'est pas connecté et qu'il à envoyé le formulaire pour créer le comptre
    if (isset($_POST["password"]) && isset($_POST["repassword"]) && $_POST["password"] === $_POST["repassword"]) {
        $user = new User(
            $_POST["lastname"] ?? "",
            $_POST["firstname"] ?? "",
            $_POST["username"] ?? "",
            $_POST["email"] ?? ""
        );
        $user->setClearPassword(
            $_POST["password"] ?? ""
        );
        $errors = $user->verify();
        if (empty($errors)) {
            try {
                $usercontroller->addUser($user);
                $_SESSION['user_id'] = $usercontroller->getUser($user->getUsername())["id"];
                $_SESSION['lastname'] = $user->getLastname();
                $_SESSION['firstname'] = $user->getFirstname();
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['emailVerified'] = $user->getIsEmailVerified();
                $_SESSION['isTeacher'] = $user->getIsTeacher();
            } catch (PDOException $e) {
                if ($e->getCode() === "23000") {
                    $errors[] = $signInContent["err_exist_user"];
                } else {
                    $errors[] = $signInContent["err_add_user"];
                }
            } catch (Exception $e) {
                $errors[] = $signInContent["err_unexpected"];
            }
        }
    } else {
        $errors = [$signInContent["err_password"]];
    }
}

?>

<h2><?= $signInContent["title"] ?></h2>
<?php if (isset($errors) && !empty($errors)) {
    foreach ($errors as $error) {
        echo '<p class=error>' . $error . '</p>';
    }
} ?>
<form action="" method="POST">
    <?php if (!$username) { ?>
        <label for="lastname"><?= $signInContent['lastname'] ?></label>
        <input type="text" name="lastname" required><br><br>

        <label for="firstname"><?= $signInContent['firstname'] ?></label>
        <input type="text" name="firstname" required><br><br>

        <label for="username"><?= $signInContent['username'] ?></label>
        <input type="text" name="username" required><br><br>

        <label for="password"><?= $signInContent['password'] ?></label>
        <input type="password" name="password" required><br><br>

        <label for="repassword"><?= $signInContent['rePassword'] ?></label>
        <input type="password" name="repassword" required><br><br>

        <label for="email"><?= $signInContent['mail'] ?></label>
        <input type="email" name="email" required><br><br>

        <button type="submit"><?= $signInContent['button'] ?></button>
    <?php } else { ?>
        <label for="code"><?= $signInContent['code'] ?></label>
        <input type="text" name="code" required><br><br>
        <input type="hidden" name="send" value="true">
        <button type="submit"><?= $signInContent['send_code'] ?></button>
    <?php } ?>
</form>

<?php include __DIR__ . '/../src/includes/footer.php'; ?>