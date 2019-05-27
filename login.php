<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=gibb_183', 'root', '');

if (isset($_GET['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $passwort = htmlspecialchars($_POST['passwort']);

    $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
        $_SESSION['user'] = $user;
        header('Location: ./secret.php');
        die('Login erfolgreich. Weiter zu <a href="secret.php">internen Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>



<div class='login'>
    <div class='login_title'>
        <span>Login to your account</span>
        <br>
        <span style="font-size: 12px">

            <?php
            if (isset($errorMessage)) {
                echo $errorMessage;
            }
            ?>

        </span>
    </div>

    <form action="?login=1" method="post">
        <div class='login_fields'>
            <div class='login_fields__user'>
                <div class='icon'>
                    <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/user_icon_copy.png'>
                </div>
                <input placeholder='Email' type='text' name="email">
            </div>
            <div class='login_fields__password'>
                <div class='icon'>
                    <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/lock_icon_copy.png'>
                </div>
                <input placeholder='Password' type='password' name="passwort">
            </div>
            <div class='login_fields__submit'>
                <input type='submit' value='Log In'>
                <div class='forgot'>
                    <a href='register.php'>register</a>
                </div>
            </div>
        </div>
    </form>

    <div class='success'>
        <h2>Authentication Success</h2>
        <p>Welcome back</p>
    </div>
    <div class='disclaimer'>
        <p>Florian Moser het ds nid kopiert</p>
    </div>
</div>
</body>
</html>



