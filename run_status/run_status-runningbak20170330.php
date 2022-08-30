<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
// $userid = $_SESSION['userid'];
// $username = $_SESSION['username'];
?>

<html>
<head>
<link rel="stylesheet" href="../style/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<title>
RunningStatus
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
    $formmessage_part1 = "<br><br>
                          <div class='w3-container'>
                          <div class='w3-card-4' style='width:80%;'>
                          <div class='w3-container w3-teal'>
                          <h2>Message</h2>
                          </div>
                          <div class='w3-container'>";
    $formmessage_part2 = "<br><br></div></div></div>";
    
    if ($_POST['parse_logs_btn']) {
        $getcecuser = trim($_POST['home_cecuser']);
        $getcecpassword = trim($_POST['home_cecpassword']);
        $getjobfilename = trim($_POST['home_jobfilename']);
        $getexecutor = trim($_POST['home_executor']);
        
        $status_updated = false;
        $print_status = false;
        $emsg = '';
        
        
        if (trim($getcecuser)) {
            if (trim($getcecpassword)) {
                if (trim($getjobfilename)) {
                    if (!$getexecutor) {
                        $getexecutor = $getcecuser;
                    }
                    
                    #$pyscript = 'C:\\xampp\\htdocs\\dashboard\\run_status\\ssh_exec_cmd.py';
                    $pyscript = 'ssh_exec_cmd.py';
                    #$python = 'C:\\Python36\\python.exe'; # ==> This should match with the python path of the server-system 
                    $python = 'C:\\Python34\\python.exe';
                    $cmd = "$python $pyscript $getcecuser $getcecpassword \"$getjobfilename\" \"$getexecutor\"";
                    exec($cmd, $output, $ret_val);
                    
                    // print ("Command output:<br>");
                    // print_r($output);
                    // print ("<br>Return Value=");
                    // print($ret_val);
                    
                    $b_error_found = false;
                    $bad_user_pwd_error = "Incorrect username or password";
                    $exec_complete_error = "No such file or directory";
                    foreach ($output as $value) {
                        if (strpos($value, $exec_complete_error)) {
                            $emsg = "Incorrect Job file name or execution is already complete";
                            $b_error_found = true;
                            break;
                        }
                        if (strpos($value, $bad_user_pwd_error)) {
                            $emsg = "Incorrect username/password";
                            $b_error_found = true;
                            break;
                        }
                    }
                    if (!$b_error_found) {
                        #$status_updated = true;
                        $print_status = true;
                    }
                    reset($output);
                }
                else {
                    $emsg = "Please specify the Job file name";
                }
            }
            else {
                $emsg = "Please specify your CEC password";
            }
        }
        else {
            $emsg = "Please specify your CEC user-id";
        }
    }
    
    if ($status_updated) {
        $message = "Logs parsed successfully.";
        echo "$formmessage_part1";
        echo "<br>";
        echo "$message";
        echo "<br>";
        echo "<div class='w3-container'>";
        echo "<br><br>";
        echo "<a href='run_status.php'><img border='0' alt='HOME' src='../images/home-blue.png' width='70' height='70'></a>";
        echo "$formmessage_part2";
        exit();
    }
    else {
        ?>
        <form action='./run_status.php' method='post'>
            <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
                <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>NCS4K Team</h2>
            </div>
            
            
            <div class='w3-card-4' style='width:70%; margin:50 auto;'>
                <div class='w3-container w3-teal'>
                    <h2>Running Tests Status</h2>
                </div>
                
            <table class='w3-container' style="width:70%">
            <tr>
                <td style="width:20%"></td>
                <td><font color='red'><?php echo "$emsg";?></font></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>CEC UserName<br>
                </td>
                <td><input class='w3-input w3-border w3-round w3-pale-yellow' style="width:60%" type="text" name="home_cecuser" value=<?php print($getcecuser)?>><font size="1"><i>Example: gmpoemailid</i></font></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>CEC Password<br>
                </td>
                <td><input class='w3-input w3-border w3-round w3-pale-yellow' style="width:60%" type="password" name="home_cecpassword" value=<?php print($getcecpassword)?>></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>Executor CEC User Name<br>
                </td>
                <td><input class='w3-input w3-border w3-round w3-pale-yellow' style="width:60%" type="text" name="home_executor" value=<?php print($getexecutor)?>><font size="1"><i>Example: somane. If you are the executor, feel free to skip this field</i></font></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>Job File Name<br>
                </td>
                <td><input class='w3-input w3-animate-input w3-border w3-round w3-pale-yellow' style="width:60%" type="text" name="home_jobfilename" value=<?php print($getjobfilename)?>>
                <font size="1"><i>Example: sauron_gmpls_aps_98_regression_job<br>This job should be currently running</i></font>
                </td>
            </tr>
            
            
            <tr>
                <td></td>
                <td>
                <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='parse_logs_btn' value='Get running tests status'/>
                <!-- <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./tasks_bucket.php' style='text-align:right;'>Cancel</a> -->
                </td>
            </tr>
            </table>
            
            </div>
            
            <?php
                if ($print_status) {
                    print("<div class='w3-card-4' style='width:70%; margin:50 auto;'>");
                    print("<br>");
                        // print("<div class='w3-container w3-teal'>");
                            // print("<h2>Output</h2>");
                        // print("</div>");
                        print("<table class='w3-table-all w3-hoverable' style='width:98%; margin:10 auto;'>");
                            print("<tr class='w3-blue'>");
                                print("<th>S.No.</th>");
                                print("<th>Test</th>");
                                print("<th>Status</th>");
                            print("</tr>");
                            
                            // print("<tr>");
                                // print("<td></td>");
                                // print("<td></td>");
                                // print("<td></td>");
                            // print("</tr>");
                            
                            // $arr_count = 0;
                            $sno_count = 0;
                            // reset($output);
                            $tot_arr_items = sizeof($output);
                            foreach ($output as $value) {
                                // if ($arr_count == $tot_arr_items) {
                                    // break;
                                // }
                                // $arr_count = $arr_count + 1;
                                // if ($arr_count < 4) {
                                    // continue;
                                // }
                                $sno_count = $sno_count + 1;
                                $test_stat = explode("is =>",$value);
                                $res_color = '';
                                if (strpos($test_stat[1], 'PASSED')) {
                                    $res_color = 'w3-green';
                                }
                                if (strpos($test_stat[1], 'ERRORED')) {
                                    $res_color = 'w3-red';
                                }
                                if (strpos($test_stat[1], 'FAILED')) {
                                    $res_color = 'w3-orange';
                                }
                                
                                print("<tr>");
                                    print("<td>$sno_count</td>");
                                    print("<td>$test_stat[0]</td>");
                                    print("<td class=$res_color>$test_stat[1]</td>");
                                print("</tr>");
                            }
                        print("<table>");
                    print("</div>");
                }
            ?>
            </form>
            <?php
    }
?>
</body>
</html>
