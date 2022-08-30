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
ViewStatus
</title>
<style>
td {
    padding:5px;
}
</style>
<style type="text/css">a {text-decoration: none}</style>
</head>
<body>
<script language="javascript">
    function enableDisable(bEnable, textBoxID)
    {
         document.getElementById(textBoxID).disabled = bEnable
    }
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#chkDateRange").click(function () {
            if ($(this).is(":checked")) {
                $("#date2").show();
                $("#lbldate2").show();
            } else {
                $("#date2").hide();
                $("#lbldate2").hide();
            }
        });
    });
</script>

<?php
    // $getdate = $_POST['task_date'];
    // $getcompletedtask = $_POST['task_completed'];
    // $getplannedtask = $_POST['task_planned'];
    // $status_updated = false;
    if ($username && $userid) {
        if ($_POST['get_status_btn']) {
            $getdate = $_POST['task_date'];
            $getdate2 = $_POST['task_date2'];
            $getchkboxdr = $_POST['chkbxdr'];
            echo "getchkboxdr = $getchkboxdr";
            // $getcompletedtask = trim($_POST['task_completed']);
            // $getplannedtask = trim($_POST['task_planned']);
            $status_updated = false;
            // $form = $form;
            
            $emsg = "";
            $administrator = "gmpoemailid@GMPO.com";
            $b_failure_flag = False;
            
            if ($getdate) {
                if ($getchkboxdr) {
                    if (!$getdate2) {
                        //$emsg = "You selected the specify range checkbox but did not select the end date. Please specify it";
                        $b_failure_flag = True;
                    }
                }
                if (!$b_failure_flag) {
                    // Check if date already exist in DB
                    require("../login/connect.php");
                    #$loggedin_user = 'gmpoemailid';
                    #$db_to_update = 'status_' . $loggedin_user;
                    $db_to_update = 'status_' . $username;
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
                        $emsg = "There is already an entry for the selected date.<br>Please go to modify screen to update the earlier status.";
                    // Destroy the DB object
                    $db->null;
                }
                else
                    $emsg = "Please specify the end date OR<br>Proceed with date range checkbox as un-checked";
            }
            else
                $emsg = "Please select a date for the status";
        }
        
        
        $form = "<form action='./view_status.php' method='post'>
                <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
                    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>NCS4K Team</h2>
                </div>
                
                <div class='w3-container'>
                <div class='w3-display-container'>
                <div class='w3-display-topleft'>Welcome <b>$username</b></div>
                <div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='../login/logout.php' style='text-align:right;'>Logout</a></div>
                </div></div>
        
                <div class='w3-card-4' style='width:90%; margin:50 auto;'>
                    <div class='w3-container w3-teal'>
                        <h2>View Status</h2>
                    </div>
                    
                <table class='w3-container w3-padding-8'>
                <tr>
                    <td></td>
                    <td><font color='red'>$emsg</font></td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Select a date range</td>
                    <td>
                    <label for='chkDateRange'>
                        <input class='w3-check' type='checkbox' id='chkDateRange' name='chkbxdr' />
                    </label>
                    </td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Select the date (mm/dd/yyyy)<br><font size='1'><i>Select the date from the drop-down<br>For unsupported browsers type the date in correct format</i></font></td>
                    <td>
                        <input class='w3-input w3-border w3-round w3-pale-yellow' id='date1' type='date' name='task_date' value='$getdate'/>
                    </td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'><div id='lbldate2' style='display: none'>
                    Specify the end date
                    </div>
                    </td>
                    <td><div id='date2' style='display: none'>
                        <input class='w3-input w3-border w3-round w3-pale-yellow' id='date2range' type='date' name='task_date2' value='$getdate2'/>
                    </div>
                    </td>
                </tr>
                
                <tr>
                    <td></td>
                    <td>
                    <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='get_status_btn' value='Get Status'/>
                    <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='../index2.php' style='text-align:right;'>Go to Dashboard</a>
                    </td>
                </tr>
                </table>
                
                <br>
                <div class='w3-container'>
                <table class='w3-table-all w3-small'>
                <tr>
                <th>Date</th>
                <th>Completed Tasks</th>
                <th>Inprogress/Planned Tasks</th>
                </tr>
                <tr>
                    <td>a</td>
                    <td>b</td>
                    <td>c</td>
                </tr>
                
                </table>
                </div>
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
