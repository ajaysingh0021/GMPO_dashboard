<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
// $userid = $_SESSION['userid'];
// $username = $_SESSION['username'];
?>

<html lang="en-US">
<head>
<link rel="stylesheet" href="../style/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
#myProgress {
  width: 100%;
  background-color: #ddd;
}

#myBar {
  width: 0%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}

td {
    padding:5px;
}
</style>
<style type="text/css">a {text-decoration: none}</style>

</head>

<title>
Generate Results
</title>
<body>
<?php
    $formmessage_part1 = "<br><br>
                          <div class='w3-container'>
                          <div class='w3-card-4' style='width:80%;'>
                          <div class='w3-container w3-teal'>
                          <h2>Message</h2>
                          </div>
                          <div class='w3-container'>";
    $formmessage_part2 = "<br><br></div></div></div>";
    
    // Get list of all the VMs from a file?
    // gmpoadmin: For now hard-coding
    $vm_names_array = array("GMPOautotest7-w7",
                            "GMPOautotst21-w7",
                            "GMPOautotst12-w7",
                            "GMPOautotst17-w7",
                            "GMPOautotst22-w7",
                            "garuda-w2k8",
                            );
    
    if ($_POST['update_csv_btn']) {
      
      $getadminpwd = trim($_POST['admin_pwd']);
      $geturl = trim($_POST['url']);
      $getrelease = trim($_POST['release']);
      $getbuild = trim($_POST['build']);
      
      print("<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>");
      print("<h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>Update Master CSV Files</h2>");
      print("</div>");
      
      // RESULTS LINK
      print("<div class='w3-card-4' style='width:90%; margin:50 auto;'>");
      print("<div class='w3-container w3-teal'>");
      print("<h2>Updated CSV File</h2>");
      print("</div>");
      $report_link = "http://hostname-win10.GMPO.com/GMPO/reports/$getreleasename/$getdestfolder/allure-report/index.html";
      print("<div class='w3-container w3-border'><p>");
      print("<b><a href=\"$report_link\" target=\"_blank\">$report_link</a> </b>");
      print("</p></div>");
      print("</div>");
      
      // $getvmname = trim($_POST['vm_name']);
      
      // LOGS
      print("<div class='w3-card-4' style='width:90%; margin:50 auto;'>");
      print("<div class='w3-container w3-teal'>");
      print("<h2>Logs</h2>");
      print("</div>");
      print("<div class='w3-container w3-border'><p>");
      $robo_log_file = "robolog.txt";
      $data = "<h3>Copy Log data</h3>\n";
      #file_put_contents($robo_log_file, $data, FILE_APPEND);
      file_put_contents($robo_log_file, $data);
      foreach ($vm_names_array as $vmname) {
        if (isset($_POST[$vmname])) {
          $getvmname = $vmname;
          // robocopy \\GMPOautotest7-w7\GMPOautomation\NGGMPODriver\allure-results C:\xampp\htdocs\GMPO\reports\01.GMPO_4.0_LA\test\ /NFL /NDL /NJH /NJS /nc /ns /np
          //$copy_command = "robocopy \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder\\  /NFL /NDL /NJH /NJS /nc /ns /np";
          //$copy_command = "robocopy \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder\\  /NFL /NP";
          
          $copy_command = "robocopy \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder\\  /NFL /NP /LOG+:$robo_log_file";
          $data = "<hr>copy_command = $copy_command \n";
          file_put_contents($robo_log_file, $data, FILE_APPEND);
          
          print("$copy_command<br>");
          //$copy_output = shell_exec($copy_command);
          //print("<br>$copy_output<br>");
          //print("<hr>");
        }
      }
      print("<b>COPY COMPLETED!!</b>");
      print("<hr>");
      echo file_get_contents($robo_log_file);
      print("<hr>");
      
      
      //$copy_command = "xcopy /si \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder";
      //$copy_command = "robocopy /si \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder";
      
      $allure_command = "cd C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder && START /B allure generate . --clean -o allure-report";
      //print("<br>copy_command = $copy_command");
      print("<br>allure_command = $allure_command");
      
      //print("<br>$copy_output");
      //$allure_output = shell_exec($allure_command);
      
      sleep(5);
      
      print("<br> $allure_output");
      print("<hr>");
      $report_link = "http://hostname-win10.GMPO.com/GMPO/reports/$getreleasename/$getdestfolder/allure-report/index.html";
      //print("<br> http://hostname-win10.GMPO.com/GMPO/reports/$getreleasename/$getdestfolder/allure-report/index.html <br>");
      print("<br><a href=\"$report_link\" target=\"_blank\">$report_link</a> <br>");
      print("<hr>");
      print("</p></div>");
      print("</div>");
      exit();
    }

?>

<form action='./admin_roles.php' method='post'>
<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>Update Master CSV Files</h2>
</div>
<div class='w3-container'>
<div class='w3-display-container'>
<div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green'
    href='./log_copy_generate_help.php' target="_blank" style='text-align:right;'>Help</a></div>
</div></div>

<div class='w3-card-4' style='width:70%; margin:50 auto;'>
    <div class='w3-container w3-teal'>
        <h2>Enter the RI results details</h2>
    </div>
    
<table class='w3-container' style='width:90%'>
  <tr>
      <td style="width:30%"></td>
      <td><font color='red'><?php $emsg = ''; echo "$emsg";?></font></td>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>Admin Password*<br>
      </td>
      <td>
        <input class='w3-input w3-border w3-round w3-pale-yellow' style="width:60%" type="password" name="admin_pwd">
      </td>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>Result URL*<br>
      </td>
      <td>
        <input class='w3-input w3-border w3-round w3-pale-yellow' style="width:60%" type="text" name="url">
        <font size="1"><i><b>Example:</b> http://hostname-win10.GMPO.com/GMPO/reports/02.GMPO_4.0_GA/20200515070513_4.0-GA-develop-1096-rerun/allure-report/index.html</i></font>
      </td>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>GMPO Release*<br>
      </td>
      <td>
        <input class='w3-input w3-border w3-round w3-pale-yellow' style="width:60%" type="text" name="release">
        <font size="1"><i>Enter 4.0 or 4.1</i></font>
      </td>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>Build Number*<br>
      </td>
      <td>
        <input class='w3-input w3-border w3-round w3-pale-yellow' style="width:60%" type="text" name="build">
        <font size="1"><i>Format:<b>1079</b>. Provide GMPO build# used in the execution</i></font>
      </td>
  </tr>
  
  
  
  
  <tr>
    <td></td>
    <td>
      <br>
      <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' onclick='move()' name='update_csv_btn' value='Submit'/>
      
    </td>
  </tr>
  
</table>
<br>
<div id=myProgress">
  <div id="myBar">10%</div>
</div>
<br>

</div>
</form>

<script>
var i = 0;
function move() {
  if (i == 0) {
    i = 1;
    var elem = document.getElementById("myBar");
    var width = 10;
    var id = setInterval(frame, 1000);
    function frame() {
      if (width >= 100) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
        elem.innerHTML = width  + "%";
      }
    }
  }
}
</script>

</body>
</html>
