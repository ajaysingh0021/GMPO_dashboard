<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$main_title = "Update Master Execution Results";
$sub_title = "Append New Results to Master";
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
    
    if ($_POST['update_csv_btn']) {
      $getpwd = trim($_POST['admin_password']);
      $getmaster = trim($_POST['master_file']);
      $geturl = trim($_POST['url']);
      $getbuild = trim($_POST['build_number']);
      
      if ($getpwd && $getmaster && $geturl && $getbuild) {
        if ($getpwd == "1111") {
          
          print("<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>");
          print("<h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>$main_title</h2>");
          print("</div>");
          
          print("<div class='w3-card-4' style='width:90%; margin:50 auto;'>");
          print("<div class='w3-container w3-teal'>");
          print("<h2>$sub_title</h2>");
          print("</div>");
          
          //$report_link = "http://hostname-win10.GMPO.com/GMPO/reports/$getreleasename/$getdestfolder/allure-report/index.html";
          print("<div class='w3-container w3-border'><p>");
          
          //print("<b>Result Link: </b><br>");
          //print("<a href=\"$geturl\" target=\"_blank\">$geturl</a>");
          //print("<hr>");
          print("<b>Click the below CSV file to download it: </b><br><br>");
          $py_command = "python read_json_make_fa_xl.py $geturl";
          //print($py_command . "<br>");
          $cmd_output = shell_exec($py_command);
          print($cmd_output);
          print("<br><hr>");
          
          // $latest_csv is the csv file generated by the previous python api: read_json_make_fa_xl.py
          //$py_command = "python update_results_sheet.py $getmaster $latest_csv $getbuild";
          $py_command_append_sheet = "python update_results_sheet.py $getmaster $geturl $getbuild";
          
          //print($py_command_append_sheet . "<br>");
          $cmd_output = shell_exec($py_command_append_sheet);
          print($cmd_output);
          print("<br><hr>");
          
          print("Save the file, open it with excel and do your failure analysis.<br>");
          print("Add Bug/Auton & comments in the respective columns.<br>");
          
          print("<img alt=\"FA-Sheet-Template\" src=\"../images/fa_sheet.png\" width='1000' height='60'>");
          
          print("</p></div>");
          
          print("</div>");
          
          print("<hr>");
          print("</p></div>");
          print("</div>");
          exit();
        }
        else {
          $error_msg = "Error: Incorrect password!";
        }
      }
      else {
        $error_msg = "Error: One or more mandatory fields missing. Please specify all the fields and try again!";
      }
    }
?>

<form action='./update_exec_results_home.php' method='post'>
<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'><?php print($main_title); ?></h2>
</div>
<div class='w3-card-4' style='width:98%; margin:1 auto;'>
<div class='w3-card-4' style='float:left; width:72%; margin:50 auto; border-radius: 25px;'>
    <div class='w3-container w3-teal'>
        <h2><?php print($sub_title); ?></h2>
    </div>
    
<table class='w3-container' style='width:90%'>
  <tr>
    <td class='w3-label w3-text-teal' colspan=2>
        Select Master file, Specify results to append, Provide the admin password and Click Submit<br>
        <font size="1"><i> You will get a CSV file to download which you can upload to office 365 location for owners to update FA
        </i></font>
    </td>
    <br>
  </tr>
  
  <tr>
    <td colspan=2><font color='red'><?php print($error_msg); ?></font></td>
  </tr>
  
  <tr>
    <td class='w3-label w3-text-teal'>Master File<br>
    </td>
    <td>
        <select class='w3-select w3-border w3-round w3-pale-yellow' style="width:auto" id="master_file" name="master_file">
        <?php
            $dir = "./master_files/";
            $b = scandir($dir);
            //print_r($b);
            $no_of_dirs = sizeof($b);
            for ($x = 0; $x <= $no_of_dirs-1; $x++) {
                if ($b[$x] == "." or $b[$x] == ".." or $b[$x] == ".DS_Store") {
                    continue;
                }
                print("<option value=\"$b[$x]\">$b[$x]</option>");
            }
        ?>
        </select>
        <br>
        <font size="1"><i><b></b> Select the master file where you want to append the new results</i></font>
    </td>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>New Result URL<br>
      </td>
      <td>
        <input class='w3-input w3-border w3-round w3-pale-yellow' style="width:98%" type="text" name="url">
        <font size="1"><i><b>Example:</b> http://hostname-win10.GMPO.com/GMPO/reports/03.GMPO_4.1_EFT1/20200707064415_4.1-EFT-1-241-Legacy/allure-report/index.html</i></font>
      </td>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>Build Number<br>
      </td>
      <td>
        <input class='w3-input w3-border w3-round w3-pale-yellow' style="width:auto" type="text" name="build_number">
        <font size="1"><i>Specify the build number for which you are appending the results. <b>Example: 215</b></i></font>
      </td>
  </tr>
  
  <tr>
      <td class='w3-label w3-text-teal'>Admin Password<br>
      </td>
      <td><input class='w3-input w3-border w3-round w3-pale-yellow' style="width:auto" type="password" name="admin_password"</td>
      <font size="1"><i>Restrictions in place as Master file should be updated only by RI team</b></i></font>
  </tr>
  
  <tr>
    <td></td>
    <td>
      <br>
      <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' onclick='move()' name='update_csv_btn' value='Submit'/>
      
    </td>
  </tr>
  
</table>

<div id=myProgress">
  <div id="myBar">10%</div>
</div>

</div>

<!--
<div class='w3-card-4' style='width:70%; margin:50 auto;'>
<div id="rightdiv" style="float:right; width:25%; height:90%; background-color:#FEF9E7; border-radius: 25px;">
-->

<div class='w3-card-4' style='float:right; width:25%; margin:50 auto; border-radius: 25px;'>

    <div class='w3-container w3-teal'>
        <h2>Master Files</h2>
    </div>
    <table class='w3-container' style='width:90%'>
  <tr>
    <td class='w3-label w3-text-teal' colspan=2>
        Click to download the master files<br>
        <font size="1"><i> Use these for reference</i></font>
    </td>
    <br>
  </tr>
  
  <tr>
    <td colspan=2> <font size="2">
        <ul>
        <?php
            $dir = "./master_files/";
            $b = scandir($dir);
            //print_r($b);
            $no_of_dirs = sizeof($b);
            for ($x = 0; $x <= $no_of_dirs-1; $x++) {
                if ($b[$x] == "." or $b[$x] == ".." or $b[$x] == ".DS_Store") {
                    continue;
                }
                print("<li><a href=\"$dir\\$b[$x]\" target=\"_blank\">$b[$x]</a></li>");
            }
        ?>
        </ul>
        <br>
    </font>
    </td>
  </tr>
  
  </table>
</div>
    
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