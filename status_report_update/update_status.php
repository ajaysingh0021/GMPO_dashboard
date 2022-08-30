<?php
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_DEPRECATED);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>

<html>
<head>
<link rel="stylesheet" href="../style/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<title>
UpdateStatus
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
    // $getdate = $_POST['task_date'];
    // $getcompletedtask = $_POST['task_completed'];
    // $getplannedtask = $_POST['task_planned'];
    // $status_updated = false;
    if ($username && $userid) {
        if ($_POST['update_status_btn']) {
            $getdate = $_POST['task_date'];
            $getcompletedtask = trim(mysql_real_escape_string($_POST['task_completed']));
            $getplannedtask = trim(mysql_real_escape_string($_POST['task_planned']));
            $status_updated = false;
            // $form = $form;
            
            $emsg = "";
            $administrator = "gmpoemailid@GMPO.com";
            
            if ($getdate) {
                if ($getcompletedtask) {
                    if ($getplannedtask) {
                        // Check if date already exist in DB
                        require("../login/connect.php");
                        #$loggedin_user = 'gmpoemailid';
                        #$db_to_update = 'status_' . $loggedin_user;
                        $db_to_update = 'status_' . $username;
                        $stmt = $db->query("SELECT * FROM $db_to_update WHERE date='$getdate'");
                        if(empty($stmt)) {
                            // echo "<p>" . $db_to_update . " table does not exist</p>";
                            // sql to create table
                            $sql = "CREATE TABLE $db_to_update (
                                    date DATE PRIMARY KEY,
                                    completed VARCHAR(5000) NOT NULL,
                                    inprogress_planned VARCHAR(5000) NOT NULL
                                    )";
                            $out = $db->query($sql);
                            if(empty($out)) {
                                echo "Error creating table: " . $db->error;
                                echo "<p>Make sure you are logged-in and retry. If it does not help contact admin:" . $administrator . "</p>";
                            } 
                            // // DEBUG::
                            // else {
                                // echo "<p>" . $db_to_update . "table created successfully</p>";
                            // }
                        }
                        // // DEBUG::
                        // else {
                            // echo "<p>" . $db_to_update . "table exists</p>";
                        // }
                        $stmt = $db->query("SELECT * FROM $db_to_update WHERE date='$getdate'");
                        $row_count = $stmt->rowCount();
                        if ($row_count == 0) {
                            // Insert the status in DB
                            $db->query("INSERT INTO $db_to_update VALUES ('$getdate', '$getcompletedtask', '$getplannedtask')");
                            
                            // Verify that user is created
                            $stmt = $db->query("SELECT * FROM $db_to_update WHERE date='$getdate'");
                            $row_count = $stmt->rowCount();
                            if ($row_count == 1) {
                                $status_updated = true;
                            }
                            else
                                $emsg = "An error occurred. Your account is not created.";
                            }
                        else
                            $emsg = "There is already an entry for the selected date. Please go to modify screen to update the earlier status.";
                        // Destroy the DB object
                        $db->null;
                    }
                    else
                        $emsg = "Please specify the tasks in progress or planned tasks";
                }
                else
                    $emsg = "Please specify the completed task or type None";
            }
            else
                $emsg = "Please select a date for the status";
        }
        
        $form = "<form action='./update_status.php' method='post'>
                <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
                    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>NCS4K Team</h2>
                </div>
                
                <div class='w3-container'>
                <div class='w3-display-container'>
                <div class='w3-display-topleft'>Welcome <b>$username</b></div>
                <div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='../login/logout.php' style='text-align:right;'>Logout</a></div>
                </div></div>
                
                <div class='w3-card-4' style='width:70%; margin:50 auto;'>
                    <div class='w3-container w3-teal'>
                        <h2>Update Status</h2>
                    </div>
                    
                <table class='w3-container w3-padding-8'>
                <tr>
                    <td></td>
                    <td><font color='red'>$emsg</font></td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Select the date (mm/dd/yyyy)<br><font size='1'><i>Select the date from the drop-down<br>For unsupported browsers type the date in correct format</i></font></td>
                    <td><input class='w3-input w3-border w3-round w3-pale-yellow' type='date' name='task_date' value='$getdate'/></td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal' text-align='right'>Completed Tasks<br><font size='1'><i>You can specify multiple tasks and can use numbering</i></font></td>
                    <td><textarea class='textarea w3-input w3-border w3-round w3-pale-yellow' name='task_completed' type='text' cols='40' rows='5'>$getcompletedtask</textarea></td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Inprogress/Planned Tasks<br><font size='1'><i>You can specify multiple tasks and can use numbering</i></font></td>
                    <td><textarea class='w3-input w3-border w3-round w3-pale-yellow' name='task_planned' cols='40' rows='5'>$getplannedtask</textarea></td>
                </tr>
                
                <tr>
                    <td></td>
                    <td><input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='update_status_btn' value='Update Status'/></td>
                </tr>
                </table>
                <div class='w3-container w3-label w3-text-grey'>Go back to dashboard&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='../index2.php' style='text-align:right;'>Dashboard</a></div>
                <br>
                </form>";
        
        if ($status_updated) {
            $formmessage_part1 = "<br><br>
                              <div class='w3-container'>
                              <div class='w3-card-4'>
                              <div class='w3-container w3-teal'>
                              <h2>Message</h2>
                              </div>
                              <div class='w3-container'>";
            $formmessage_part2 = "<br><br></div></div></div>";
            $message = "Your status has been recorded. Thank you.<br>";
            $message .= "<b>Date:</b>&nbsp;$getdate<br>";
            $message .= "<b>Completed tasks:</b><br>&nbsp;&nbsp;$getcompletedtask<br>";
            $message .= "<b>Inprogress/Planned tasks:</b><br>&nbsp;&nbsp;$getplannedtask<br>";
            
            echo "$formmessage_part1";
            echo "<br>";
            echo "$message";
            echo "<br>";
            echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='../index2.php'>Go to Dashboard</a>";
            
            echo "$formmessage_part2";
            exit();
        }
        else {
            echo $form;
        }
    }
    else {
        echo "$formmessage_part1";
        $main_form_msg = "You are not logged-in. Please login to view this page.";
        echo "$main_form_msg";
        echo "<br><br>";
        echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='../login/login.php'>Login</a>";
        echo "$formmessage_part2";    
        // echo "Please login to get access to this page. <a href='../login/login.php'>Login here</a>";
        // exit;
    }
?>
</body>
</html>
