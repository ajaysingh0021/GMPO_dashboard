<?php
  //print_r($_POST);  // 4.0 RI Text
  
  if ($_POST["show_results_btn"] == false) {
    //print('Ignore. Redirecting...');
    ?>
    <meta http-equiv="refresh"
        content="0; url = ./dashboard_home.php" />
    <?php
    exit();
  }
  $input_data = $_POST["show_results_btn"];
  
  # Get $GMPO_version - 4.0
  if (strpos($input_data, '4.2-AC1') !== false) {
    $GMPO_version = "4.2-AC1";
  }
  else {
    $GMPO_version = "9.1";
  }
  # Get $run_type - RI
  if (strpos($input_data, 'Sanity') !== false) {
    $run_type = "Sanity";
  }
  else if (strpos($input_data, 'HPALM') !== false) {
    $run_type = "HPALM";
  }
  else {
    $run_type = "RI";
  }
  # Get mode - Text
  if (strpos($input_data, 'Text') !== false) {
    $mode = "simple";
  }
  else {
    $mode = "style";
  }
  $page_heading = $run_type . " Dashboard " . $GMPO_version;                   // "RI Dashboard 4.0"
  $sub_heading = "GMPO "  . $GMPO_version . " " . $run_type;                    // "GMPO 4.0 RI"
  $filename = "Master_Report_" . $run_type . "_" . $GMPO_version . ".csv";     // "Master_Report_RI_4.0.csv"
  
  //$page_heading = "RI Dashboard 4.0";
  //$sub_heading = "GMPO 4.0 RI";
  //$filename = "Master_Report_RI_4.0.csv";
  //$mode = "style"; // "simple"
?>

<html lang="en-US">
<head>
<link rel="stylesheet" href="../style/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  * {
    box-sizing: border-box;
  }
  
  #myInput {
    background-image: url('../images/searchicon.png');
    background-position: 10px 10px;
    background-repeat: no-repeat;
    width: 100%;
    font-size: 16px;
    padding: 12px 20px 12px 40px;
    border: 1px solid #ddd;
    margin-bottom: 12px;
  }
  
  table {
    border-collapse: collapse;
    width: 100%;
  }
  th, td {
    text-align: left;
    padding: 8px;
  }
  tr:nth-child(even) {background-color: #f2f2f2;}
  
  #results {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }
  
  #results td, #results th {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
  }
  
  #results tr:nth-child(even){background-color: #f2f2f2;}
  
  #results tr:hover {background-color: #ddd;}
  
  #results th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
  }
  
  .fa-check {
    color: green;
  }
  .fa-remove {
    color: red;
  }
  .fa-ban {
    color: pink;
  }
</style>
</head>

<title>
Trends Dashboard
</title>
<body>

<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'><?php print($page_heading); ?></h2>
</div>
<div class='w3-container'>
<div class='w3-display-container'>
<div class='w3-display-topright'>
  <a class='w3-btn w3-round w3-blue w3-padding-small w3-hover-green'
    href='./dashboard_home.php' target="_blank" style='text-align:right;'>Home</a>
  <a class='w3-btn w3-round w3-blue w3-padding-small w3-hover-green'
    href='./<?php print($filename);?>' target="_blank" style='text-align:right;'>Export Report</a>
</div>
</div>
</div>

<div class='w3-card-4' style='width:98%; margin:30 auto;'>
  <div class='w3-container w3-teal'>
    <h2><?php print($sub_heading); ?></h2>
  </div>
  
  <br>
  <div class='w3-container' style="overflow-x:auto;">
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search testname..." title="Type in a name">
    
    <table id="results">
    <?php
      // $filename is set above
      $f = fopen($filename, "r");
      $count = 0;
      while (($line = fgetcsv($f)) !== false) {
        $count++;
        echo "<tr>";
        $first5 = 0;
        $testname = "";
        foreach ($line as $cell) {
          $first5++;
          if ($first5 < 5) {
            if ($first5 == 1) {
              $testname = htmlspecialchars($cell);
            }
            else {
              $testname = $testname . ":" . htmlspecialchars($cell);
            }
            continue;
          }
          if ($first5 == 5) {
            if ($count == 1) {
              echo "<th style='text-align: left;'>" . $testname . ":<br>" . htmlspecialchars($cell) .  "</th>";
            }
            else {
              echo "<td style='text-align: left;'>" . $testname . ":<br>" . htmlspecialchars($cell) .  "</td>";
            }
          }
          else {
            if ($count == 1) {
              //echo "<th>" . htmlspecialchars($cell) . "</th>";
              echo "<th>" . htmlspecialchars($cell) . "</th>";
            }
            else {
              $result_data = htmlspecialchars($cell);
              if ($mode == "simple") {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
              }
              else {
                if (strpos($cell, 'passed') !== false) {
                  echo "<td><i class=\"fa fa-check\"></i></td>";
                }
                elseif (strpos($cell, 'failed') !== false) {
                  echo "<td><i class=\"fa fa-remove\"></i></td>";
                }
                elseif (strpos($cell, 'Not Executed') !== false) {
                  echo "<td><i class=\"fa fa-ban\"></i></td>";
                }
                else {
                  echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
              }
            }
          }
          
        }
        echo "</tr>\n";
      }
      fclose($f);
    ?>
    </table>
  </div>
  <br>
</div>

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("results");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>

</body>
</html>
