<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
?>

<html>
<head>
<link rel="stylesheet" href="../style/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<title>
Registration
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
    if ($_POST['registerbtn']) {
        $getuser = $_POST['user'];
        $getemail = $_POST['email'];
        $getproj = $_POST['proj'];
        $getpass = $_POST['pass'];
        $getretypepass = $_POST['retypepass'];
        $user_created = false;
        $emsg = "";
        $administrator = "gmpoemailid@GMPO.com";
        // Change this variable to true if email verification and activation is needed.
        $do_email_activation = false;
        
        if ($do_email_activation) {
            $activateuser = 0;
        }
        else {
            $activateuser = 1;
        }
        if ($getuser) {
            if ($getemail) {
                if ($getproj) {
                    if ($getpass) {
                        if ($getretypepass) {
                            if ($getpass === $getretypepass) {
                                if (filter_var($getemail, FILTER_VALIDATE_EMAIL)) {
                                    // Check if username already exist in DB
                                    require("connect.php");
                                    $stmt = $db->query("SELECT * FROM users WHERE username='$getuser'");
                                    $row_count = $stmt->rowCount();
                                    if ($row_count == 0) {
                                        $stmt = $db->query("SELECT * FROM users WHERE username='$getemail'");
                                        $row_count = $stmt->rowCount();
                                        if ($row_count == 0) {
                                            // All OK now, create the user
                                            // Commented the below code for popup to tell user than user creation in progress.
                                            // <script type='text/javascript'>
                                                // alert("Creating the user. Please wait...");
                                            // </script>
                                            
                                            //$password = md5(md5("AAP321" . $pass . "gmpoadmin"));
                                            $password = md5("aj" . $getpass . "ay");
                                            $code = md5(rand());
                                            
                                            // Insert the user details in DB
                                            $db->query("INSERT INTO users VALUES ('', '$getuser', '$password', '$getemail', '$getproj', '$activateuser', '$code')");
                                            
                                            // Verify that user is created
                                            $stmt = $db->query("SELECT * FROM users WHERE username='$getuser'");
                                            $row_count = $stmt->rowCount();
                                            if ($row_count == 1) {
                                                $user_created = true;
                                            }
                                            else
                                                $emsg = "An error occurred. Your account is not created.";
                                        }
                                        else
                                            $emsg = "There is already a user with that email";
                                    }
                                    else
                                        $emsg = "There is already a user with that username";
                                    // Destroy the DB object
                                    $db->null;
                                }
                                else
                                    $emsg = "Invalid email specified";
                            }
                            else
                                $emsg = "Passwords did not match";
                        }
                        else
                            $emsg = "You must retype the password";
                    }
                    else
                        $emsg = "You must enter a password";
                }
                else
                    $emsg = "You must enter a project name";
            }
            else
                $emsg = "You must enter an email";
        }
        else 
            $emsg = "You must enter a username";
    }
    
    $form = "<form action='./register.php' method='post'>
            <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
                <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>GMPO Automation</h2>
            </div>
            <div class='w3-card-4' style='width:450px; margin:50 auto;'>
                <div class='w3-container w3-teal'>
                    <h2>New User Registration</h2>
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
                <td class='w3-label w3-text-teal'>Project</td>
                <td><input class='w3-input w3-border w3-round w3-light-grey' type='text' name='proj' value='$getproj'/></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>Password</td>
                <td><input class='w3-input w3-border w3-round w3-light-grey' type='password' name='pass' value=''/></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal' text-align='right'>Retype password</td>
                <td><input class='w3-input w3-border w3-round w3-light-grey' type='password' name='retypepass' value=''/></td>
            </tr>
            
            <tr>
                <td></td>
                <td><input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='registerbtn' value='Register'/></td>
            </tr>
            </table>
            <div class='w3-container w3-label w3-text-grey'>Already a user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php' style='text-align:right;'>Login</a></div>
            <br>
            </form>";
    
    if ($user_created) {
        $sentemail = false;
        $formmessage_part1 = "<br><br>
                          <div class='w3-container'>
                          <div class='w3-card-4'>
                          <div class='w3-container w3-teal'>
                          <h2>Message</h2>
                          </div>
                          <div class='w3-container'>";
        $formmessage_part2 = "<br><br></div></div></div>";
        
        if ($do_email_activation) {
            //echo "Account created. Sending account activation email.<br>";
            $site = "http://localhost/dashboard/login";
            $webmaster = "gmpoemailid@GMPO.com";
            $headers = "From: $webmaster";
            $subject = "Activate your account";
            $message = "Thanks for registering. Click the below link to activate your account.\n";
            $message .= "$site/activate.php?user=$getuser&code=$code \n";
            $message .= "You must activate your account to login.";
            // For mail to work, update files: 
            // 1. C:\xampp\php\php.ini => Uncomment:
            // sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t" & comment other path having mailtodisk.exe
            // extension=php_openssl.dll
            // 2. C:\xampp\sendmail\sendmail.ini => Update:
            // smtp_server=email.GMPO.com
            // smtp_port=587
            // auth_username=gmpoemailid
            // auth_password=password
            if (mail($getemail, $subject, $message, $headers)) {
                $sentemail = true;
            }
            else {
                $sentemail = false;
                $emsg = "An error occurred. Account created but account activation email was not sent.<br>";
                $emsg .= "<a class='w3-round w3-brown w3-padding-4 w3-center' href='./login.php'>Login here</a>";
            }
        }
        
        echo "$formmessage_part1";
        if ($do_email_activation) {
            if ($sentemail) {
                echo "You have been registered. You must activate your account using the link sent to your email address: <b>$getemail</b>";
            }
            else {
                echo "ERROR: Account created but account activation email was not sent to your email address: <b>$getemail</b><br>";
                echo "Please contact administrator: <b>$administrator</b>";
            }
        }
        else {
            echo "You have been registered and your account is active. You can Login now: <b>$getuser</b>";
        }
        echo "<br><br>";
        echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php'>Login here</a>";
        
        echo "$formmessage_part2";
        
        $getuser = "";
        $getpass = "";
        exit();
    }
    else {
        echo $form;
    }
    ?>
</body>
</html>
