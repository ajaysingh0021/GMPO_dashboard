<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
// $userid = $_SESSION['userid'];
// $username = $_SESSION['username'];
?>

<html>
<head>
<link rel="stylesheet" href="../style/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
/* unvisited link */
a:link {
  color: blue;
}
/* visited link */
a:visited {
  color: green;
}
/* mouse over link */
a:hover {
  color: hotpink;
}
/* selected link */
a:active {
  color: blue;
}

/* Style the button that is used to open and close the collapsible content */
.collapsible {
  background-color: #54D9F7;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.active, .collapsible:hover {
  background-color: #ccc;
}

.collapsible:after {
  content: '\02795'; /* Unicode character for "plus" sign (+) */
  font-size: 13px;
  color: white;
  float: right;
  margin-left: 5px;
}

.active:after {
  content: "\2796"; /* Unicode character for "minus" sign (-) */
}

/* Style the collapsible content. Note: hidden by default */
.content {
  /*display: none;
  overflow: hidden;
  background-color: white;*/
  padding: 0 18px;
  background-color: #f1f1f1;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
</style>

<style>
td {
    padding:5px;
}
</style>
<style type="text/css">a {text-decoration: none}</style>

</head>

<title>
GMPO-Results
</title>
<body>


<form action='./exec_results.php' method='post'>
<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>View Execution Logs</h2>
</div>
<div class='w3-container'>
<div class='w3-display-container'>
<div class='w3-display-topright'> <a class='w3-btn w3-round w3-teal w3-padding-small w3-hover-green'
    href='./exec_results_help.php' target="_blank" style='text-align:right;'>Help</a></div>
</div></div>

<div class='w3-card-4' style='width:70%; margin:50 auto;'>
    <div class='w3-container w3-teal'>
        <h2>Execution logs</h2>
    </div>
    
<table class='w3-container' style="width:90%">
<tr>
    
    <td class='w3-label w3-text-teal'>
        <b>Select the GMPO release and click on any link to view the logs</b><br>
        <i>THIS IS SAMPLE DATA FOR DEMO PURPOSE ONLY. LINKS DO NOT WORK. POINT TO YOUR LOGS DIR.</i><BR>
        <font size="1"><i> Clicking will open it in new browser tab. If you get error 'Object not found!' that means the allure results are not yet generated for that directory.<br>
        RI owner will generate it once the execution is over or ask admin to get it generated.
        For any question, contact gmpoemailid@GMPO.com or GMPO-india-test@GMPO.com
        </i></font>
        <hr>
    </td>
</tr>

<tr>
    <td>
        <?php
            //$dir = "../../GMPO/reports/";
            $dir = "../";
            // Sort in ascending order - this is default
            //$a = scandir($dir);
            //print_r($a);
            // http://hostname-win10.GMPO.com/GMPO/reports/<release-folder>/<folder-name>/allure-report/index.html
            // Example: http://hostname-win10.GMPO.com/GMPO/reports/GMPO_4.0_GA/ts_xyz/allure-report/index.html
            // $dir
            
            // Sort in descending order
            $b = scandir($dir);
            //print_r($b);
            $no_of_dirs = sizeof($b);
            for ($x = 0; $x <= $no_of_dirs-1; $x++) {
                if ($b[$x] == "." or $b[$x] == ".." or $b[$x] == ".DS_Store" or !is_dir($dir.$b[$x])) {
                    continue;
                }
                //print("<li><a href=$dir$b[$x]/allure-report/index.html target=\"_blank\">$b[$x]</a></br/li>");
                print("<div>");
                print("<button type=\"button\" class=\"collapsible\">$b[$x]</button>");
                print("<div class=\"content\">");
                $main_dir = $dir.$b[$x];
                $subdirs = scandir($main_dir);
                //print_r($subdirs);
                $no_of_subdirs = sizeof($subdirs);
                print("<ul style='list-style-type: circle;'>");
                for ($y = 0; $y <= $no_of_subdirs-1; $y++) {
                    if ($subdirs[$y] == "." or $subdirs[$y] == ".." or $subdirs[$y] == ".DS_Store") {
                        continue;
                    }
                    print("<li><a href=$main_dir/$subdirs[$y]/allure-report/index.html target=\"_blank\">$subdirs[$y]</a></br/li>");
                }
                print("</div>");
                print("</div>");
                print("<br>");
            }
        ?>
        </ul>
    </td>
</tr>

</table>
</div>
</form>

<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    //if (content.style.display === "block") {
    //  content.style.display = "none";
    //} else {
    //  content.style.display = "block";
    //}
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
}
</script>

</body>
</html>
