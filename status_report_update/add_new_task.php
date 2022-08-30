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
AddAssignNewTask
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
    $formmessage_part1 = "<br><br>
                          <div class='w3-container'>
                          <div class='w3-card-4'>
                          <div class='w3-container w3-teal'>
                          <h2>Message</h2>
                          </div>
                          <div class='w3-container'>";
    $formmessage_part2 = "<br><br></div></div></div>";
    
    $getuser = $username;
    if ($username && $userid) {
        if ($_POST['add_task_btn']) {
            $getuser = $_POST['task_user'];
            $gettitle = $_POST['task_title'];
            $getstartdate = $_POST['task_start_date'];
            $getenddate = $_POST['task_end_date'];
            $getstatus = $_POST['task_status'];
            $getcomments = $_POST['task_comments'];
            $status_updated = false;
            
            if ($getuser) {
                if ($gettitle) {
                    require("../login/connect.php");
                    $db_to_use = "tasks_bucket";
                    // Insert the status in DB
                    $db->query("INSERT INTO $db_to_use VALUES ('', '$getuser', '$gettitle', '$getstartdate', '$getenddate', '', '$getstatus', '$getcomments')");
                    // Verify that DB is updated
                    $stmt = $db->query("SELECT * FROM $db_to_use WHERE engg_name='$getuser' AND task_title='$gettitle'");
                    $row_count = $stmt->rowCount();
                    
                    if ($row_count == 1) {
                        $status_updated = true;
                    }
                    else {
                        $emsg = "Some error occurred while adding new task";
                    }
                    // Destroy the DB object
                    $db->null;
                }
                else {
                    $emsg = "Please specify the Task title";
                }
            }
            else {
                $emsg = "Please select a team member";
            }
        }
        
        if ($status_updated) {
            $message = "Success!! New task added and assigned.<br>";
            echo "$formmessage_part1";
            echo "<br>";
            echo "$message";
            echo "<br>";
            echo "<div class='w3-container'>";
            echo "<table class='w3-table-all w3-small'>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Task Title</th>";
            echo "<th>Start Date</th>";
            echo "<th>Planned End Date</th>";
            echo "<th>Status</th>";
            echo "<th>Comments</th>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td>$getuser</td>";
            echo "<td>$gettitle</td>";
            echo "<td>$getstartdate</td>";
            echo "<td>$getenddate</td>";
            echo "<td>$getstatus</td>";
            echo "<td>$getcomments</td>";
            echo "</tr>";
            
            echo "</table>";
            echo "<br>";
            echo "<a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='./tasks_bucket.php' style='text-align:right;'>Go to View Status Page</a>";
            echo "&nbsp;&nbsp;&nbsp;";
            echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./add_new_task.php' style='text-align:right;'>Add New Task</a>";
            
            echo "$formmessage_part2";
            exit();
        }
        else {
            ?>
            <form action='./add_new_task.php' method='post'>
                <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
                    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>NCS4K Team</h2>
                </div>
                
                <div class='w3-container'>
                <div class='w3-display-container'>
                <div class='w3-display-topleft'>Welcome <b><?php echo "$username";?></b></div>
                <div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='../login/logout.php' style='text-align:right;'>Logout</a></div>
                </div></div>
        
                <div class='w3-card-4' style='width:70%; margin:50 auto;'>
                    <div class='w3-container w3-teal'>
                        <h2>Add/Assign New Task</h2>
                    </div>
                    
                <table class='w3-container'>
                <tr>
                    <td></td>
                    <td><font color='red'><?php echo "$emsg";?></font></td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Task for team-member</td>
                    <td>
                    <!-- Drop down containing all the users & ALL -->
                    <?php
                        require("../login/connect.php");
                        $stmt = $db->query("SELECT username FROM users");
                        $row_count = $stmt->rowCount();
                        //echo "$row_count";
                        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        //print('<select id="dd_username_id" name="dd_username" onchange="myPutTgenName(this)">'");
                        echo "<select class='w3-select w3-border w3-round w3-pale-yellow' id='task_user_id' name='task_user'>";
                        echo "<option value='$getuser'>$getuser</option>";
                        foreach ($rows as $name) {
                            if ($name != $getuser) {
                                echo "<option value='$name'>$name</option>";
                            }
                        }
                        echo '</select>';
                        
                        // Destroy the DB object
                        $db->null;
                    ?>
                    
                    </td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Task Title</td>
                    <td><input class='w3-input w3-border w3-round w3-pale-yellow' type="text" name="task_title"></td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Start Date</td>
                    <td><input class='w3-input w3-border w3-round w3-pale-yellow' type='date' name='task_start_date'/></td>
                    
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Planned End Date</td>
                    <td><input class='w3-input w3-border w3-round w3-pale-yellow' type='date' name='task_end_date'/></td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Status</td>
                    <td>
                        <select class='w3-select w3-border w3-round w3-pale-yellow' name='task_status'>
                        <?php
                        $status_options = array('New', 'In-progress', 'Completed', 'Blocked', 'Deferred', 'Other');
                        foreach ($status_options as $ddoptions) {
                            echo "<option value='$ddoptions'>$ddoptions</option>";
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Comments</td>
                    <td><textarea class='textarea w3-input w3-border w3-round w3-pale-yellow' name='task_comments' type='text' cols='40' rows='2'></textarea></td>
                </tr>
                
                
                <tr>
                    <td></td>
                    <td>
                    <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='add_task_btn' value='Add/Assign Task'/>
                    <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./tasks_bucket.php' style='text-align:right;'>Cancel</a>
                    </td>
                </tr>
                </table>
                
                </div>
                <br>
                </form>
                <?php
        }
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
