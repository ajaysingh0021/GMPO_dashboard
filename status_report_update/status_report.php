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
StatusReport
</title>
</head>
<body>
<?php
    $admin_users = array('gmpoemailid', 'krivs');
    if ($username && $userid) {
        
        //echo "Welcome <b>$username</b>, <a href='../login/logout.php'>Logout</a>";
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
        // If the user table does not exist - we need to create it here
        
        
        require("../login/connect.php");
        $stmt = $db->query("SELECT * FROM users WHERE username='$username'");
        $row_count = $stmt->rowCount();
        if ($row_count == 1) {
            // $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // $dbuser = $row['username'];
            // $dbemail = $row['email'];
            // $dbproject = $row['project'];
            
            # As user is found and user needs to update status - make sure the DB for him exists, else create it
            $db_for_statusreport = 'status_' . $username;
            //if ($db->query("SELECT $db_for_statusreport FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = 'GMPO_automation'")->fetch()) // table exists.
            if ($db->query ("DESCRIBE $db_for_statusreport"  )) {
                #echo "User DB table exist";
            } else {
                #echo "User DB table doesn't exist, creating it";
                // sql to create table
                $sql = "CREATE TABLE $db_for_statusreport (
                date date NOT NULL,
                completed VARCHAR(5000) NOT NULL,
                inprogress_planned VARCHAR(5000) NOT NULL
                )";
                
                // use exec() because no results are returned
                $db->exec($sql);
                #echo "Table $db_for_statusreport created successfully";
            }
        }
        else {
            $emsg = "Username not found. Please login again.";
        }
        $db = null;
        
        $form_start = "<form action='./status_report.php' method='post'>
        <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
            <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>NCS4K Team</h2>
        </div>
        <br>
        <div class='w3-container'>
        <div class='w3-display-container'>
        <div class='w3-display-topleft'>Welcome <b>$username</b></div>
        <div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='../logout/logout.php' style='text-align:right;'>Logout</a></div>
        </div></div>
        ";
        
        $form_mid1 = "
        <div class='w3-card-4' style='width:70%; margin:50 auto;'>
            <div class='w3-container w3-teal'>
                <h2>Status Reporting</h2>
            </div>
            <div class='w3-panel w3-light-grey'>
            <h3 class='w3-opacity'>Select an option:</h3>
            </div>
            <ol class='w3-ul w3-hoverable'>
                <li><a href='./update_status.php'>Update Your Status</a></li>
                <li><a href='./view_status.php'>View Your Status</a></li>
                ";
                
        $form_mid2 = "<li><a href='./tasks_bucket.php'>See any team member's status</a></li>";
        $form_mid3 = "</ol>";
            
        $form_end = "<br><br>
            <div class='w3-container w3-label w3-text-grey'>Go back to dashboard &nbsp;&nbsp;<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='../index2.php' style='text-align:right;'>Dashboard</a></div>
            <br>
        </div>
        </form>";
        
        echo $form_start;
        echo $form_mid1;
        if (in_array($username, $admin_users)) {
            echo $form_mid2;
        }
        echo $form_mid3;
        echo $form_end;
        
    }
    else {
        echo "$formmessage_part1";
        $main_form_msg = "You are not logged-in. Please login to view this page.";
        echo "$main_form_msg";
        echo "<br><br>";
        echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='../login/login.php'>Login</a>";
        echo "$formmessage_part2";
    }
?>
</body>
</html>
