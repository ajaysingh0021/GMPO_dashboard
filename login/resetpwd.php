<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>

<html>
<head>
<link rel="stylesheet" href="../style/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<title>
Reset Password
</title>
</head>
<body>
<?php
    $getuser = $_GET['user'];
    $getcode = $_GET['code'];
    $getpass = $_GET['pwd'];
    $user_activated = false;
    $main_form_msg = "";
    $administrator = "gmpoemailid@GMPO.com";
    
    $formmessage_part1 = "<br><br>
                          <div class='w3-container'>
                          <div class='w3-card-4'>
                          <div class='w3-container w3-teal'>
                          <h2>Message</h2>
                          </div>
                          <div class='w3-container'>
                          <br>";
    $formmessage_part2 = "<br><br></div></div></div>";
    
    if ($getuser && $getcode && $getpass) {
        require("./connect.php");
        $stmt = $db->query("SELECT * FROM users WHERE username='$getuser' AND code='$getcode'");
        $row_count = $stmt->rowCount();
        if ($row_count == 1) {
            // Reset the user password
            $password = md5("aj" . $getpass . "ay");
            $db->query("UPDATE users SET password='$password' WHERE username='$getuser'");
            
            // Verify if password is updated
            $stmt = $db->query("SELECT * FROM users WHERE username='$getuser' and password='$password'");
            $row_count = $stmt->rowCount();
            if ($row_count == 1) {
                // Redirect to change password screen
                //echo "Redirecting to change password screen...";
                $main_form_msg = "Redirecting to change password screen...";
                //header("refresh:1; url=./changepwd.php?user=$getuser");
                $_SESSION['username'] = $getuser;
                //$_SESSION['userid'] = $dbid;
                header("refresh:1; url=./changepwd.php");
                //exit;
            }
            else {
                $main_form_msg = "An error occurred in resetting the password.";
            }
        }
        else
            $main_form_msg = "User does not exist.";
        
        // Destroy the DB connection object
        $db = null;
    }
    else {
        $main_form_msg = "Incorrect information found to reset the password.";
    }
    
    echo "$formmessage_part1";
    echo "$main_form_msg";
    echo "<br><br>";
    echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php'>Login here</a>";
    echo "$formmessage_part2";    
?>
</body>
</html>