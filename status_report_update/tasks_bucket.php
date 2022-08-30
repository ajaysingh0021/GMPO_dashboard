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
TasksBucket
</title>

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
        if ($_POST['get_tasks_btn']) {
            $getuser = $_POST['dd_user'];
            $getstatus = $_POST['task_status'];
            
            //echo "c = $getuser";
            $no_records_found = false;
            $status_updated = false;
            $emsg = "";
            $administrator = "gmpoemailid@GMPO.com";
            
            // Check if user already exist in DB
            require("../login/connect.php");
            $db_to_use = "tasks_bucket";
            
            $where_string = '';
            if ($getstatus != 'ALL') {
                $where_string = "status='$getstatus'";
            }
            
            $base_query_str = "SELECT * FROM $db_to_use";
            $query_str = "";
            if ($getuser == 'ALL') {
                if ($getstatus != 'ALL') {
                    $query_str = $base_query_str . " WHERE status='$getstatus'";
                }
                else {
                    $query_str = $base_query_str;
                }
            }
            else {
                $query_str = $base_query_str . " WHERE engg_name='$getuser'";
                if ($getstatus != 'ALL') {
                    $query_str = $query_str . " AND status='$getstatus'";
                }
            }
            $stmt = $db->query($query_str);
            $row_count = $stmt->rowCount();
            if ($row_count > 0) {
                $rows_tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //print_r($rows_tasks);
            }
            else {
                //echo "No records found!!";
                $no_records_found = true;
            }
            
            // Destroy the DB object
            $db->null;
        }
        
        if ($status_updated) {
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
            #echo $form;
            ?>
            <form action='./tasks_bucket.php' method='post'>
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
                        <h2>Project Tasks</h2>
                    </div>
                    
                <table class='w3-container w3-padding-8'>
                <tr>
                    <td></td>
                    <td><font color='red'><?php echo "$emsg";?></font></td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Show tasks for team-member</td>
                    <td>
                    <!-- Drop down containing all the users & ALL -->
                    <?php
                        require("../login/connect.php");
                        $stmt = $db->query("SELECT username FROM users");
                        $row_count = $stmt->rowCount();
                        //echo "$row_count";
                        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        //print('<select id="dd_username_id" name="dd_username" onchange="myPutTgenName(this)">'");
                        echo "<select class='w3-select w3-border w3-round w3-pale-yellow' id='dd_user_id' name='dd_user'>";
                        echo "<option value='$getuser'>$getuser</option>";
                        foreach ($rows as $name) {
                            if ($name != $getuser) {
                                echo "<option value='$name'>$name</option>";
                            }
                        }
                        echo "<option value='ALL'>All Users</option>";
                        echo '</select>';
                        
                        // Destroy the DB object
                        $db->null;
                    ?>
                    
                    </td>
                </tr>
                
                <tr>
                    <td class='w3-label w3-text-teal'>Show tasks with Status</td>
                    
                    <td>
                        <input class="w3-radio" type="radio" name="task_status" value="ALL" checked>
                        <label class="w3-validate">All</label>

                        <input class="w3-radio" type="radio" name="task_status" value="New">
                        <label class="w3-validate">New</label>
                        
                        <input class="w3-radio" type="radio" name="task_status" value="In-progress">
                        <label class="w3-validate">In-progress</label>
                        
                        <input class="w3-radio" type="radio" name="task_status" value="Completed">
                        <label class="w3-validate">Completed</label>
                        
                        
                        <input class="w3-radio" type="radio" name="task_status" value="Blocked">
                        <label class="w3-validate">Blocked</label>
                        
                        <input class="w3-radio" type="radio" name="task_status" value="Deferred">
                        <label class="w3-validate">Deferred</label>
                        
                        <input class="w3-radio" type="radio" name="task_status" value="Other">
                        <label class="w3-validate">Other</label>
                        
                        <!--
                        <select class='w3-select w3-border w3-round w3-pale-yellow' name='task_status'>
                        
                        $status_options = array('ALL', 'New', 'In-progress', 'Completed', 'Blocked', 'Deferred', 'Other');
                        foreach ($status_options as $ddoptions) {
                            echo "<option value='$ddoptions'>$ddoptions</option>";
                        }
                        
                        </select>
                        -->
                    </td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td></td>
                    <td>
                    <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='get_tasks_btn' value='Show Tasks'/>
                    <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='../index2.php' style='text-align:right;'>Go to Dashboard</a>
                    </td>
                </tr>
                </table>
                
                <br>
                <div class='w3-container'>
                <table class='w3-table-all w3-small' style='width:100%'>
                <tr>
                <th>Name</th>
                <th>Task Title</th>
                <th width="100px">Start Date</th>
                <th width="100px">Planned End Date</th>
                <th width="100px">Actual End Date</th>
                <th width="85px">Status</th>
                <th>Comments</th>
                <th>Edit Row Data</th>
                </tr>
                <?php
                    if ($rows_tasks) {
                        //print_r($rows_tasks);
                        $arrlength = count($rows_tasks);
                        for($x = 0; $x < $arrlength; $x++) {
                            $aarray = $rows_tasks[$x];
                            echo "<tr>";
                            echo "<td>" . $aarray['engg_name'] . "</td>";
                            echo "<td>" . $aarray['task_title'] . "</td>";
                            echo "<td>" . $aarray['start_date'] . "</td>";
                            echo "<td>" . $aarray['end_date'] . "</td>";
                            
                            if ($aarray['actual_end_date'] == "0000-00-00") {
                                $actual_end_date = "-";
                            }
                            else {
                                $actual_end_date = $aarray['actual_end_date'];
                            }
                            echo "<td>" . $actual_end_date . "</td>";
                            echo "<td>" . $aarray['status'] . "</td>";
                            echo "<td>" . $aarray['comments'] . "</td>";
                            $data_db_sno = $aarray['sno'];
                            //$_SESSION['data_db_sno'] = $aarray['sno'];
                            echo "<td>" . "<a class='w3-text-blue' href='modify_task.php?data_db_sno=$data_db_sno'>Click to modify</a>" . "</td>";
                            echo "</tr>";
                        }
                    }
                    //Array ( [0] => Array ( [sno] => 1 [engg_name] => gmpoemailid [task_title] => Create a dashboard for the project [start_date] => 2017-01-27 [end_date] => 2017-01-31 [status] => In-progress [comments] => In-progress ) )
                ?>
                </table>
                <?php
                    if ($arrlength) {
                        echo "Found $arrlength record(s).<br>";
                    }
                    else {
                        echo "<tr>";
                        if ($no_records_found) {
                            echo "<td col_span='7'>No records found!!</td>";
                            $no_records_found = false;
                        }
                        else {
                            echo "<td col_span='7'>Click show tasks</td>";
                        }
                        echo "</tr>";
                    }
                ?>
                <br><br>
                <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='./add_new_task.php' style='text-align:right;'>Add New Task</a>
                </div>
                <br>
                </div>
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
