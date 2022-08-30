<html>
	<head>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
	<title>YAML Creator</title>
	</head>
	<body>
    <script language="javascript">
        function goBack() {
            window.history.go(-1);
        }
    </script>
    <script language="javascript">
        var jdsu_count = 0;
        var spirent_count = 0;
        var digit = 0;
        function myPutTgenName(obj) {
            var id = obj.id;
            var tname = obj.value;
            
            id = id.split("tgens_type_")[1];
            
            if (tname == "JDSU") {
                jdsu_count++;
                digit = jdsu_count;
                document.getElementById("tgens_connectortype_"+id).value = "";
                document.getElementById("tgens_connectortype_"+id).style.backgroundColor = '#FFFF99';
                document.getElementById("tgens_connectortype_"+id).readOnly = false;
            }
            else if (tname == "SPIRENT") {
                spirent_count++;
                digit = spirent_count;
                //document.getElementById("tgens_connectortype_"+id).disabled = true;  // causes issue with POST passing values
                document.getElementById("tgens_connectortype_"+id).value = "NA";
                document.getElementById("tgens_connectortype_"+id).style.backgroundColor = 'silver';
                document.getElementById("tgens_connectortype_"+id).readOnly = true;
            }
            else {
                digit = "";
                document.getElementById("tgens_connectortype_"+id).value = "";
                document.getElementById("tgens_connectortype_"+id).style.backgroundColor = '#FFFF99';
                document.getElementById("tgens_connectortype_"+id).readOnly = false;
            }
            
            var x = document.getElementById("tgens_type_"+id).value;
            
            document.getElementById("tgens_name_"+id).value= x + digit;
            //document.getElementById("tgens_name_"+id).disabled = true;
            
        }
    </script>

    <form name="3_tgens" action="4_connections.php" method="post">
    
