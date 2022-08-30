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
    $vm_names_array = array("GMPOtest2-win",                     
                            "GMPOtest1-win",
							"GMPOtest3-win",
							"GMPOtest4-win",
							"GMPOtest5-win",
							"GMPOtest6-win",
							"GMPOtest7-win",
							"GMPOtest8-win",
							"GMPOtest9-win",
							"GMPOtest10-win",
							"GMPOtest11-win",
							"GMPOtest12-win",
							"GMPOtest13-win",
							"GMPOtest14-win",
							"GMPOtest15-win",
							"GMPOtest16-win",
							"GMPOtest17-win",
							"GMPOtest18-win",
							"GMPOtest19-win",							
							"GMPOtest20-win7",
							"GMPOtest21-win7",
							"GMPOautotst11-w7",
                            "GMPOautotst15-w7",
                            "GMPOautotst10-w7",
                            "GMPOautotst14-w7",
							"GMPOautotest7-w7",
                            "ngGMPO-aqa-win10"
                            );
    
    if ($_POST['logs_copy_generate_btn']) {
      
      $getvmfolder = trim($_POST['vm_folder']);
      $getreleasename = trim($_POST['release_name']);
      $getdestfolder = trim($_POST['dest_folder']);
      
      
      print("<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>");
      print("<h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>Copy Logs & Generate Results-Link</h2>");
      print("</div>");
      
      // RESULTS LINK
      print("<div class='w3-card-4' style='width:90%; margin:50 auto;'>");
      print("<div class='w3-container w3-teal'>");
      print("<h2>Results Link</h2>");
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
      $data = "<h3>Copy Log Data</h3>\n";
      #file_put_contents($robo_log_file, $data, FILE_APPEND);
      file_put_contents($robo_log_file, $data);
      foreach ($vm_names_array as $vmname) {
        if (isset($_POST[$vmname])) {
          $getvmname = $vmname;
          // robocopy \\GMPOautotest7-w7\GMPOautomation\NGGMPODriver\allure-results C:\xampp\htdocs\GMPO\reports\01.GMPO_4.0_LA\test\ /NFL /NDL /NJH /NJS /nc /ns /np
          //$copy_command = "robocopy \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder\\  /NFL /NDL /NJH /NJS /nc /ns /np";
          //$copy_command = "robocopy \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder\\  /NFL /NP";
          
          $copy_command = "robocopy \\\\$getvmname\\RunTestSuite\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder\\  /NFL /NP /LOG+:$robo_log_file";
          $data = "<hr>copy_command = $copy_command \n";
          file_put_contents($robo_log_file, $data, FILE_APPEND);
          
          print("$copy_command<br>");
          $copy_output = shell_exec($copy_command);
          //print("<br>$copy_output<br>");
          //print("<hr>");
        }
      }
      print("<b>COPY COMPLETED!!</b>");
      print("<br>No need to go back and submit again!");
      print("<hr>");
      echo file_get_contents($robo_log_file);
      print("<hr>");
      
      //$copy_command = "xcopy /si \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder";
      //$copy_command = "robocopy /si \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder";
      
      print("<h3>Allure Generate Data</h3>");
      $allure_command = "cd C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder && START /B allure generate . --clean -o allure-report";
      print("allure_command = $allure_command");
      
      //$copy_output = shell_exec($copy_command);
      //print("<br>$copy_output");
      $allure_output = shell_exec($allure_command);
      
      sleep(5);
      print("<br>Sent the Allure Command to generate the results. You should be able to view the logs now!<br>");
      //print("<br> $allure_output"); // Commented this as it fails sometimes in GUI. But ideally once it is sent it will complete as expected.
      
      print("<hr>");
      $report_link = "http://hostname-win10.GMPO.com/GMPO/reports/$getreleasename/$getdestfolder/allure-report/index.html";
      //print("<br> http://hostname-win10.GMPO.com/GMPO/reports/$getreleasename/$getdestfolder/allure-report/index.html <br>");
      print("Below is the report link:<br>");
      print("<a href=\"$report_link\" target=\"_blank\">$report_link</a> <br>");
      print("<hr>");
      print("</p></div>");
      print("</div>");
      exit();
    }

