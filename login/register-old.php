<?php
error_reporting(E_ALL ^ E_NOTICE);
#error_reporting(E_ALL ^ E_DEPRECATED);
session_start();
// $userid = $_SESSION['userid'];
// $username = $_SESSION['username'];
?>

<html>
<head>
<title>
Member System - Registration
</title>
</head>
<body>
    <?php
    if ($_POST['registerbtn']) {
        $getuser = $_POST['user'];
        $getemail = $_POST['email'];
        $getproj = $_POST['proj'];
        $getpass = $_POST['pass'];
        $getretypepass = $_POST['retypepass'];
        
        $errors = array();
        $emsg = "";
        if (!$getuser) {
            $emsg = "You must enter a username";
            array_push($errors, $emsg);
        }
        else if (!$getemail) {
            $emsg = "You must enter an email";
            array_push($errors, $emsg);
        }
        else if (!$getproj) {
            $emsg = "Please specify your project name";
            array_push($errors, $emsg);
        }
        else if (!$getpass) {
            $emsg = "You must enter a password";
            array_push($errors, $emsg);
        }
        else if (!$getretypepass) {
            $emsg = "You must retype the password";
            array_push($errors, $emsg);
        }
        else if (!($getpass === $getretypepass)) {
            $emsg = "Passwords did not match";
            array_push($errors, $emsg);
        }
        else if (!$getretypepass) {
            $emsg = "Invalid email id specified";
            array_push($errors, $emsg);
        }
        else if (!filter_var($getemail, FILTER_VALIDATE_EMAIL)) {
            $emsg = "Invalid email specified";
            array_push($errors, $emsg);
        }
        else {
            // Check if username already exist in DB
            require("connect.php");
            $stmt = $db->query("SELECT * FROM users WHERE username='$getuser'");
            $row_count = $stmt->rowCount();
            if (!($row_count == 0)) {
                $emsg = "Username already exist. Specify another username or login with your password. <a href='./login.php'>Login here<a>";
                array_push($errors, $emsg);
            }
            
            // All OK now, create the user
            $password = md5(md5("AAP321" . $password . "gmpoadmin"));
            $code = md5(rand());
            $db->query("INSERT INTO users VALUES (
                        '', '$getuser', '$getpass', '$getemail', '$getproj', '0', '$code'
            )");
            
            $stmt = $db->query("SELECT * FROM users WHERE username='$getuser'");
            $row_count = $stmt->rowCount();
            if (!($row_count == 1)) {
                $emsg = "An error occurred. Your account is not created.";
                array_push($errors, $emsg);
            }
            else {
                
                $site = "http://localhost/dashboard/login";
                $webmaster = "gmpo admin <gmpoemailid@GMPO.com>";
                $headers = "From: $webmaster";
                $subject = "Activate your account";
                $message = "Thanks for registering. Click the below link to activate your account.\n";
                $message .= "$site/activate.php?user=$getuser&code=$code/n";
                $message .= "You must activate your account to login.";
                
                if (mail($getemail, $subject, $message, $headers)) {
                    $msg = "You have been registered. You must activate your account using the link sent to your email address <b>$getemail</b>";
                    $getuser = "";
                    $getpass = "";
                }
                else {
                    $emsg = "An error occurred. Your activation email was not sent.";
                    array_push($errors, $emsg);
                }
            }
        }
        $errormsg = '';
        if ($errors) {
            foreach ($errors as $error) {
                $errormsg = "$errormsg <br> $error";
            }
        }
    }
    // else {
        // echo "Please login to get access to this page. <a href='./login.php'>Login here</a>";
    // }
    
    
    
    $form = "<form action='./register.php' method='post'>
            <table>
            <tr>
                <td></td>
                <td><font color='red'>$emsg</font></td>
            </tr>
            
            <tr>
                <td>Username:</td>
                <td><input type='text' name='user' value='$getuser'/></td>
            </tr>
            
            <tr>
                <td>Email:</td>
                <td><input type='text' name='email' value='$getemail'/></td>
            </tr>
            
            <tr>
                <td>Project:</td>
                <td><input type='text' name='proj' value='$getproj'/></td>
            </tr>
            
            <tr>
                <td>Password:</td>
                <td><input type='password' name='pass' value=''/></td>
            </tr>
            
            <tr>
                <td>Retype Password:</td>
                <td><input type='password' name='retypepass' value=''/></td>
            </tr>
            
            <tr>
                <td></td>
                <td><input type='submit' name='registerbtn' value='Register'/></td>
            </tr>
            </table>
            </form>";
    echo $form;
    
    // if ($username && $userid) {
        // echo "Welcome <b>$username</b>, <a href='./logout.php'>Logout</a>";
    // }
    // else {
        // echo "Please login to get access to this page. <a href='./login.php'>Login here</a>";
    // }
    
    ?>
</body>
</html>
