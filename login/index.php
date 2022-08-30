<?php
error_reporting(E_ALL ^ E_NOTICE);
#error_reporting(E_ALL ^ E_DEPRECATED);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>

<html>
<head>
<title>
Index
</title>
</head>
<body>
    
    <a href='./login.php' target="_blank">Login</a>
    <br>
    <a href='./register.php' target="_blank">Register</a>
    
    
</body>
</html>
