<html>
	<head>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
	<title>YAML Creator</title>
	</head>
	<body>
    <script>
        function goBack() {
            window.history.go(-1);
        }
    </script>
    <form name="4_connections" action="5_rsips.php" method="post">
    
<?php
    // Pass all the POST variables
    foreach ($_POST as $key => $value) {
        //print($key . " => " . $value . "<br>");
        print('<input type="hidden" name="' . $key .'" value="' . trim($value) . '"/>');
    }
    
    // Verify all the values passed from previous screen
	$errors = array();
    $tgens_info_to_collect = array('tgens_type' => 'Type', 
                                   'tgens_ip' => 'IP');
    for ($i=1;$i<=$_POST['home_tgens'];$i++) {
        foreach($tgens_info_to_collect as $key => $value) {
            if (trim($_POST[$key.'_'.$i]) == "") {
                array_push($errors, "Value not found for Tgen-" . $i .":" . $key);
            }
        }
    }
    if ($errors) {
        print('<table class="table-style-three">');
        print('<tr><th colspan="2">');
        print('<b>ERROR:: Please correct these errors:</b>');
        print('</th></tr>');
        $x = 0;
        foreach ($errors as $error) {
            $x = $x + 1;
            print('<tr><td align="center">' . $x . '.</td>');
            print('<td>' . $error . '</td></tr>');
        }
        print('</table>');
        
        if (($_POST['browser_type'] == 'Chrome') || ($_POST['browser_type'] == 'Firefox')) {
            print('<p><button onclick="goBack()"> < Back </button></p>');
            //print('<p><font size="2"><i>On IE/Safari browsers, use browser back button to return to previous screen.</i></font></p>');
        }
        else {
            print('<br><b>Press BACK button on the browser and try again.</b>');
        }
        // print('<p><button onclick="goBack()"> < Back </button></p>');
        // print('<p><font size="2"><i>On IE/Safari browsers, use browser back button to return to previous screen.</i></font></p>');
        //print('<br><b>Press BACK button on the browser and try again.</b>');
        exit;
    }
    
    // Generate tgens aliases based on its name
    for ($i=1;$i<=$_POST['home_tgens'];$i++) {
        print('<input type="hidden" name="tgens_alias_' . $i . '" value="tgen' . $_POST['tgens_name_'.$i] . '"/>');
    }
    
?>

	<!-- <table border="1" cellpadding="6" cellspacing="1"> -->
    <table class="table-style-one">
	
	<tr>
        <th colspan="2" height="30">
			<p class=MsoNormal style='text-align:center'><span
			style='font-size:28.0pt;font-family:US;text-decoration:bold;
			font-weight:bold;language:EN'>
            <img align="left" border="0" alt="STEP1" src="./images/GMPO-logo.png" width="70" height="40">
            Connections Count</span>
            <br><img border="0" alt="STEP4" src="./images/step4.png" width="500" height="70">
			</p>
		</th>
	</tr>
    <tr>
        <td>
			<b>Please specify number(count) of physical connections between Nodes-Nodes & Nodes-Tgens</b><br>
			<font size="1"><i>If there is no connection between a pair, specify 0 or leave it blank<br>
            *Do not consider unmonitored tunnel here. Only physical connection count is needed.
            </i></font>
		</td>
    </tr>
    <tr>
        <td>
        
        <!-- <table border="2" width=100% cellpadding="6"> -->
        <table class="table-style-five">
        <tr>
            <th>Pairs</th>
            <th>Hostnames</th>
            <th>Number of Connections</th>
        </tr>
        
        <?php
            // Create the combinations of nodes and tgens to specify the connection counts
            for($i=1;$i<=$_POST['home_nodes'];$i++) {
                // Nodes to Nodes
                $key = 'combn_nodes_nodes';
                $m=$i+1;
                for($j=$m;$j<=$_POST['home_nodes'];$j++) {
                    $node_combn = 'Node' . $i . '-' . 'Node' . $j;
                    $node_hname_combn = $_POST['nodes_hostname_' . $i] . '-' . $_POST['nodes_hostname_' . $j];
                    $node_hname_combn_field = 'count_' . $_POST['nodes_hostname_' . $i] . '-' . $_POST['nodes_hostname_' . $j];
                    print('<tr>');
                    print('<td>' . $node_combn . '</td>');
                    print('<td>' . $node_hname_combn . '</td>');
                    //print('<td  align="center"><input type="text" name="' . $key . '_' . $i . '_' . $j . '"></td>');
                    print('<td  align="center"><input type="text" name="' . $node_hname_combn_field .'"></td>');
                    print('</tr>');
                }
                
                // Nodes to Tgens
                $key = 'combn_nodes_tgens';
                for($j=1;$j<=$_POST['home_tgens'];$j++) {
                    $node_combn = 'Node' . $i . '-' . 'Tgen' . $j;
                    $node_hname_combn = $_POST['nodes_hostname_' . $i] . '-' . $_POST['tgens_name_' . $j];
                    $node_hname_combn_field = 'count_' . $_POST['nodes_hostname_' . $i] . '-' . $_POST['tgens_name_' . $j];
                    print('<tr>');
                    print('<td>' . $node_combn . '</td>');
                    print('<td>' . $node_hname_combn . '</td>');
                    //print('<td  align="center"><input type="text" name="' . $key . '_' . $i . '_' . $j . '"></td>');
                    print('<td  align="center"><input type="text" name="' . $node_hname_combn_field .'"></td>');
                    print('</tr>');
                }
            }
        ?>
        </table>
        </td>
    </tr>
    </table>
    
    <!--   Submit Button 
	<p align="left">
    <button onclick="goBack()"> < Back </button>
    <input type="submit" value="Next >" name="b_connections_next"></p>
    ---->
    <!--   Back-Next Button ---->
    <?php
    if (($_POST['browser_type'] == 'Chrome') || ($_POST['browser_type'] == 'Firefox')) {
        print('<p align="left">');
        print('<button onclick="goBack()"> < Back </button>');
        print('&nbsp;&nbsp;');
        print('<input type="submit" id="submit" value="Next >" name="b_connections_next">');
        print('<p>');
    }
    else {
        print('<p align="left">');
        print('<input type="submit" id="submit" value="Next >" name="b_connections_next">');
        print('<br>');
        print('<font size="2"><i>Click the above Next button to go to next screen. Use browser\'s back button to return to previous screen if needed</i></font>');
        print('<p>');
    }
    ?>
</body>
</html>