<?php
	// Pass all POST variables
    foreach ($_POST as $key => $value) {
        //print($key . " => " . $value . "<br>");
        print('<input type="hidden" name="' . $key .'" value="' . trim($value) . '"/>');
    }
    
    // Verify all the values passed from previous screen
    $errors = array();
    $nodes_info_to_collect = array('nodes_hostname' => 'Hostname', 
                                   'nodes_alias' => 'Alias', 
                                   'nodes_rp0console' => 'RP0 Console', 
                                   //'nodes_rp1console' => 'RP1 Console', 
                                   'nodes_calv0console' => 'Calvados Console', 
                                   //'nodes_calv1console' => 'Calv-Stby Console', 
                                   'nodes_virtualip' => 'virtual_ip',
                                   'nodes_ntpip' => 'ntp_ip');
    for ($i=1;$i<=$_POST['home_nodes'];$i++) {
        $missingkeys = array();
        $b_missing = false;
        foreach($nodes_info_to_collect as $key => $value) {
            if (trim($_POST[$key.'_'.$i]) == "") {
                $b_missing = true;
                array_push($missingkeys,$key);
            }
        }
        if ($b_missing) {
            array_push($errors, "Please provide following mandatory values for Node-" . $i .":" . implode(', ',$missingkeys));
        }
    }
    
    $nodes_info_check_console = array('nodes_rp0console' => 'RP0 Console', 
                                      'nodes_rp1console' => 'RP1 Console', 
                                      'nodes_calv0console' => 'Calvados Console', 
                                      'nodes_calv1console' => 'Calv-Stby Console');
    for ($i=1;$i<=$_POST['home_nodes'];$i++) {
        foreach($nodes_info_check_console as $key => $value) {
            if (array_key_exists($key . '_' . $i, $_POST)) {
                if (!(trim($_POST[$key.'_'.$i]) == "")) {
                    // check it contains :
                    if (strpos($_POST[$key.'_'.$i], ':') > 0) {
                        $console_parts = explode(':', $_POST[$key.'_'.$i]);
                        if(!filter_var($console_parts[0], FILTER_VALIDATE_IP)) {
                           array_push($errors, "Not a valid IP Address. Please correct it for Node-" . $i .":" . $key  ."=>" . $_POST[$key.'_'.$i]);
                        }
                        else if (!is_numeric(trim($console_parts[1]))) {
                            array_push($errors, "Not a valid Port. Please correct it for Node-" . $i .":" . $key  ."=>" . $_POST[$key.'_'.$i]);
                        }
                    }
                    else {
                        array_push($errors, "Console detail should be in the format: <b>IP:Port</b>. Please correct it for Node-" . $i .":" . $key  ."=>" . $_POST[$key.'_'.$i]);
                    }
                }
            }
            //else {
                //print('SKIPPED' . $key);
                //exit;
            //}
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
        
        //if (($_POST['browser_type'] == 'Chrome') || ($_POST['browser_type'] == 'Firefox')) {
        if (($_POST['browser_type'] == 'Chrome')) {
            print('<p><button onclick="goBack()"> < Back </button></p>');
        }
        else {
            print('<br><b>Press BACK button on the browser and try again.</b>');
        }
        exit;
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
            Tgens Information
            </span>
            <br><img border="0" alt="STEP3" src="./images/step3.png" width="500" height="70">
			</p>
        </th>
	</tr>
    <tr>
        <td>
			<b>Please specify all the below information about all the Tgens.</b><br>
			<font size="1"><i>Connector Type is needed only for JDSU and only if it is 'SFP1' else you can leave it blank</i></font>
		</td>
    </tr>
    <tr>
        <td>
        
        <!-- <table border="2" width=100% cellpadding="6"> -->
        <table class="table-style-two">
        <tr>
            <th>Tgens Information</th>
            <?php 
                for($i=1;$i<=$_POST['home_tgens'];$i++) {
                    print('<th>Tgen-' . $i . '</th>');
                } 
            ?>
        </tr>
        
        <?php
            print('<tr>');
            print('<td>'. '<b>Tgen Type:*</b><br>e.g.: JDSU/SPIRENT' .'</td>');
            for ($i=1;$i<=$_POST['home_tgens'];$i++) {
                print('<td align="center">');
                print('<select id="tgens_type_' . $i .'" name="tgens_type_' . $i .'" onchange="myPutTgenName(this)">');
                print('<option value="">Select Tgen Type</option>');
                print('<option value="JDSU">JDSU</option>');
                print('<option value="SPIRENT">SPIRENT</option>');
                print('</select></td>');
            }
            print('</tr>');
            
            $tgens_info_to_collect = array('tgens_ip' => '<b>IP:*</b><br>e.g.: 10.106.201.43', 
                                           'tgens_connectortype' => '<b>Connector Type (SFP1?):</b><br>Specify <b>SFP1</b> if JDSU\'s connector type is SFP1<br>Leave blank for anything else');
            foreach($tgens_info_to_collect as $key => $value) {
                print('<tr>');
                print('<td>'. $value .'</td>');
                for ($i=1;$i<=$_POST['home_tgens'];$i++) {
                    print('<td  align="center"><input type="text" id="' . $key . '_' . $i .'" name="' . $key . '_' . $i .'"></td>');
                }
                print('</tr>');
            }
            
            print('<tr>');
            print('<td>'. '<b>Name/Type:</b><br>e.g.: JDSU1/JDSU2/SPIRENT1' .'</td>');
            for ($i=1;$i<=$_POST['home_tgens'];$i++) {
                print('<td  align="center"><input type="text" readonly="readonly" style="background-color:silver;" id="tgens_name_' . $i .'" name="tgens_name_' . $i .'"></td>');
            }
            print('</tr>');
            
        ?>
        </table>
        </td>
    </tr>
    </table>
    
    <!--   Submit Button 
	<p align="left">
    <button onclick="goBack()"> < Back </button>
    <input type="submit" value="Next >" name="b_tgens_next"></p>
    ---->
    <!--   Back-Next Button ---->
    <?php
    //if (($_POST['browser_type'] == 'Chrome') || ($_POST['browser_type'] == 'Firefox')) {
    if (($_POST['browser_type'] == 'Chrome')) {
        print('<p align="left">');
        print('<button onclick="goBack()"> < Back </button>');
        print('&nbsp;&nbsp;');
        print('<input type="submit" id="submit" value="Next >" name="b_tgens_next">');
        print('<p>');
    }
    else {
        print('<p align="left">');
        print('<input type="submit" id="submit" value="Next >" name="b_tgens_next">');
        print('<br>');
        print('<font size="2"><i>Click the above Next button to go to next screen. Use browser\'s back button to return to previous screen if needed</i></font>');
        print('<p>');
    }
    
    // print('<p align="left">');
    // print('<button onclick="goBack()"> < Back </button>');
    // print('&nbsp;&nbsp;');
    // print('<button type="submit" value="Next >"> Next > </button>');
    // //print('<input type="submit" id="submit" value="Next >" name="b_tgens_next">');
    // print('<p>');
    ?>
    
    
</body>
</html>