?>

<form action='./log_copy_generate_ri.php' method='post'>
<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>Copy Logs & Generate Results-Link</h2>
</div>
<div class='w3-container'>
<div class='w3-display-container'>
<div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green'
    href='./log_copy_generate_help.php' target="_blank" style='text-align:right;'>Help</a></div>
</div></div>

<div class='w3-card-4' style='width:70%; margin:50 auto;'>
    <div class='w3-container w3-teal'>
        <h2>Execution VM & Destination Folder Details</h2>
    </div>
    
<table class='w3-container' style='width:90%'>
  <tr>
      <td style="width:30%"></td>
      <td><font color='red'><?php $emsg = ''; echo "$emsg";?></font></td>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>VM Name*<br>
      </td>
      <td>
        
          <?php
            //print("<select id=\"vm_name\" name=\"vm_name\">");
            sort($vm_names_array);
            $count = 0;
            print("<div class=\"w3-container\">");
            //print("<h3>Select VMs to copy files from</h3><br>");
            print("<div class=\"w3-responsive\">");
            print("<table class=\"w3-table-all\">");
            print("<tr>");
            foreach ($vm_names_array as $vmname) {
              $count++;
              //print("<option value=\"$vmname\">$vmname</option>");
              
              print("<td><input class=\"w3-check\" type=\"checkbox\" id=\"$vmname\" name=\"$vmname\" value=\"$vmname\"><label><font size=\"2\">$vmname</font></label></td>");
              if ($count == 3) {
                print("</tr><tr>");
                $count = 0;
              }
            }
            //print($count);
            for ($x=$count; $count < 3; $count++) {
              print("<td></td>");
            }
            print("</tr>");
            print("</table>");
            print("</div>");
            print("</div>");
            
            //<option value="volvo">Volvo</option>
            //<option value="saab">Saab</option>
            //<option value="fiat" selected>Fiat</option>
            //<option value="audi">Audi</option>
            
            print("</select>");
          ?>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>Folder to Copy<br>
      </td>
      <td><input class='w3-input w3-border w3-round w3-pale-yellow' style="width:60%" type="text" name="vm_folder"
        value="allure-results"<?php //print("allure-results"); //print($vm_folder);?>><font size="1">
        <i>Default: allure-results<br>Base-Directory:\\vmName\GMPOautomation\NGGMPODriver\</i></font>
      </td>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>Destination Release*<br>
      </td>
      <td>
        <select class='w3-select w3-border w3-round w3-pale-yellow' style="width:60%" id="release_name" name="release_name">
        <?php
            $dir = "../../GMPO/reports/";
            // Sort in descending order
            $b = scandir($dir);
            //print_r($b);
            $no_of_dirs = sizeof($b);
            for ($x = 0; $x <= $no_of_dirs-1; $x++) {
              if ($b[$x] == "." or $b[$x] == ".." or $b[$x] == ".DS_Store" or !is_dir($dir.$b[$x])) {
                continue;
              }
              print("<option value=\"$b[$x]\">$b[$x]</option>");
            }
        ?>
        </select>
      </td>
  </tr>
  
  <tr>
    <td class='w3-label w3-text-teal'>Destination Folder-name*<br>
    </td>
    <td><?php $timestamp = date("Ymdhis"); //print($timestamp);?>
    <input class='w3-input w3-border w3-round w3-pale-yellow' style="width:60%" type="text" name="dest_folder" 
      value=<?php print($timestamp . "_"); ?>
      >
      <font size="1"><i>Format: <b>timestamp_build_text</b>. Timestamp is appended before the text you provide</i></font>
    </td>
  </tr>
  
  <tr>
    <td></td>
    <td>
      <br>
      <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' onclick='move()' name='logs_copy_generate_btn' value='Submit'/>
      
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
