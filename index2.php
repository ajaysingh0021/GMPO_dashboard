<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="./style/w3.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ScapaAutomationQuickLinks</title>
<link rel="shortcut icon" href="./favicon.png" type="image/png">
<style type="text/css">
table,body {
   text-align:center;
   font-family: verdana;
   font-size: 10px;
}
table {
   border-collapse:collapse;
   padding: 5px;
   font-size: inherit;
   font-size: 1.1em;
   width: 90%; 
   height=80%;
}
td {
  font-size: inherit;
  font-size: 1.2em;
  margin-right: 5px;
  text-align: center;
  padding: 5px;
  white-space:nowrap;
  vertical-align:middle;
}
.head {
  background-color: #3566B7;
  color: #FFFFFF;
  padding: 0.01px;
}

.linkclasslabel {
  white-space: nowrap;
  font-weight: bold;
  text-align: left;
  vertical-align:middle;
  padding: 0px;
  margin: 0px;
  font-size: 1.4em;
  background-color: #ddeeff;
  
}
.spacer {
  height: 10px;
  background-color: #ffffff;
  
  colspan: 6;
}
.linklist {
  font-size: inherit;
  font-size: 1em;
  text-align: left;
  background-color: #f0f4ff;
  vertical-align: middle;
  border: 0px dashed #ff0000;
  margin:0;
  white-space:nowrap
  
}
img {
   border:0px;
   margin-right:20px;
   width: 63px;
   height: 60px;
}
a {
  text-decoration: none;
  font-weight: bold;
  color: #202070;
}
li {
  margin-top: 2px;
  white-space:nowrap;
}
h3 {
  text-align: center;
  width: 100%;
  display: block;
  color:#b00000;
}
ul {
  margin:0;
  padding-left: 5px;
  margin-left: 5px;
  list-style-type: square;
}
.sectiontitle {
   color: #202070;
   display:block;
   vertical-align:middle;
   padding:20px 0 0 10px;
   float:middle;
}
.style6 {
	background-color: #3566B7;
	color: #FFFFFF;
	padding: 0.01px;
	font-family: Arial, Helvetica, sans-serif;
}
.images {
	width: 63;
	height: 60;
}
.imx {
    width: 60px;
    height: 40px;
}
.style8 {font-weight: bold}
</style>

</head>

<body>
<?php
    $formmessage_part1 = "<br><br>
                          <div class='w3-container'>
                          <div class='w3-card-4'>
                          <div class='w3-container w3-teal'>
                          <h2>Message</h2>
                          </div>
                          <div class='w3-container'>
                          <br>";
    $formmessage_part2 = "<br><br></div></div></div>";
    
    if (!($username && $userid)) {
        echo "$formmessage_part1";
        $main_form_msg = "<h3>You are not logged-in. Please login to get access to this page.<h3>";
        echo "$main_form_msg";
        echo "<a class='w3-btn w3-round w3-brown w3-padding-small w3-hover-green' href='./login.php'>Login here</a>";
        echo "$formmessage_part2";
        exit;
    }
?>
<center>

<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>              
    <h2><img class="imx" align='left' border='0' alt='GMPO' src='./images/GMPO-logo.png' width='70' height='40'>Quick Links for NCS4K Team Tools</h2>
</div>

<?php
    // Code to display top Welcome User bar
    $top_bar = "<div class='w3-container'>
                <div class='w3-display-container' style='width:95%;'>
                <h6>
                <div class='w3-display-topright'>Welcome <b>$username&nbsp;&nbsp;</b>
                
                <div class='w3-dropdown-hover'>
                <img src='./images/profile.png' alt='More' style='width:50%;height:50%'>
                <div class='w3-dropdown-content w3-border'>
                <a href='./login/member.php'>Profile</a>
                <a href='./login/changepwd.php'>Change Password</a>
                <a href='./login/logout.php'>Logout</a>
                </div>
                </div>
                </div>
                </h6>
                </div></div>";

    echo $top_bar;
    // // Code to display top Welcome User bar
    // echo "<div class='w3-container'>";
    // echo "<div class='w3-display-container' style='width:95%;'>";
    // echo "<h6>";
    // //echo "<div class='w3-display-topleft'>Welcome <b>$username&nbsp;&nbsp;</b>";
    // echo "<div class='w3-display-topright'>Welcome <b>$username&nbsp;&nbsp;</b>";
    
    // echo "<div class='w3-dropdown-hover'>";
    // //echo "<button class='w3-btn w3-round w3-teal w3-padding-small'>More</button>";
    // echo "<img src='./images/profile.png' alt='More' style='width:50%;height:50%'>";
    // //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    
    // echo "<div class='w3-dropdown-content w3-border'>";
    // echo "<a href='./login/member.php'>Profile</a>";
    // echo "<a href='./login/changepwd.php'>Change Password</a>";
    // echo "<a href='./login/logout.php'>Logout</a>";
    // echo "</div>";
    // echo "</div>";
    
    // echo "</div>";
    
    // //echo "<div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green' href='./login/logout.php' style='text-align:right;'>Logout</a></div>";
    // echo "</h6>";
    // echo "</div></div>";
