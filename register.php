<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=gibb_183', 'root', '');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

if(isset($_GET['register'])) {
    $error = false;
    $email = htmlspecialchars($_POST['email']);
    $passwort = htmlspecialchars($_POST['passwort']);
    $passwort2 = htmlspecialchars($_POST['passwort2']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        $statement = $db->prepare("INSERT INTO users (email, passwort) VALUES (:email, :passwort)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));

        if($result) {
//            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            header('Location: ./login.php');
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

if($showFormular) {
    ?>

<div class='login'>
    <div class='login_title'>
        <span>Register new account</span>
        <br>
    </div>

    <form action="?register=1" method="post">
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
                <input placeholder='your password' type='password' name="passwort">
            </div>
            <div class='login_fields__password'>
                <div class='icon'>
                    <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/lock_icon_copy.png'>
                </div>
                <input placeholder='repeat password' type='password' name="passwort2">
            </div>
            <div class='login_fields__submit'>
                <input type='submit' value='register'>
                <div class='forgot'>
                    <a href='login.php'>login</a>
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



    <?php
} //Ende von if($showFormular)
?>

</body>
</html>
