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
User Activation
</title>
</head>
<body>
<?php
    $getuser = $_GET['user'];
    $getcode = $_GET['code'];
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
    
    if ($getuser && $getcode) {
        require("./connect.php");
        $stmt = $db->query("SELECT * FROM users WHERE username='$getuser'");
        $row_count = $stmt->rowCount();
        if ($row_count == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $dbcode = $row['code'];
            $dbactive = $row['active'];
            
            if ($dbactive == 0) {
                if ($dbcode == $getcode) {
                    // Activate the user
                    $db->query("UPDATE users SET active='1' WHERE username='$getuser'");
                    
                    // Verify that user is activated
                    $stmt = $db->query("SELECT * FROM users WHERE username='$getuser' AND active='1'");
                    $row_count = $stmt->rowCount();
                    if ($row_count == 1) {
                        $user_activated = true;
                        $main_form_msg = "Your account is now active: <b>$getuser</b>";
                        $getuser = "";
                        $getcode = "";
                    }
                    else
                        $main_form_msg = "An error has occurred. User not activated. Please contact administrator: $administrator";
                }
                else
                    $main_form_msg = "Incorrect code. User not activated.";
            }
            else
                $main_form_msg = "This account is already active";
        }
        else
            $main_form_msg = "User does not exist. Please register again.";
        
        // Destroy the DB connection object
        $db = null;
    }
    else {
        $main_form_msg = "Incorrect information found to activate the account. Register again.";
    }
    
    echo "$formmessage_part1";
    echo "$main_form_msg";
    echo "<br><br>";
    echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php'>Login here</a>";
    echo "$formmessage_part2";    
?>
</body>
</html>
