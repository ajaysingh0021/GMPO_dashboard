<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$main_title = "Failure Analysis";
$sub_title = "Generate FA File";
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
      $geturl = trim($_POST['url']);
      
      print("<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>");
      print("<h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>$main_title</h2>");
      print("</div>");
      
      // RESULTS LINK
      print("<div class='w3-card-4' style='width:90%; margin:50 auto;'>");
      print("<div class='w3-container w3-teal'>");
      print("<h2>$sub_title</h2>");
      print("</div>");
      //$report_link = "http://hostname-win10.GMPO.com/GMPO/reports/$getreleasename/$getdestfolder/allure-report/index.html";
      print("<div class='w3-container w3-border'><p>");
      print("<b>Result Link: </b><br>");
      print("<a href=\"$geturl\" target=\"_blank\">$geturl</a>");
      print("<hr>");
      print("<b>Click the below CSV file to download it: </b><br><br>");
      $py_command = "python read_json_make_fa_xl.py $geturl";
      //print($py_command . "<br>");
      $cmd_output = shell_exec($py_command);
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

?>

<form action='./fa_home.php' method='post'>
<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'><?php print($main_title); ?></h2>
</div>

<div class='w3-card-4' style='width:70%; margin:50 auto;'>
    <div class='w3-container w3-teal'>
        <h2><?php print($sub_title); ?></h2>
    </div>
    
<table class='w3-container' style='width:90%'>
  <tr>
    <td class='w3-label w3-text-teal' colspan=2>
        <b>Provide the result link in the below text box and Click Submit</b><br>
        <font size="1"><i> You will get a CSV file to download which you can use to do the failure analysis and send by email to RI team
        </i></font>
    </td>
    <br>
  </tr>
  <tr>
      <td class='w3-label w3-text-teal'>Result URL*<br>
      </td>
      <td>
        <input class='w3-input w3-border w3-round w3-pale-yellow' style="width:98%" type="text" name="url">
        <font size="1"><i><b>Example:</b> http://hostname-win10.GMPO.com/GMPO/reports/02.GMPO_4.0_GA/20200618043115_4.0-GA-develop-1151-GA-RI/allure-report/index.html</i></font>
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

<div id=myProgress">
  <div id="myBar">10%</div>
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
