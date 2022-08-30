<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>

<html>
<head>
<title>Guest Login</title>
</head>
<body>
<?php
    $getuser = $_GET['user'];
    
    if ($getuser) {
        require("connect.php");
        $stmt = $db->query("SELECT * FROM users WHERE username='$getuser'");
        $row_count = $stmt->rowCount();
        if ($row_count == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $dbid = $row['id'];
            $dbuser = $row['username'];
            $_SESSION['username'] = $dbuser;
            $_SESSION['userid'] = $dbid;
            echo "Continuing as Guest...";
            $success = true;
            header('refresh:1; url=../index2.php');
        }
        else {
            echo "Guest login not enabled. Please contact: gmpoemailid@GMPO.com";
        }
        // Destroy the object
        $db = null;
    }
    else {
        echo "Guest login not found. Please contact: gmpoemailid@GMPO.com";
    }
?>
</body>
</html>
