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
	<title>Convert Dict</title>
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
            Convert Dict
            <br>
            <font size="1"><i>Converts the dict format of the output of 'show controllers Odu-Group-Te tid protection-detail' to Human Readable format</i></font>
            </span>
            
        </p>
    </th>
	</tr>
    
    
    
    <tr>
		<td>
			<b>Log:*</b><br>
			<font size="1"><i>Paste the dict from the db_file</i></font><br>
            <font size="1"><b>Example: </b>restore_revertive_BIDIR-APS_AND_restore_revertive_BIDIR-APS_t1_src_before_lockout = {'local_request_state': 'No Request State', 'local_request_signal': '0', 'local_bridge_signal': '1', 'local_bridge_status': '1+1', 'remote_request_state': 'No Request State', 'remote_request_signal': '0', 'remote_bridge_signal': '1', 'remote_bridge_status': '1+1', 'working_controller_name': 'ODU20_3_0_0_32', 'working_odu_state': 'Active', 'working_local_failure': 'State Ok', 'working_remote_failure': 'Not Applicable', 'working_wtr_left': '0', 'protect_controller_name': 'ODU20_3_0_1_32', 'protect_odu_state': 'Active_tx', 'protect_local_failure': 'State Ok', 'protect_remote_failure': 'Not Applicable', 'protect_wtr_left': '0', 'client_controller_name': 'ODU20_0_0_8_4', 'client_odu_state': 'Active', 'wait_to_restore': '300000', 'hold-off-timer': '0', 'current_state': 'No Request State', 'previous_state': 'Signal Failed on Protecting'}</font>
            
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
