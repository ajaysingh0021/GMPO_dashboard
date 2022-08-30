<?php
    session_start();
?>

<?php
function get_browser_name($user_agent) {
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'InternetExplorer';
    
    return 'Other';
}
// Usage:
//echo get_browser_name($_SERVER['HTTP_USER_AGENT']);
$browser_type = get_browser_name($_SERVER['HTTP_USER_AGENT']);
$browser_type = 'Chrome';
?>

<html>
	<head>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
	<title>Create Dict</title>
	</head>
	<body>
	
	<form name="1_home" action="2_second.php" method="post">
    
	<!-- <table border="1" cellpadding="6" cellspacing="1"> -->
    <table class="table-style-one">
	<tr>
    <th colspan="2" height="30"> 
        <p class=MsoNormal style='text-align:center'><span
			style='font-size:28.0pt;font-family:US;text-decoration:bold;
			font-weight:bold;language:EN'>
            <img align="left" border="0" alt="STEP1" src="./images/GMPO-logo.png" width="70" height="40">
            Create Dict
            <br>
            <font size="1"><i>Turn show controllers Odu-Group-Te tid protection-detail output to python dict format</i></font>
            </span>
            
        </p>
    </th>
	</tr>
    
    
    
    <tr>
		<td>
			<b>Log:*</b><br>
			<font size="1"><i>Paste the log containing the command output</i></font><br>
            <font size="1">Command: <b>show controllers Odu-Group-Te tid protection-detail</b></font>
            
		</td>
    </tr>
    <tr>
		<td>
            <textarea rows="20" cols="120" name="home_textdata" ></textarea>
		</td>
	</tr>
	
	</table>
    
	<!--   Submit Button ---->
	<p align="left"><input type="submit" value="Next >" name="b_home_next"></p>
	<p>
        <font size="2"><i>
        For Best experience, use Chrome/Firefox browsers.<br>
        On IE/Safari browsers, use browser back button to return to previous screen.
        </i></font>
    </p>
    
    <?php
        print('<input type="hidden" name="browser_type" value=' . $browser_type . '>');
    ?>
    
	</body>
</html>
