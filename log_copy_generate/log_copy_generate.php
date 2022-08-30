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
    
    if ($_POST['logs_copy_generate_btn']) {
      $getvmname = trim($_POST['vm_name']);
      $getvmfolder = trim($_POST['vm_folder']);
      $getreleasename = trim($_POST['release_name']);
      $getdestfolder = trim($_POST['dest_folder']);
      $copy_command = "xcopy /si \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder";
      $allure_command = "cd C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder && allure generate . --clean -o allure-report";
      print("<br>copy_command = $copy_command");
      print("<br>allure_command = $allure_command");
      
      $copy_output = shell_exec($copy_command);
      //print("<br>$copy_output");
      sleep(2);
      
      $allure_output = shell_exec($allure_command);
      print("<br> $allure_output");
      $report_link = "http://hostname-win10.GMPO.com/GMPO/reports/$getreleasename/$getdestfolder/allure-report/index.html";
      //print("<br> http://hostname-win10.GMPO.com/GMPO/reports/$getreleasename/$getdestfolder/allure-report/index.html <br>");
      print("<br><a href=\"$report_link\" target=\"_blank\">$report_link</a> <br>");
      
      exit();
    }

?>

<form action='./log_copy_generate.php' method='post'>
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
        <select id="vm_name" name="vm_name">
          <?php
            // Get list of all the VMs from a file?
            // gmpoadmin: For now hard-coding
            $vm_names_array = array("GMPOautotest7-w7",
                                    "GMPOautotst21-w7",
                                    "GMPOautotst12-w7",
                                    "GMPOautotst17-w7",
                                    "GMPOautotst22-w7",
                                    "garuda-w2k8",
                                    "GMPOautotst23-w7",
                                    "GMPOautotest6-w7",
                                    "GMPOautotst11-w7",
                                    "GMPO-atqa-win10",
                                    "GMPOautotest8-w7",
                                    "GMPOautotest9-w7",
                                    "GMPOautotst10-w7",
                                    "GMPOautotst13-w7",
                                    "GMPOautotst14-w7",
                                    "GMPOautotst16-w7",
                                    "GMPOautotst18-w7",
                                    "GMPOautotst19-w7",
                                    "GMPOtest1-win10");
            sort($vm_names_array);
            foreach ($vm_names_array as $vmname) {
              print("<option value=\"$vmname\">$vmname</option>");
            }
            //<option value="volvo">Volvo</option>
            //<option value="saab">Saab</option>
            //<option value="fiat" selected>Fiat</option>
            //<option value="audi">Audi</option>
            
          ?>
        </select>
  
        
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>Folder to Copy<br>
      </td>
      <td><input class='w3-input w3-border w3-round w3-pale-yellow' style="width:60%" type="text" name="vm_folder"
        value="allure-results"<?php //print("allure-results"); //print($vm_folder);?>><font size="1"><i>Default: allure-results</i></font></td>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>Destination Release*<br>
      </td>
      <td>
        <select id="release_name" name="release_name">
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
