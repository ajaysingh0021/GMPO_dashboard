
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
$browser_type = 'Chrome';
$browser_type = get_browser_name($_SERVER['HTTP_USER_AGENT']);
?>

<html>
	<head>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
	<title>Update Status</title>
	</head>
	<body>
	
	<form name="1_home" action="2_nodes.php" method="post">


<div id="leftdiv" style="float:left; width:75%; height:100%;">
    
	<!-- <table border="1" cellpadding="6" cellspacing="1"> -->
    <table class="table-style-one">
	<tr>
    <th colspan="2" height="30"> 
        <p class=MsoNormal style='text-align:center'><span
			style='font-size:28.0pt;font-family:US;text-decoration:bold;
			font-weight:bold;language:EN'>
            <img align="left" border="0" alt="STEP1" src="./images/GMPO-logo.png" width="70" height="40">
            Update Status
            <a href="help.html" target="_blank"><img align="right" border="0" alt="HELP" src="./images/help-icon-ball-green.png" width="30" height="30"></a>
            </span>
            <br><br>
        </p>
    </th>
	</tr>
    
    <tr>
		<td>
			<b>Select the date:*</b><br>
			<font size="1"><i>Date for which you want to update status</i></font>
		</td>
		<td>
            <input type="date" name="report_date">
		</td>
	</tr>
	
    <tr>
		<td>
			<b>Completed Tasks:*</b><br>
			<font size="1"><i>Specify the tasks which you completed on this day</i></font>
		</td>
		<td>
            <textarea name="task_completed" cols="40" rows="5"></textarea>
		</td>
	</tr>
    
    <tr>
		<td>
			<b>Inprogress/Planned Tasks:</b><br>
			<font size="1"><i>Specify the tasks which are in progress or planned for the day</i></font>
		</td>
		<td>
                <textarea name="task_inprogress" cols="40" rows="5"></textarea>
                
		</td>
	</tr>
    
    
	</tr>
	</table>
    
	<!--   Submit Button ---->
	<p align="left">
    <input type="submit" value="Next >" name="b_home_next">
    </p>
    
	<p>
        <font size="2"><i>
        For Best experience, use Google Chrome browser.<br>
        On IE/Firefox/Safari browsers, use browser back button to return to previous screen.
        </i></font>
    </p>
    
    <?php
        print('<input type="hidden" name="browser_type" value=' . $browser_type . '>');
    ?>
 </div>

<div id="rightdiv" style="float:right; width:15%; height:90%; background-color:#FEF9E7; border-radius: 25px;">
    <br>
    <h4>&nbsp;The Update Status:</h4>
    <ul><font size="2">
    <li> Update your daily status</li>
    </font>
    </ul>
</div>


	</body>
</html>