?>


        
        
<table border="0">
	
	<!--   Heading ---->
	<tr>
		<td colspan=6 style="vertical-align:center;">
			<h3>NCS4K Team Dashboard</h3>
		</td>
	</tr>
	
	
	
	
	<!--   Row : 1 ---->
	<tr>
        <!--
		<td class="linkclasslabel"><div align="center"><img src="images/qq.png" alt="Quality_Quotient"/></div></td>
		<td class="linklist"><div align="center"><a href="under-construction.html" target="_blank">Quality Quotient Results</a></div></td>
		
		<td>&nbsp;</td>
		-->
		<td class="linkclasslabel"><div align="center"><img src="images/mat-os-hw.png" alt="YAML-Creator"/></div></td>
		<td class="linklist"><div align="center"><a href="yaml/home.php" target="_blank">YAML Creator</a></div></td>
        <td>&nbsp;&nbsp;</td>
        <td class="linkclasslabel"><div align="center"><img src="images/qq.png" alt="Log_Readable"/></div></td>
		<td class="linklist"><div align="center"><a href="logreadable/home.php" target="_blank">Log Readable</a></div></td>
	</tr>
    <tr>
		<td class="spacer"></td>
	</tr>
    
    <!--   Row : 2 ---->
    <tr>
		<td class="linkclasslabel"><div align="center"><img src="images/job.png" alt="JobFileCreator"/></div></td>
		<td class="linklist"><div align="center"><a href="under-construction.html" target="_blank">Job File Creator</a></div></td>
		<td>&nbsp;</td>
        <td class="linkclasslabel"><div align="center"><img src="images/links.png" alt="webLinks"/></div></td>
		<td class="linklist"><div align="center"><a href="./weblinks.php" target="_blank">Important Web Links</a></div></td>
	</tr>
    <tr>
		<td class="spacer"></td>
	</tr>
    
    <!--   Row : 3 ---->
    <tr>
		<td class="linkclasslabel"><div align="center"><img src="images/dictionary.png" alt="dictionary"/></div></td>
		<td class="linklist"><div align="center"><a href="createdict/home.php" target="_blank">Create Dict</a></div></td>
		<td>&nbsp;</td>
		<td class="linkclasslabel"><div align="center"><img src="images/dictreadable.png" alt="dictreadable"/></div></td>
		<td class="linklist"><div align="center"><a href="./dict_to_human_readable/home.php" target="_blank">Dict-To-Readable</a></div></td>
	</tr>
    <tr>
		<td class="spacer"></td>
	</tr>
	
    <!--   Row : 4 ---->
    <tr>
		<td class="linkclasslabel"><div align="center"><img src="images/week.png" alt="weeklyStatus"/></div></td>
		<td class="linklist"><div align="center"><a href="status_report_update/update_status.php" target="_blank">Update Weekly Status</a></div></td>
		<td>&nbsp;</td>
		<td class="linkclasslabel"><div align="center"><img src="images/tasks_list.png" alt="projectTasks"/></div></td>
		<td class="linklist"><div align="center"><a href="status_report_update/tasks_bucket.php" target="_blank">Project Tasks</a></div></td>
	</tr>
    <tr>
		<td class="spacer"></td>
	</tr>
	
    <!--   Row : 5 ---->
	<tr>
		<td class="linkclasslabel"><div align="center"><img src="images/execution.png" alt="ExecutionResults"/></div></td>
		<td class="linklist"><div align="center"><a href="./earms_logs_table/earms_log_parse.php" target="_blank">Execution Results</a></div></td>
		<td>&nbsp;</td>
        <td class="linkclasslabel"><div align="center"><img src="images/run-icon.png" alt="RunStatus"/></div></td>
		<td class="linklist"><div align="center"><a href="./run_status/run_status.php" target="_blank">Run Status</a></div></td>
		<td>&nbsp;</td>
		
	</tr>
    <tr>
		<td class="spacer"></td>
	</tr>
    
    <!--   Row : 6 ---->
	<tr>
		<td class="linkclasslabel"><div align="center"><img src="images/comingsoon.png" alt="ComingSoon"/></div></td>
		<td class="linklist"><div align="center"><a href="under-construction.html" target="_blank">New Tool</a></div></td>
		<td>&nbsp;</td>
        
		<td>&nbsp;</td>
		
	</tr>
    <tr>
		<td class="spacer"></td>
	</tr>
    
</table>
</center>

<div style="position: relative">
    <p style="position: fixed; bottom: 0; width:100%; text-align: center; color:grey;">
    GMPO
    </p>
</div>
</body>
</html>
