<?php
session_start();
if (!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
$useremail = $_SESSION['user']['email'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>secret</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class='login' style="height: 380px; width: 560px">

    <div class='login_title'>
        <span><?php echo "Hallo: " . $useremail;?></span>
        <span>
            <div class='login_fields__submit' style="top: -110px; width: 100%">
            <div class='forgot'>
                <a href='logout.php'>logout</a>
            </div>
            </div>
        </span>
    </div>
    <div style="height: 315px; position: relative">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/RIkCvTPcoNU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>
</div>
</body>
</html>
