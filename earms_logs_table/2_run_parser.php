<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

$username = $_SESSION['getcecuser'];
$userpwd = $_SESSION['getcecpassword'];
$logpath = $_SESSION['getresultpath'];
?>

<html>
	<head>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
	<title>Parse Logs</title>
	</head>
	<body>
    <script>
        function goBack() {
            window.history.go(-1);
        }
    </script>
    <form name="2_run_parser" action="4_fourth.php" method="post">
    
<?php
    // Pass all POST variables
    foreach ($_POST as $key => $value) {
        print($key . " => " . $value . "<br>");
        print('<input type="hidden" name="' . $key .'" value="' . trim($value) . '"/>');
    }
    
    $output_file_name = 'log_parser_time_status_output.txt';
    
    $pyscript = 'C:\\xampp\\htdocs\\dashboard\\earms_logs_table\\log_parser_time_status.py';
    $python = 'C:\\Python34\\python.exe';
    $cmd = "$python $pyscript $username $userpwd $logpath";
    exec("$cmd", $output);
    

?>

	<!-- <table border="1" cellpadding="6" cellspacing="1"> -->
    <table class="table-style-one">
	<tr>
        <th colspan="2" height="30">
            <p class=MsoNormal style='text-align:center'><span
			style='font-size:28.0pt;font-family:US;text-decoration:bold;
			font-weight:bold;language:EN'>
            <img align="left" border="0" alt="STEP1" src="./images/GMPO-logo.png" width="70" height="40">
            Parsed Logs
            </span>
			</p>
        </th>
	</tr>
    <tr>
        <td>
			<b>Here is the parsed log table</b><br>
			<font size="1"><i>Parsed Log</i></font>
		</td>
    </tr>
    <tr>
        <td>
        
        <?php
            $file_name = "c:\\log_parser_time_status.xls";
            // $file = fopen($output_file_name, "r");
            // while(!feof($file)){
                // echo fgets($file). "<br />";
            // }
            // fclose($file);
        ?>
        <b>Log Filename:</b><i> <?php print($file_name); ?></i>
        <br><br>
        
        <a href="<?php print($file_name); ?>" download><img border="0" alt="DOWNLOAD" src="./images/download-red.png" width="200" height="60"></a>
        
        </td>
    </tr>
    </table>
    
    
    <!--   Home Button ---->
    <br>
    <p align="left">
    <a href="earms_log_parse.php"><img border="0" alt="HOME" src="./images/home-blue.png" width="70" height="70"></a>
    </p>
    
</body>
</html>
