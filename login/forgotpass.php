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
Forgot Password
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
// Process to set email server::
// C:\xampp\sendmail\sendmail.ini::
// smtp_server=email.GMPO.com
// smtp_port=587
// auth_username=gmpoemailid
// auth_password=a********

// C:\xampp\php\php.ini::
// ;SMTP=localhost
// ;smtp_port=25
// sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"

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
    
    if (!$username && !$userid) {
        if ($_POST['resetbtn']) {
            $getuser = $_POST['user'];
            $getemail = $_POST['email'];
            
            // Check if info is provided
            if ($getuser) {
                if ($getemail) {
                    if (filter_var($getemail, FILTER_VALIDATE_EMAIL)) {
                        // Connect DB and check if user exists
                        require("connect.php");
                        $stmt = $db->query("SELECT * FROM users WHERE username='$getuser'");
                        $row_count = $stmt->rowCount();
                        if ($row_count == 1) {
                            // Get info about account
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            // $dbid = $row['id'];
                            // $dbuser = $row['username'];
                            // $dbpass = $row['password'];
                            // $dbactive = $row['active'];
                            $dbemail = $row['email'];
                            $dbcode = $row['code'];
                            
                            if ($dbemail == $getemail) {
                                // Generate new random password
                                $pass = rand();
                                $pass = md5($pass);
                                $pass = substr($pass,0,6);
                                $password = md5("aj" . $pass . "ay");
                                
                                // Create email
                                if ($do_email_resetpwd) {
                                    //echo "Account created. Sending account activation email.<br>";
                                    $site = "http://localhost/dashboard/login";
                                    $webmaster = "gmpoemailid@GMPO.com";
                                    $headers = "From: gmpo admin<$webmaster>";
                                    $subject = "Reset Password";
                                    $message = "As per your request, your password has been reset. Your new password is below:\n";
                                    $message .= "Password = $pass";
                                    $message .= "\n";
                                    $message .= "Click the below link to set new password.\n";
                                    $message .= "$site/resetpwd.php?user=$getuser&code=$dbcode&pwd=$pass \n";
                                    $message .= "Do not click the above link if you have not requested the password reset and continue using your old password.";
                                    $success = true;
                                    if (mail($getemail, $subject, $message, $headers)) {
                                        $sentemail = true;
                                        $main_form_msg = "Your password has been reset and an email has been sent with your new password.";
                                    }
                                    else {
                                        $sentemail = false;
                                        $main_form_msg = "An error has occurred and email was not sent containing your new password. Please contact: $webmaster";
                                    }
                                    $main_form_msg .= "<br><br>";
                                    $main_form_msg .= "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php'>Login here</a>";
                                }
                                else {
                                    $success = true;
                                    $main_form_msg = "Your password is now reset to: $pass<br>";
                                    $main_form_msg .= "Click the below link to go to change password page.<br>";
                                    $main_form_msg .= "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./resetpwd.php?user=$getuser&code=$dbcode&pwd=$pass'>Change Password</a>";
                                }
                                // }
                                // else {
                                    // echo "An error has occurred and your password is not reset";
                                // }
                            }
                            else {
                                $emsg = "You entered wrong email id";
                            }
                        }
                        else {
                            $emsg = "Username not found";
                        }
                        $db->null;
                    }
                    else {
                        $emsg = "Invalid email specified";
                    }
                }
                else {
                    $emsg = "Please enter your email";
                }
            }
            else {
                $emsg = "Please enter your username";
            }
        }
    }
    else {
        echo $formmessage_part1;
        echo "You are already logged in.<br>Please logout to view this page.<br><br>";
        echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./logout.php' style='text-align:right;'>Logout</a>";
        echo $formmessage_part2;
        exit;
    }
    
    $form = "<form action='./forgotpass.php' method='post'>
        <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
            <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>GMPO Automation</h2>
        </div>
        <div class='w3-card-4' style='width:450px; margin:50 auto;'>
            <div class='w3-container w3-teal'>
                <h2>Email Password</h2>
            </div>
            
            <table class='w3-container w3-padding-8'>
            <tr>
                <td></td>
                <td><font color='red'>$emsg</font></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>Username</td>
                <td><input class='w3-input w3-border w3-round w3-light-grey' type='text' name='user' value='$getuser'/></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal' text-align='right'>Email</td>
                <td><input class='w3-input w3-border w3-round w3-light-grey' type='text' name='email' value='$getemail'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='resetbtn' value='Reset Password'/></td>
            </tr>
            </table>
            <div class='w3-container w3-label w3-text-grey'>Login?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php' style='text-align:right;'>Login</a></div>
            <br>
        </div>
        </form>";
    
    if (!$success) {
        echo $form;
    }
    else {
        echo $formmessage_part1;
        echo "$main_form_msg";
        //echo "<br><br>";
        //echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php'>Login here</a>";
        echo $formmessage_part2;
    }
    
?>
</body>
</html>
