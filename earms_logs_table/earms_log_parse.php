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
                          <div class='w3-card-4' style='width:80%;'>
                          <div class='w3-container w3-teal'>
                          <h2>Message</h2>
                          </div>
                          <div class='w3-container'>";
    $formmessage_part2 = "<br><br></div></div></div>";
    
    if ($_POST['parse_logs_btn']) {
        $getcecuser = $_POST['home_cecuser'];
        $getcecpassword = $_POST['home_cecpassword'];
        $getresultpath = $_POST['home_resultpath'];
        
        $status_updated = false;
        
        if (trim($getcecuser)) {
            if (trim($getcecpassword)) {
                if (trim($getresultpath)) {
                    $pyscript = 'C:\\xampp\\htdocs\\dashboard\\earms_logs_table\\log_parser_time_status.py';
                    // $python = 'C:\\Python34\\python.exe';
					$python = 'C:\\Python\\python.exe';
                    $cmd = "$python $pyscript $getcecuser $getcecpassword \"$getresultpath\"";
                    exec($cmd, $output, $ret_val);
                    print ("---output -----");
                    print_r($output);
                    print ("---ret_val -----");
                    print($ret_val);
                    
                    $wrong_user_pwd = 'Incorrect user';
                    $wrong_res_path = 'Incorrect result path';
                    $xl_result_str = 'Saved xls file:';
                    $xlfilepath = '';
                    $b_error_found = false;
                    foreach ($output as $value) {
                        //print($value);
                        //print("=-=-=-=-=");
                        if (strpos($value, $wrong_user_pwd) !== false) {
                            # Error String found
                            $emsg = "Incorrect Username or Password specified";
                            $b_error_found = true;
                            break;
                        }
                        elseif (strpos($value, $wrong_res_path) !== false) {
                            # Error String found
                            $emsg = "Incorrect Result Path specified";
                            $b_error_found = true;
                            break;
                        }
                        elseif (strpos($value, $xl_result_str) !== false) {
                            $xlfilepath = explode($xl_result_str,$value)[1];
                            $xlfilepath = trim($xlfilepath);
                            // print("xlfilepath=$xlfilepath");
                            break;
                        }
                    }
                    
                    if (sizeof($output) < 7) {
                        $emsg = "Incorrect result path specified. Path not found.";
                        $b_error_found = true;
                    }
                    if (!$b_error_found) {
                        $status_updated = true;
                    }
                }
                else {
                    $emsg = "Please specify the result path";
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
        $message = "Logs parsed successfully. <br>Download the excel file: $xlfilepath<br>";
        //$xlfilepath = 'log_parser_time_status.xls';
        echo "$formmessage_part1";
        echo "<br>";
        echo "$message";
        echo "<br>";
        echo "<div class='w3-container'>";
        echo "<a href='$xlfilepath' download><img border='0' alt='DOWNLOAD' src='./images/download-red.png' width='200' height='60'></a>";
        
        include('logs_test_time_status.html');
        
        // :::::::: DO NOT DELETE BELOW CODE :::::::::::
        // echo "<hr>";
        // echo "<i>Debug Data: Can be ignored</i>";
        // echo "<font size='1'>";
        // echo "<br>Return Value:$ret_val";
        // echo "<br>Output:";
        // print_r($output);
        // echo "</font>";
        
        echo "<br><br>";
        echo "<a href='earms_log_parse.php'><img border='0' alt='HOME' src='../images/home-blue.png' width='70' height='70'></a>";
        echo "$formmessage_part2";
        exit();
        
    }
    else {
        ?>
        <form action='./earms_log_parse.php' method='post'>
            <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
                <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>NCS4K Team</h2>
            </div>
            
            
            <div class='w3-card-4' style='width:70%; margin:50 auto;'>
                <div class='w3-container w3-teal'>
                    <h2>EARMS Logs Parse Test Time Status</h2>
                </div>
                
            <table class='w3-container' style="width:90%">
            <tr>
                <td style="width:20%"></td>
                <td><font color='red'><?php echo "$emsg";?></font></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>CEC UserName<br>
                </td>
                <td><input class='w3-input w3-border w3-round w3-pale-yellow' style="width:40%" type="text" name="home_cecuser" value=<?php print($getcecuser)?>><font size="1"><i>Example: gmpoemailid</i></font></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>CEC Password<br>
                </td>
                <td><input class='w3-input w3-border w3-round w3-pale-yellow' style="width:40%" type="password" name="home_cecpassword" value=<?php print($getcecpassword)?>></td>
            </tr>
            
            <tr>
                <td class='w3-label w3-text-teal'>Result Log Path<br>
                </td>
                <td><input class='w3-input w3-animate-input w3-border w3-round w3-pale-yellow' style="width:40%" type="text" name="home_resultpath" value=<?php print($getresultpath)?>>
                <font size="1"><i>Example: http://earms-trade.GMPO.com/tradeui/CLResults.jsp?ats=/ws/tpalled-bgl/pyATS/pyats&archive=2017/03/10/17/04/envmon.2017Mar10_17:04:23.zip</i></font>
                </td>
            </tr>
            
            
            <tr>
                <td></td>
                <td>
                <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='parse_logs_btn' value='Get tests time and Status'/>
                <!-- <a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./tasks_bucket.php' style='text-align:right;'>Cancel</a> -->
                </td>
            </tr>
            </table>
            
            </div>
            <br>
            </form>
            <?php
    }
    
?>
</body>
</html>
