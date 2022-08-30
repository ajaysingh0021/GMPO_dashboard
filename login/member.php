<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>

<html>
<head>
<link rel="stylesheet" href="../style/w3.css">
<title>
Profile
</title>
</head>
<body>
<?php
    if ($username && $userid) {
        
        //echo "Welcome <b>$username</b>, <a href='./logout.php'>Logout</a>";
        $formmessage_part1 = "<br><br>
                          <div class='w3-container'>
                          <div class='w3-card-4'>
                          <div class='w3-container w3-teal'>
                          <h2>Message</h2>
                          </div>
                          <div class='w3-container'>
                          <br>";
        $formmessage_part2 = "<br><br></div></div></div>";
        
        // Get Email and Project values for current user and display those.
        require("connect.php");
        $stmt = $db->query("SELECT * FROM users WHERE username='$username'");
        $row_count = $stmt->rowCount();
        if ($row_count == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $dbuser = $row['username'];
            $dbemail = $row['email'];
            $dbproject = $row['project'];
        }
        else {
            $emsg = "Username not found. Please login again.";
        }
        $db = null;
        
        $form = "<form action='./changepwd.php' method='post'>
        <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
            <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>GMPO Automation</h2>
        </div>
        <br>
        <div class='w3-container'>
        <div class='w3-display-container'>
        <div class='w3-display-topleft'>Welcome <b>$username</b></div>
        <div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='./logout.php' style='text-align:right;'>Logout</a></div>
        </div></div>
        
        <div class='w3-card-4' style='width:90%; margin:50 auto;'>
            <div class='w3-container w3-teal'>
                <h2>Profile</h2>
            </div>
            
            <table class='w3-container w3-padding-8'>
            <tr>
                <td></td>
                <td><font color='red'>$emsg</font></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>Username</td>
                <td><h3 class='w3-panel w3-round-large w3-light-grey'>$dbuser </h3></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal' text-align='right'>Email</td>
                <td><h3 class='w3-panel w3-round-large w3-light-grey'>$dbemail</h3></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal' text-align='right'>Project</td>
                <td><h3 class='w3-panel w3-round-large w3-light-grey'>$dbproject</h3></td>
            </tr>
            
            <tr>
                <td></td>
                <td><input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='changepwdbtn' value='Change Password'/></td>
            </tr>
            </table>
            <div class='w3-container w3-label w3-text-grey'>Go back to dashboard &nbsp;&nbsp;<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='../index2.php' style='text-align:right;'>Dashboard</a></div>
            <br>
        </div>
        </form>";
        echo $form;
        
    }
    else {
        echo "$formmessage_part1";
        $main_form_msg = "You are not logged-in. Please login to view this page.";
        echo "$main_form_msg";
        echo "<br><br>";
        echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php'>Login</a>";
        echo "$formmessage_part2";    
        // echo "Please login to get access to this page. <a href='./login.php'>Login here</a>";
        // exit;
    }
?>
</body>
</html>
