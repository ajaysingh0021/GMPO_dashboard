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
    <link rel="stylesheet" href="../style/w3.css">
	<title>earms_logs_table</title>
	</head>
	<body>
	
	<form class='w3-container' name="1_home" action="2_second.php" method="post">
    <p>
    <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
        <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>NCS4K Team</h2>
    </div>
    <div class='w3-card-4' style='width:90%;margin:50 auto;'>
        <div class='w3-container w3-teal'>
            <h2>EARMS Logs Parse Test Time Status</h2>
        </div>
        
        <table class='w3-container w3-padding-8'>
    
	<!-- <table border="1" cellpadding="6" cellspacing="1"> -->
    <!-- <table class="table-style-one"> 
	<tr>
    <th colspan="2" height="30"> 
        <p class=MsoNormal style='text-align:center'><span
			style='font-size:28.0pt;font-family:US;text-decoration:bold;
			font-weight:bold;language:EN'>
            <img align="left" border="0" alt="STEP1" src="./images/GMPO-logo.png" width="70" height="40">
            EARMS Logs Parse Test Time Status
            <br>
            <font size="1"><i>Parses the log file and present a table for it</i></font>
            </span>
            
        </p>
    </th>
	</tr>
    -->
    
    
    <tr>
		<td>
			<b>CEC UserName:*</b><br>
			<font size="1"><i>Specify your CEC Userid e.g. gmpoemailid</i></font><br>
		</td>
        <td>
            <input type="text" name="home_cecuser">
		</td>
        
    </tr>
    
    <tr>
		<td>
			<b>CEC Password:*</b><br>
			<font size="1"><i>Specify your CEC User Password</i></font><br>
		</td>
        <td>
            <input type="password" name="home_cecpassword">
		</td>
        
    </tr>
    
    <tr>
		<td>
			<b>Result Log Path:*</b><br>
			<font size="1"><i>Example: <br>http://earms-trade.GMPO.com/tradeui/CLResults.jsp?ats=/ws/tpalled-bgl/pyATS/<br>pyats&archive=2017/03/10/17/04/envmon.2017Mar10_17:04:23.zip</i></font><br>
		</td>
        <td>
            <input type="text" name="home_resultpath">
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
