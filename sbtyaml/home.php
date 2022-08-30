
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
	<title>SBT YAML Creator</title>
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
            SBT YAML Creator
            <a href="help.html" target="_blank"><img align="right" border="0" alt="HELP" src="./images/help-icon-ball-green.png" width="30" height="30"></a>
            </span>
            <br><img border="0" alt="STEP1" src="./images/step1.png" width="500" height="70">
        </p>
    </th>
	</tr>
    
    <tr>
		<td>
			<b>Number of Nodes:*</b><br>
			<font size="1"><i>Specify the number of nodes present in the topology for which yaml is being created</i></font>
		</td>
		<td>
            <input type="text" name="home_nodes">
		</td>
	</tr>
	
    <tr>
		<td>
			<b>Number of Tgens:*</b><br>
			<font size="1"><i>Specify the number of traffic generators present in the topology for which yaml is being created</i></font>
		</td>
		<td>
                <input type="text" name="home_tgens">
		</td>
	</tr>
    
    <tr>
		<td>
			<b>Project Name:</b><br>
			<font size="1"><i>Specify the project name (Default: GMPO)</i></font>
		</td>
		<td>
                <input type="text" name="home_projectname">
		</td>
	</tr>
    
    <tr>
		<td>
			<b>Project Alias:</b><br>
			<font size="1"><i>Specify the project alias (Default: NCS4K)</i></font>
		</td>
		<td>
                <input type="text" name="home_projectalias">
		</td>
	</tr>
    
    <tr>
		<td>
			<b>Owner Name:</b><br>
			<font size="1"><i>Specify the name of the owner for the YAML (Default: gmpo admin)</i></font>
		</td>
		<td>
                <input type="text" name="home_ownername">
		</td>
	</tr>
    
    <tr>
		<td>
			<b>Owner Email:</b><br>
			<font size="1"><i>Specify the email of the owner of the yaml (Default: gmpoemailid@GMPO.com)</i></font>
		</td>
		<td>
                <input type="text" name="home_owneremail">
		</td>
	</tr>
	</table>
    
	<!--   Submit Button ---->
	<p align="left">
    <input type="submit" value="Next >" name="b_home_next">
    </p>
    
	<p>
        <font size="2"><i>
        For Best experience, use Chrome/Firefox browsers.<br>
        On IE/Safari browsers, use browser back button to return to previous screen.
        </i></font>
    </p>
    
    <?php
        print('<input type="hidden" name="browser_type" value=' . $browser_type . '>');
    ?>
 </div>

<div id="rightdiv" style="float:right; width:25%; height:90%; background-color:#FEF9E7; border-radius: 25px;">
    <br>
    <h4>&nbsp;The SBT YAML Creator supports:</h4>
    <ul><font size="2">
    <li> Setup with 1 Node & 1 Tgen</li></font>
    </ul>
    <h4>&nbsp;Use below links for other setups:</h4>
    <ul><font size="2">
    <li> <a href="../yaml/home.php" target="_blank"> Normal YAML creator </a></li>
    <li> <a href="./home.php" target="_blank"> Setup with Loopback ports </a></li>
    <li> <a href="./home.php" target="_blank"> Setup with PRBS Simulator </a></li></font>
    </ul>
</div>


	</body>
</html>
