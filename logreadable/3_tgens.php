<html>
	<head>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
	<title>YAML Creator</title>
	</head>
	<body>
    <script>
        function goBack() {
            window.history.go(-1);
        }
    </script>
    <form name="3_tgens" action="4_connections.php" method="post">
    
<?php
    // Pass all POST variables
    foreach ($_POST as $key => $value) {
        //print($key . " => " . $value . "<br>");
        print('<input type="hidden" name="' . $key .'" value="' . trim($value) . '"/>');
    }
    
    $output_file_name = 'extract_odu_grp_info_output.txt';
    
    $pyscript = 'C:\\xampp\\htdocs\\dashboard\\logreadable\\extract_odu_grp_info.py';
    $python = 'C:\\Python34\\python.exe';
    $cmd = "$python $pyscript";
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
            Formatted Log
            </span>
			</p>
        </th>
	</tr>
    <tr>
        <td>
			<b>Here is the formatted log</b><br>
			<font size="1"><i>Formatted Log</i></font>
		</td>
    </tr>
    <tr>
        <td>
        <?php
            $file = fopen($output_file_name, "r");
            while(!feof($file)){
                echo fgets($file). "<br />";
            }
            fclose($file);
        ?>
        </td>
    </tr>
    </table>
    
</body>
</html>
