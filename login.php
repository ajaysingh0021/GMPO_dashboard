<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>

<html>
<head>
<title>Scapa Automation - Login</title>
</head>
<body>
    <?php
        header('refresh:0; url=./login/login.php');
    ?>
</body>
</html>