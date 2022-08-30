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
ModifyTask
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
        $getsno = $_GET['data_db_sno'];
        $getsavebtn = $_POST['update_db_btn'];
        $b_success = false;
        #echo "getsavebtn=$getsavebtn";
        if ($getsavebtn) {
            // Check if info is provided
            $get_current_sno = $_POST['current_sno'];;
            $get_current_engg_name = $_POST['current_engg_name'];;
            $get_current_task_title = $_POST['current_task_title'];
            $get_current_start_date = $_POST['current_start_date'];
            $get_current_end_date = $_POST['current_end_date'];
            $get_current_actual_end_date = $_POST['current_actual_end_date'];
            $get_current_status = $_POST['current_status'];
            $get_current_comments = $_POST['current_comments'];
            //echo "get_current_actual_end_date = --$get_current_actual_end_date--";
            $b_failure_flag = false;
            if (trim($get_current_task_title)) {
                if ($get_current_status == "Completed" && trim($get_current_actual_end_date) == "") {
                    $emsg = "For completed task, please specify an end date";
                    $b_failure_flag = true;
                }
                if (!$b_failure_flag) {
                    require("../login/connect.php");
                    $db_to_use = "tasks_bucket";
                    
                    $stmt = $db->query("SELECT * FROM $db_to_use WHERE sno='$get_current_sno'");
                    $row_count = $stmt->rowCount();
                    if ($row_count == 1) {
                        #echo "Updating DB...";
                        $db->query("UPDATE $db_to_use SET 
                                    engg_name='$get_current_engg_name',  
                                    task_title='$get_current_task_title', 
                                    start_date='$get_current_start_date', 
                                    end_date='$get_current_end_date', 
                                    actual_end_date='$get_current_actual_end_date', 
                                    status='$get_current_status', 
                                    comments='$get_current_comments' 
                                    WHERE sno='$get_current_sno'");
                        $b_success = true;
                        #echo "Updated DB.";
                    }
                }
            }
            else {
                $emsg = "Task title can not be blank. Please specify a proper task title";
            }
        }
        
        if (!$b_success) {
            if (!$getsno) {
                if ($get_current_sno) {
                    $getsno = $get_current_sno;
                }
            }
            if ($getsno) {
                //$getuser = $_POST['dd_user'];
                $status_updated = false;
                //$emsg = "";
                $administrator = "gmpoemailid@GMPO.com";
                //echo "Modifying Task: $getsno";
                // Check if user already exist in DB
                require("../login/connect.php");
                $db_to_use = "tasks_bucket";
                $stmt = $db->query("SELECT * FROM $db_to_use WHERE sno='$getsno'");
                $row_count = $stmt->rowCount();
                if ($row_count == 1) {
                    $rows_tasks = $stmt->fetch(PDO::FETCH_ASSOC);
                    //print_r($rows_tasks);
                }
                else {
                    echo "Many sno found";
                }
                
                // Destroy the DB object
                $db->null;
            }
            else {
                echo "SNO of the task not provided. Please try again.";
            }
        }
        
        if ($b_success) {
            $message = "Success. Task updated.<br>";
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
            echo "<th>Actual End Date</th>";
            echo "<th>Status</th>";
            echo "<th>Comments</th>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td>$get_current_engg_name</td>";
            echo "<td>$get_current_task_title</td>";
            echo "<td>$get_current_actual_start_date</td>";
            echo "<td>$get_current_end_date</td>";
            echo "<td>$get_current_actual_end_date</td>";
            echo "<td>$get_current_status</td>";
            echo "<td>$get_current_comments</td>";
            echo "</tr>";
            
            echo "</table>";
            echo "<br>";
            echo "<a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='./tasks_bucket.php' style='text-align:right;'>Go to View Status Page</a>";
            
            echo "$formmessage_part2";
            exit();
        }
        else {
            #echo $form;
            ?>
                <form action='./modify_task.php' method='post'>
                <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
                    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>NCS4K Team</h2>
                </div>
                
                <div class='w3-container'>
                <div class='w3-display-container'>
                <div class='w3-display-topleft'>Welcome <b><?php echo "$username";?></b></div>
                <div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='../login/logout.php' style='text-align:right;'>Logout</a></div>
                </div></div>
        
                <div class='w3-card-4' style='width:90%; margin:50 auto;'>
                    <div class='w3-container w3-teal'>
                        <h2>Modify Task</h2>
                    </div>
                
                <div class='w3-container'>
                <br>
                <div>
                <font color='red'><?php echo "$emsg";?></font>
                </div>
                <table class='w3-table-all w3-small' style='width:90%;'>
                <tr>
                <th>Name</th>
                <th>Task Title</th>
                <th>Start Date</th>
                <th>Planned End Date</th>
                <th>Actual End Date</th>
                <th>Status</th>
                <th>Comments</th>
                
                </tr>
                <?php
                    if ($rows_tasks) {
                        // print_r($rows_tasks);
                        // Only 1 row will be there
                        $current_sno = $rows_tasks['sno'];
                        $current_engg_name = $rows_tasks['engg_name'];
                        $current_task_title = $rows_tasks['task_title'];
                        $current_start_date = $rows_tasks['start_date'];
                        $current_end_date = $rows_tasks['end_date'];
                        $current_actual_end_date = $rows_tasks['actual_end_date'];
                        $current_status = $rows_tasks['status'];
                        $current_comments = $rows_tasks['comments'];
                        
                        echo "<tr>";
                        require("../login/connect.php");
                        $stmt = $db->query("SELECT username FROM users");
                        $row_count = $stmt->rowCount();
                        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        echo "<td width='130px'><select class='w3-select w3-border w3-round w3-pale-yellow' id='current_engg_name_id' name='current_engg_name'>";
                        echo "<option value='$current_engg_name'>$current_engg_name</option>";
                        foreach ($rows as $name) {
                            if ($name != $current_engg_name) {
                                echo "<option value='$name'>$name</option>";
                            }
                        }
                        echo "</select>";
                        
                        // Destroy the DB object
                        $db->null;
                        echo "<input type='hidden' name='current_sno' value='$current_sno'>";
                        
                        echo "</td>";
                        echo "<td><textarea class='textarea w3-input w3-border w3-round w3-pale-yellow' name='current_task_title' type='text' cols='40' rows='2'>$current_task_title</textarea></td>";
                        
                        echo "<td><input class='w3-input w3-border w3-round w3-pale-yellow' id='current_start_date_id' type='date' name='current_start_date' value='$current_start_date'/></td>";
                        echo "<td><input class='w3-input w3-border w3-round w3-pale-yellow' id='current_end_date_id' type='date' name='current_end_date' value='$current_end_date'/></td>";
                        echo "<td><input class='w3-input w3-border w3-round w3-pale-yellow' id='current_actual_end_date_id' type='date' name='current_actual_end_date' value='$current_actual_end_date'/></td>";
                        
                        echo "<td width='130px'><select class='w3-select w3-border w3-round w3-pale-yellow' id='current_status_id' name='current_status'>";
                        echo "<option value='$current_status'>$current_status</option>";
                        $status_options = array('New', 'In-progress', 'Completed', 'Blocked', 'Deferred', 'Other');
                        foreach ($status_options as $ddoptions) {
                            if ($ddoptions != $current_status) {
                                echo "<option value='$ddoptions'>$ddoptions</option>";
                            }
                        }
                        echo '</select>';
                        
                        echo "<td><textarea class='textarea w3-input w3-border w3-round w3-pale-yellow' name='current_comments' type='text' cols='40' rows='3'>$current_comments</textarea></td>";
                        echo "</tr>";
                        
                    }
                    
                ?>
                </table>
                <br>
                <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='update_db_btn' value='Save'/>
                <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./tasks_bucket.php' style='text-align:right;'>Cancel</a>
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
