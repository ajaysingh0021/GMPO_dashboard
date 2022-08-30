<!DOCTYPE html>
<html>
	<head>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
	<title>SBT YAML Creator</title>
	</head>
	<body>
    
    <form name="2_nodes" action="3_tgens.php" method="post">
    <script>
        function goBack() {
            window.history.go(-1);
        }
    </script>
    
<?php
    //<form name="2_nodes" action="3_tgens.php" method="post">
    // Assign the default values
    if (trim($_POST['home_projectname']) == '') {
        $_POST['home_projectname'] = 'GMPO';
    }
    if (trim($_POST['home_projectalias']) == '') {
        $_POST['home_projectalias'] = 'NCS4K';
    }
    if (trim($_POST['home_ownername']) == '') {
        $_POST['home_ownername'] = 'gmpo admin';
    }
    if (trim($_POST['home_owneremail']) == '') {
        $_POST['home_owneremail'] = 'gmpoemailid@GMPO.com';
    }
    
    // Pass all the POST variables
    foreach ($_POST as $key => $value) {
        //print($key . " => " . $value . "<br>");
        print('<input type="hidden" name="' . $key .'" value="' . trim($value) . '"/>');
    }
    
    // Verify all the values passed from previous screen
	$errors = array();
    if (trim($_POST['home_nodes']) == "") {
        array_push($errors, "Please specify Number of Nodes");
	}
    else if (intval(trim($_POST['home_nodes'])) < 1) {
        array_push($errors, "Atleast 2 Nodes are needed");
	}
	if (trim($_POST['home_tgens']) == "") {
        array_push($errors, "Please specify Number of Tgens");
	}
    else if (intval(trim($_POST['home_tgens'])) < 1) {
        array_push($errors, "Atleast 1 Tgen is needed");
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
        //print('<br><b>Press BACK button on the browser and try again.</b>');
        exit;
    }
?>  
    <div>
	<!-- <table border="1" cellpadding="6" cellspacing="1"> -->
    <table class="table-style-one">
	<tr>
        <th colspan="2" height="30">
        <p class=MsoNormal style='text-align:center'><span
			style='font-size:28.0pt;font-family:US;text-decoration:bold;
			font-weight:bold;language:EN'>
            <img align="left" border="0" alt="STEP1" src="./images/GMPO-logo.png" width="70" height="40">
            Nodes Information
            </span>
            <br><img border="0" alt="STEP2" src="./images/step2.png" width="500" height="70">
			</p>
        </th>
	</tr>
    
    <tr>
        <td>
			<b>Please specify all the below information about all the nodes.</b><br>
			<font size="1"><i>
            - Alias of the nodes is pre-populated but can be changed if required.<br>
            - If RP1 is not present on any node, leave the field as blank.<br>
            ^You may specify mgmt_ip or ems_ip based on the connection available on the node. Leave the other as blank.
            </i></font>
		</td>
    </tr>
    <tr>
        <td>
        
        <!-- <table border="2" width=100% cellpadding="6"> -->
        <table class="table-style-two">
        <tr>
            <th>Nodes Information</th>
            <?php 
                for($i=1;$i<=$_POST['home_nodes'];$i++) {
                    print('<th>Node-' . $i . '</th>');
                } 
            ?>
        </tr>
        
        <?php
            
            $nodes_info_to_collect = array('nodes_alias' => '<b>Alias:</b></b><br>e.g.: src/dst/mn1',
                                           'nodes_hostname' => '<b>Hostname:*</b><br>e.g.: R1',
                                           'nodes_rp0console' => '<b>RP0 Console:*</b><br>e.g.: 10.106.201.11:2032', 
                                           'nodes_rp1console' => '<b>RP1 Console:</b><br>e.g.: 10.106.201.11:2034', 
                                           'nodes_calv0console' => '<b>Calvados Console:*</b><br>e.g.: 10.106.201.11:2033', 
                                           //'nodes_calv1console' => '<b>Calv-Stby Console:</b><br>e.g.: 10.106.201.11:2035', 
                                           'nodes_virtualip' => '<b>Virtual IP:*</b><br>e.g.: 10.106.201.95',
                                           'nodes_mgmtip' => '<b>Mgmt IP^:</b><br>e.g.: 10.106.201.84', 
                                           'nodes_mgmtip1' => '<b>Mgmt IP1:</b><br>e.g.: 10.106.201.86', 
                                           'nodes_emsip' => '<b>EMS IP^:</b><br>e.g.: 10.106.201.94', 
                                           'nodes_emsip1' => '<b>EMS IP1:</b><br>e.g.: 10.106.201.96',
                                           'nodes_ntpip' => '<b>NTP Server:*</b><br>e.g.: 10.127.60.201');
            foreach($nodes_info_to_collect as $key => $value) {
                print('<tr>');
                print('<td>'. $value .'</td>');
                for ($i=1;$i<=$_POST['home_nodes'];$i++) {
                    if (!strcmp($key, 'nodes_alias')) {
                        $node = 'src';
                        if ($i == 2) {
                            $node = 'dst';
                        }
                        if ($i > 2) {
                            $j = $i - 2;
                            $node = 'mn' . $j;
                        }
                        print('<td  align="center"><input type="text" name="' . $key . '_' . $i .'" value="' . $node . '"></td>');
                    }
                    else {
                        print('<td  align="center"><input type="text" name="' . $key . '_' . $i .'"></td>');
                    }
                }
                print('</tr>');
            }
        ?>
        </table>
        </td>
    </tr>
    </table>
    <div>
    
    <!--   Back-Next Button ---->
    <?php
    if (($_POST['browser_type'] == 'Chrome') || ($_POST['browser_type'] == 'Firefox')) {
        print('<p align="left">');
        print('<button onclick="goBack()"> < Back </button>');
        print('&nbsp;&nbsp;');
        print('<input type="submit" id="submit" value="Next >" name="b_nodes_next">');
        print('<p>');
    }
    else {
        print('<p align="left">');
        print('<input type="submit" id="submit" value="Next >" name="b_nodes_next">');
        print('<br>');
        print('<font size="2"><i>Click the above Next button to go to next screen. Use browser\'s back button to return to previous screen if needed</i></font>');
        print('<p>');
    }
    ?>
    
</body>
</html>
