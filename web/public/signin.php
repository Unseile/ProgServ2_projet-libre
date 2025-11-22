<?php
//Page de création de compte
session_start();
set_time_limit(60); // Augmente le timeout à 60 secondes pour l'envoi d'email
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
$emailVerified = $_SESSION["emailVerified"] ?? null;

if ($username && $emailVerified) { //Si l'utilisateur est connecté et qu'il a l'email vérifié on le renvoie à l'accueil
    header('Location: /');
    exit();
}

function codeUnique(string $texte): string //fonction pour générer un nombre par rapport à l'username (avec un hash pour être difficile à deviner)
{
    $hash = crc32($texte);
    $num  = $hash % 1000000;
    return str_pad($num, 6, '0', STR_PAD_LEFT);
}

// Fonction pour envoyer l'email de vérification
function sendVerificationEmail($language, $signInContent)
{
    global $MAIL_CONFIGURATION_FILE;

    $config = parse_ini_file(MAIL_CONFIGURATION_FILE, true);

    if (!$config) {
        throw new Exception("Erreur lors de la lecture du fichier de configuration : " .
            MAIL_CONFIGURATION_FILE);
    }

    // Nettoie les valeurs en supprimant les guillemets
    $host = trim($config['host'], '\'"');
    $port = filter_var(trim($config['port'], '\'"'), FILTER_VALIDATE_INT);
    $authentication = filter_var(trim($config['authentication'], '\'"'), FILTER_VALIDATE_BOOLEAN);
    $username = trim($config['username'], '\'"');
    $password = trim($config['password'], '\'"');
    $from_email = trim($config['from_email'], '\'"');
    $from_name = trim($config['from_name'], '\'"');

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

        // Augmente les timeouts pour éviter les dépassements
        $mail->Timeout = 15;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL pour le port 465

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
        return [$signInContent["email_sucess"]];
    } catch (Exception $e) {
        return [$signInContent["email_error"] . ": {$mail->ErrorInfo}"];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && !$username) { //Si l'utilisateur n'est pas connecté et qu'il à envoyé le formulaire pour créer le comptre
    $user = new User(
        isset($_POST["lastname"]) ? $_POST["lastname"] : "",
        isset($_POST["firstname"]) ? $_POST["firstname"] : "",
        isset($_POST["username"]) ? $_POST["username"] : "",
        isset($_POST["email"]) ? $_POST["email"] : ""
    );
    $user->setClearPassword(
        isset($_POST["password"]) ? $_POST["password"] : ""
    );
    if (isset($_POST["password"]) && isset($_POST["repassword"])) {
        if ($_POST["password"] === $_POST["repassword"]) {
            $errors = $user->verify();
            if (empty($errors)) {
                try {
                    $usercontroller->addUser($user);
                    $_SESSION['user_id'] = $usercontroller->getUser($user->getUsername())->getId();
                    $_SESSION['lastname'] = $user->getLastname();
                    $_SESSION['firstname'] = $user->getFirstname();
                    $_SESSION['username'] = $user->getUsername();
                    $_SESSION['email'] = $user->getEmail();
                    $_SESSION['emailVerified'] = $user->getIsEmailVerified();
                    $_SESSION['isTeacher'] = $user->getIsTeacher();

                    // Envoyer l'email de vérification immédiatement après la création
                    $errors = sendVerificationEmail($language, $signInContent);
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
}

if ($username && !$emailVerified && !isset($_POST["send"])) { //si l'utilisateur existe et que l'email est pas vérifé et que l'utilisateur n'a pas tenté d'envoyer le code de vérification
    $errors = sendVerificationEmail($language, $signInContent);
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



?>

<h2><?= $signInContent["title"] ?></h2>
<?php if (isset($errors) && !empty($errors)) {
    foreach ($errors as $error) {
        echo '<p class=error>' . $error . '</p>';
    }
} ?>
<form action="" method="POST">
    <?php if (!isset($_SESSION['username'])) { ?>
        <label for="lastname"><?= $signInContent['lastname'] ?></label>
        <input type="text" name="lastname" value="<?= isset($user) ? $user->getLastname(true) : '' ?>" required><br><br>

        <label for="firstname"><?= $signInContent['firstname'] ?></label>
        <input type="text" name="firstname" value="<?= isset($user) ? $user->getFirstname(true) : '' ?>" required><br><br>

        <label for="username"><?= $signInContent['username'] ?></label>
        <input type="text" name="username" value="<?= isset($user) ? $user->getUsername(true) : '' ?>" required><br><br>

        <label for="password"><?= $signInContent['password'] ?></label>
        <input type="password" name="password" required><br><br>

        <label for="repassword"><?= $signInContent['rePassword'] ?></label>
        <input type="password" name="repassword" required><br><br>

        <label for="email"><?= $signInContent['mail'] ?></label>
        <input type="email" name="email" value="<?= isset($user) ? $user->getEmail(true) : '' ?>" required><br><br>

        <button type="submit"><?= $signInContent['button'] ?></button>
    <?php } else { ?>
        <label for="code"><?= $signInContent['code'] ?></label>
        <input type="text" name="code" required><br><br>
        <input type="hidden" name="send" value="true">
        <button type="submit"><?= $signInContent['send_code'] ?></button>
    <?php } ?>
</form>

<?php include __DIR__ . '/../src/includes/footer.php'; ?>