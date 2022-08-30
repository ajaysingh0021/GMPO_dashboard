<?php
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();

  $page_heading = "Dashboard Home";
  $sub_heading = "Select the Results Category";
  //$filename = "Master_Report_RI_4.0.csv";
  //$mode = "style"; // "simple"

?>

<html lang="en-US">
<head>
<link rel="stylesheet" href="../style/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
a:link, a:visited {
  background-color: teal;
  color: white;
  padding: 14px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

a:hover, a:active {
  background-color: blue;
}
</style>

</head>

<title>
Results Dashboard
</title>
<body>
<form action='./dashboard_results.php' method='post'>
  <div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
      <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'><?php print($page_heading); ?></h2>
  </div>
  
  <div class='w3-card-4' style='width:90%; margin:30 auto;'>
    <div class='w3-container w3-teal'>
      <h2><?php print($sub_heading); ?></h2>
    </div>
    <br>
    <div>
      <table class='w3-container' style='width:100%'>
        <tr>
          <td><b>GMPO 9.1</b></td>
        </tr>
        <tr>
          <!--
          <td>
            <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='show_results_btn' value='4.0 RI Text'/>
            <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='show_results_btn' value='4.0 RI Icon'/>
          </td>
          -->
          
          <td>
            <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='show_results_btn' value='9.1 Sanity Text'/>
            <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='show_results_btn' value='9.1 Sanity Icon'/>
            
          </td>
          
        </tr>
        
        <tr>
          <td class="spacer"></td>
        </tr>
        <!--
        <tr>
          <td><b>GMPO 4.2 - FCS</b></td>
        </tr>
        <tr>
          
          <td>
            <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='show_results_btn' value='4.1 RI Text'/>
            <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='show_results_btn' value='4.1 RI Icon'/>
          </td>
          
          
          <td>
            <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='show_results_btn' value='4.2-FCS Sanity Text'/>
            <input class='w3-btn w3-round w3-teal w3-large w3-hover-green' type='submit' name='show_results_btn' value='4.2-FCS Sanity Icon'/>
            
          </td>
          -->
        </tr>
      </table>
    </div>
    <br>
  </div>
</form>
</body>
</html>
