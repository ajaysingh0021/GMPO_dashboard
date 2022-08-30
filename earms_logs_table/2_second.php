<!DOCTYPE html>
<html>
	<head>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
	<title>Create Dict</title>
	</head>
	<body>
    
    <form name="2_second" action="3_third.php" method="post">
    <script>
        function goBack() {
            window.history.go(-1);
        }
    </script>
    
<?php
    // Pass all the POST variables
    foreach ($_POST as $key => $value) {
        //print($key . " => " . $value . "<br>");
        print('<input type="hidden" name="' . $key .'" value="' . trim($value) . '"/>');
    }
    
    // Verify all the values passed from previous screen
	$errors = array();
    if (!$_POST['home_textdata']) {
        array_push($errors, "Put output of command: <b>show controllers Odu-Group-Te tid protection-detail</b>");
	}
    if ($errors) {
        print('<table class="table-style-three">');
        print('<tr><th colspan="2">');
        print('<b>ERROR:: Please correct these errors:</b>');
        print('</th></tr>');
        $x = 0;
        foreach ($errors as $error) {
            $x = $x + 1;
            print('<tr><td align="center">' . $x . '.</td>');
            print('<td>' . $error . '</td></tr>');
        }
        print('</table>');
        
        if (($_POST['browser_type'] == 'Chrome') || ($_POST['browser_type'] == 'Firefox')) {
            print('<p><button onclick="goBack()"> < Back </button></p>');
        }
        else {
            print('<br><b>Press BACK button on the browser and try again.</b>');
        }
        exit;
    }
    
    // If there is no error then save the input to the input file
    $input_file_name = 'convert_odu_grp_info_input.txt';
    $text = strip_tags($_POST["home_textdata"]);
    file_put_contents($input_file_name, $text);
?>  
    <div>
	<!-- <table border="1" cellpadding="6" cellspacing="1"> -->
    <table class="table-style-one">
	<tr>
        <th colspan="2" height="30">
        <p class=MsoNormal style='text-align:center'><span
			style='font-size:28.0pt;font-family:US;text-decoration:bold;
			font-weight:bold;language:EN'>
            <img align="left" border="0" alt="STEP1" src="./images/GMPO-logo.png" width="70" height="40">
            Confirm Input
            </span>
			</p>
        </th>
	</tr>
    
    <tr>
        <td>
			<b>Here is your input.</b><br>
			<font size="1"><i>Press the Next button below to see the Formatted Output</i></font>
		</td>
    </tr>
    
    <tr>
        <td>
            <?php
                $file = fopen($input_file_name, "r");
                while(!feof($file)){
                    echo fgets($file). "<br />";
                }
                fclose($file);
            ?>
        </td>
    </tr>
    </table>
    <div>
    
    <!--   Back-Next Button ---->
    <?php
    if (($_POST['browser_type'] == 'Chrome') || ($_POST['browser_type'] == 'Firefox')) {
        print('<p align="left">');
        print('<button onclick="goBack()"> < Back </button>');
        print('&nbsp;&nbsp;');
        print('<input type="submit" id="submit" value="Next >" name="b_nodes_next">');
        print('<p>');
    }
    else {
        print('<p align="left">');
        print('<input type="submit" id="submit" value="Next >" name="b_nodes_next">');
        print('<br>');
        print('<font size="2"><i>Click the above Next button to go to next screen. Use browser\'s back button to return to previous screen if needed</i></font>');
        print('<p>');
    }
    ?>
    
</body>
</html>
