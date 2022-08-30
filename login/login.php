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
<style>
td {
    padding:5px;
}
</style>
<style type="text/css">a {text-decoration: none}</style>
<title>Login</title>
</head>
<body>
<?php
    $success = false;
    
    if ($_POST['loginbtn']) {
        $user = $_POST['user'];
        $password = $_POST['password'];
        
        if ($user) {
            if ($password) {
                //echo "$user - $password <hr />";
                //$encpass = md5(md5("aj" . $password . "ay"));
                $encpass = md5("aj" . $password . "ay");
                
                // Make sure login is correct
                require("connect.php");
                $stmt = $db->query("SELECT * FROM users WHERE username='$user'");
                $row_count = $stmt->rowCount();
                if ($row_count == 1) {
                    // foreach($stmt as $row) {
                        // echo $row['id'] . '--' . $row['username'] . '--' . $row['password'] . '--' . $row['email'] . '--' . $row['project'] . '--' . $row['active'] . '--' . $row['code'];
                    // }
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $dbid = $row['id'];
                    $dbuser = $row['username'];
                    $dbpass = $row['password'];
                    $dbactive = $row['active'];
                    if ($encpass === $dbpass) {
                        if ($dbactive == 1) {
                            // Set session info
                            $_SESSION['username'] = $dbuser;
                            $_SESSION['userid'] = $dbid;
                            //echo "You have been logged in as <b>$dbuser</b><br/><a href='./member.php'>Click here</a> to go to Members page";
                            echo "Login successful!!";
                            $success = true;
                            //header('refresh:0; url=member.php');
                            header('refresh:0; url=../index2.php');
                        }
                        else
                            //echo "User not active. Please look for account activation email in your mailbox specified at registration time. $form";
                            $errormsg = "User not active. Please look for account activation email in your mailbox specified at registration time";
                    }
                    else
                        //echo "Incorrect Password. $form";
                        $errormsg = "Incorrect Password";
                }
                else 
                    //echo "Username not found. $form";
                    $errormsg = "Username not found";
                
                $db = null;
                #mysql_close();
            }
            else
                //echo "You must enter specify password. $form";
                $errormsg = "You must enter a password";
        }
        else {
            //echo "You must enter a username. $form";
            $errormsg = "You must enter a username";
        }
    }
    
    // class='w3-spin'
    
    $form = "<form class='w3-container' action='./login.php' method='post'>
            <p>
            <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
              
              <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>NCS4K Team</h2>
            </div>
            <div class='w3-card-4' style='width:400px; margin:50 auto;'>
                <div class='w3-container w3-teal'>
                    <h2>Login</h2>
                </div>
                
                <table class='w3-container w3-padding-8'>
                    <tr>
                    <td></td>
                    <td><font color='red'>$errormsg</font></td></tr>
                    
                    <tr>
                        <td class='w3-label w3-text-teal'>Username</td>
                        <td><input class='w3-input w3-border w3-round w3-light-grey' type='text' name='user' /></td>
                    </tr>
                    
                    <tr>
                        <td class='w3-label w3-text-teal'>Password</td>
                        <td><input class='w3-input w3-border w3-round w3-light-grey' type='password' name='password' /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                        <input class='w3-btn w3-round w3-teal w3-hover-green w3-large' type='submit' name='loginbtn' value='Login'/>
                        <a class='w3-btn w3-round w3-grey w3-padding-small w3-hover-green' href='./guestlogin.php?user=guest' style='text-align:right;'>Login as Guest</a>
                        </td>
                    </tr>
                </table>
                <div class='w3-container w3-label w3-text-grey'>Forgot Password?&nbsp;&nbsp; <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./forgotpass.php' style='text-align:right;'>Forgot Password</a></div>
                <div class='w3-container w3-label w3-text-grey'>New User Signup?&nbsp; <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./register.php' style='text-align:right;'>Sign-Up</a></div>
                <br>
            </div>
            </p>
            </form>";
    if (!$success) {
        echo $form;
    }
    
    //echo "<p align=center><i class='w3-large w3-spin fa fa-refresh'></i></p>";
?>
    
<div style="position: relative">
    <p style="position: fixed; bottom: 0; width:100%; text-align: center; color:grey;">
    GMPO
    </p>
</div>

</body>
</html>
