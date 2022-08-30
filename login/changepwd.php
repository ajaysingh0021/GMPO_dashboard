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
Change Password
</title>
<style>
td {
    padding:5px;
}
</style>
<style type="text/css">a {text-decoration: none}</style>
</head>
<body>
<?php
    $do_email_resetpwd = true;
    
    $formmessage_part1 = "<br><br>
                          <div class='w3-container'>
                          <div class='w3-card-4'>
                          <div class='w3-container w3-teal'>
                          <h2>Message</h2>
                          </div>
                          <div class='w3-container'>
                          <br>";
    $formmessage_part2 = "<br><br></div></div></div>";
    $progressbar = "<br>
                    <div class='w3-container'>
                    <div class='w3-progress-container'>
                    <div id='myBar' class='w3-progressbar w3-green' style='width:1%'></div>
                    </div></div>";
    $success = false;
    
    $getuser = $username;
    
    // $_SESSION['username']
    // if ($_GET['user']) {
        // $getuser = $_GET['user'];
    // }
    // else {
        // $getuser = $username;
    // }
    if ($getuser) {
        if ($_POST['changepwdbtn']) {
            // Check if info is provided
            $getcurrentpass = $_POST['getcurrentpass'];
            $getnewpass = $_POST['getnewpass'];
            $getretypepass = $_POST['getretypepass'];
            
            if ($getcurrentpass) {
                if ($getnewpass) {
                    if ($getretypepass) {
                        if ($getnewpass === $getretypepass) {
                            // Connect DB and check if user exists
                            require("connect.php");
                            $encpass = md5("aj" . $getcurrentpass . "ay");
                            $stmt = $db->query("SELECT * FROM users WHERE username='$getuser' AND password='$encpass'");
                            $row_count = $stmt->rowCount();
                            if ($row_count == 1) {
                                // Update the password
                                $password = md5("aj" . $getnewpass . "ay");
                                $db->query("UPDATE users SET password='$password' WHERE username='$getuser'");
                                
                                // Verify if password is updated
                                $stmt = $db->query("SELECT * FROM users WHERE username='$getuser' and password='$password'");
                                $row_count = $stmt->rowCount();
                                $success = true;
                                if ($row_count == 1) {
                                    $main_form_msg = "Password updated. Please login again.";
                                }
                                else {
                                    $main_form_msg = "An error occurred in resetting the password.";
                                }
                            }
                            else {
                                $emsg = "Incorrect current password";
                            }
                            $db->null;
                        }
                        else {
                            $emsg = "Retype password did not match the new password";
                        }
                    }
                    else {
                        $emsg = "Please retype the password";
                    }
                }
                else {
                    $emsg = "Please enter new password";
                }
            }
            else {
                $emsg = "Please enter Current password";
            }
        }
    }
    else {
        echo $formmessage_part1;
        echo "Username not found.<br><br>";
        echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php' style='text-align:right;'>Login here</a>";
        echo $formmessage_part2;
        exit;
    }
    
    $form = "<form action='./changepwd.php' method='post'>
        <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
            <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>NCS4K Team</h2>
        </div>
        <br>
        <div class='w3-container'>
        <div class='w3-display-container'>
        <div class='w3-display-topleft'>Welcome <b>$getuser</b></div>
        <div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='./logout.php' style='text-align:right;'>Logout</a></div>
        </div></div>
    
        <div class='w3-card-4' style='width:450px; margin:50 auto;'>
            <div class='w3-container w3-teal'>
                <h2>Change Password</h2>
            </div>
            
            <table class='w3-container w3-padding-8'>
            <tr>
                <td></td>
                <td><font color='red'>$emsg</font></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>Current Password</td>
                <td><input class='w3-input w3-border w3-round w3-light-grey' type='password' name='getcurrentpass' value='$getcurrentpass'/></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal' text-align='right'>New Password</td>
                <td><input class='w3-input w3-border w3-round w3-light-grey' type='password' name='getnewpass' value='$getnewpass'/></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal' text-align='right'>Confirm Password</td>
                <td><input class='w3-input w3-border w3-round w3-light-grey' type='password' name='getretypepass' value='$getretypepass'/></td>
            </tr>
            
            <tr>
                <td></td>
                <td><input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='changepwdbtn' value='Change Password'/></td>
            </tr>
            </table>
            <div class='w3-container w3-label w3-text-grey'>Go to back dashboard &nbsp;&nbsp;&nbsp;&nbsp; <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='../index2.php' style='text-align:right;'>Dashboard</a></div>
            <br>
        </div>
        </form>";
    
    if (!$success) {
        echo $form;
    }
    else {
        $_SESSION['userid'] = "";
        $_SESSION['username'] = "";
        echo $formmessage_part1;
        echo "$main_form_msg";
        echo "<br><br>";
        //echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php'>Login here</a>";
        echo "<div class='w3-container w3-label w3-text-grey'>Login &nbsp;&nbsp; <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php' style='text-align:right;'>Login</a></div>";
        
        echo $formmessage_part2;
        // Redirect to change password screen
        //header('refresh:0; url=./changepwd.php');
    }
    
?>
</body>
</html>
