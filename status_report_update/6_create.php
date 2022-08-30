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
    <form name="6_create" action="7_download.php" method="post">
    
<?php
    // Set IST as default timezone
    date_default_timezone_set('Asia/Calcutta');
    
    // Pass all the POST variables
    foreach ($_POST as $key => $value) {
        //print($key . " => " . $value . "<br>");
        print('<input type="hidden" name="' . $key .'" value="' . trim($value) . '"/>');
    }
    
    // Verify all the values passed from previous screen
	$errors = array();
    $b_not_numeric = false;
    
    $missingkeys = array();
    $b_missing = false;
    foreach($_POST as $key=>$value) {
        if (substr($key, 0, 6) === 'rsips_') {
            if (!trim($value)) {
                $b_missing = true;
                if (substr($key, 0, 11) === 'rsips_rsip_') {
                    $push_key = '&nbsp;&nbsp;&nbsp;&nbsp;' . substr($key, 11) . ' - RSIP';
                }
                else if (substr($key, 0, 11) === 'rsips_link_') {
                    $push_key = '&nbsp;&nbsp;&nbsp;&nbsp;' . substr($key, 11) . ' - Link-Type';
                }
                array_push($missingkeys,$push_key);
            }
        }
    }
    if ($b_missing) {
        array_push($errors, "Please provide following mandatory values:<br>" . implode('<br>',$missingkeys));
    }
    
    // Get all POST variables where key name starts with 'rsips_': Verify formatting of 'rsips_rsip_' and 'rsips_link_'
    foreach($_POST as $key=>$value) {
        if ((substr($key, 0, 6) === 'rsips_') && trim($value)) {
            if (substr($key, 0, 11) === 'rsips_rsip_') {
                // Check for:
                // 1. atlease 3 slashes 
                // 2. a digit after last slash
                // 3. all digits between slashes
                //print('Checking rsip ' . $key . '<br>');
                // if there are 4 slashes that means it is a BO port - insert bo_ before linkno
                $xx = substr($key, 11);
                $parts = explode('_', $xx);
                $firstnode = $parts[0];          // Node1/Tgen1
                if (substr($firstnode, 0, 4) === 'Node') {
                    // rsip should have 4 or 5 octets only - 1/2/3/4 or 1/2/3/4/5
                    $rsip_parts = explode('/', $value);
                    if (count($rsip_parts) < 4) {
                        array_push($errors, 'RSIP does not look correct. Nodes rsips should have atleast 3 slashes (e.g. 0/1/0/2) : \'' . $value . '\'');
                    }
                    else if (count($rsip_parts) > 5) {
                        array_push($errors, 'RSIP does not look correct. Node rsips should not have more than 4 slashes (e.g. 0/1/0/2 or 0/1/0/2/1) : \'' . $value . '\'');
                    }
                    // if (intval(count($rsip_parts)) === 5) {
                        // if (($_POST['rsips_link_' . $xx] === 'ethernet-10G') || ($_POST['rsips_link_' . $xx] === 'otn-10G')) {
                            // array_push($errors, 'For BO link, select link type as 100G: \'' . $xx . '\'');
                        // }
                    // }
                    $b_not_numeric = false;
                    foreach ($rsip_parts as $val) {
                        if(!is_numeric($val)) {
                            $b_not_numeric = true;
                        }
                    }
                    if ($b_not_numeric) {
                        array_push($errors, 'RSIP does not look correct. It should contain all numeric digits. (e.g. 0/1/0/3) : \'' . $value . '\'');
                    }
                }
                else {
                    $rsip_parts = explode('/', $value);
                    if (count($rsip_parts) < 2) {
                        array_push($errors, 'RSIP does not look correct. Tgen rsips should have atleast 1 slash (e.g. 4/1) : \'' . $value . '\'');
                    }
                    else if (count($rsip_parts) > 2) {
                        array_push($errors, 'RSIP does not look correct. Tgen rsips should not have more than 1 slash (e.g. 4/2) : \'' . $value . '\'');
                        //print('--' . count($rsip_parts));
                    }
                }
            }
            else if (substr($key, 0, 11) === 'rsips_link_') {
                // rsip link type
                // Check for:
                // Should not be left unset - value should not be blank
                if (!trim($value)) {
                    array_push($errors, 'Please select a Link-Type value from drop down for link: \'' . substr($key, 11) . '\'');
                }
            }
            else if (substr($key, 0, 12) === 'rsips_plink_') {
                // Check for:
                // these are physical links. what can we check here?
            }
            // else {
                // array_push($errors, 'ERROR: Inform gmpo admin about this error. Improper POST variable found on create screen: ' . $key . '-' . $value);
            // }
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
?>
	<!-- <table border="1" cellpadding="6" cellspacing="1"> -->
    <table class="table-style-one" width=50%>
	
	<tr>
        <th colspan="2" height="30">
			<p class=MsoNormal style='text-align:center'><span
			style='font-size:28.0pt;font-family:US;text-decoration:bold;
			font-weight:bold;language:EN'>
            <img align="left" border="0" alt="STEP1" src="./images/GMPO-logo.png" width="70" height="40">
            YAML</span>
            <br><img border="0" alt="STEP6" src="./images/step6.png" width="500" height="70">
			</p>
		</th>
	</tr>
    <tr>
        <td>
			<b>Yaml is ready. Click the download link to download it.</b><br>
			<font size="1"><i>Save to your local directory</i></font>
		</td>
    </tr>
    
    <?php
        $timestamp = date("YmdHis");
        //$timestamp = 1;
        $owner_name = str_replace(' ', '', $_POST['home_ownername']);
        //$file_name = 'new_yaml_' . $timestamp . '.yaml';
        $file_name = 'yaml_files/' . $timestamp . '_' . $owner_name . '.yaml';
        
        $yamlFH = fopen($file_name, "w") or die("Unable to open file!");
        
        fwrite($yamlFH, 'testbed:' . "\r\n");
        fwrite($yamlFH, '    name: ' . $_POST['home_projectname'] . "\r\n");
        fwrite($yamlFH, '    alias: ' . $_POST['home_projectalias'] . "\r\n");
        fwrite($yamlFH, '    custom:' . "\r\n");
        fwrite($yamlFH, '        owner: ' . $_POST['home_ownername'] . "\r\n");
        fwrite($yamlFH, '        Mail: ' . $_POST['home_owneremail'] . "\r\n");
        
        fwrite($yamlFH, 'devices:' . "\r\n");
        for ($i=1;$i<=$_POST['home_nodes'];$i++) {
            fwrite($yamlFH, '    ' . $_POST['nodes_hostname_' . $i] . ':' . "\r\n");
            fwrite($yamlFH, '        type: router' . "\r\n");
            fwrite($yamlFH, '        alias: ' . strtolower($_POST['nodes_alias_' . $i]) . "\r\n");
            fwrite($yamlFH, '        tacacs:' . "\r\n");
            fwrite($yamlFH, '            username: root' . "\r\n");
            fwrite($yamlFH, '        connections:' . "\r\n");
            
            fwrite($yamlFH, '            a:' . "\r\n");
            fwrite($yamlFH, '                protocol: telnet' . "\r\n");
            $cons_port = explode(':',$_POST['nodes_rp0console_' . $i] . "\r\n");
            fwrite($yamlFH, '                ip: ' . trim($cons_port[0]) . "\r\n");
            fwrite($yamlFH, '                port: ' . trim($cons_port[1]) . "\r\n");
            
            if (trim($_POST['nodes_rp1console_' . $i]) != '') {
                fwrite($yamlFH, '            b:' . "\r\n");
                fwrite($yamlFH, '                protocol: telnet' . "\r\n");
                $cons_port = explode(':',$_POST['nodes_rp1console_' . $i] . "\r\n");
                fwrite($yamlFH, '                ip: ' . trim($cons_port[0]) . "\r\n");
                fwrite($yamlFH, '                port: ' . trim($cons_port[1]) . "\r\n");
            }
            
            fwrite($yamlFH, '            alt:' . "\r\n");
            fwrite($yamlFH, '                protocol: telnet' . "\r\n");
            $cons_port = explode(':',$_POST['nodes_calv0console_' . $i] . "\r\n");
            fwrite($yamlFH, '                ip: ' . trim($cons_port[0]) . "\r\n");
            fwrite($yamlFH, '                port: ' . trim($cons_port[1]) . "\r\n");
            
            fwrite($yamlFH, '        custom:' . "\r\n");
            fwrite($yamlFH, '            virtual_ip: ' . $_POST['nodes_virtualip_' . $i] . "\r\n");
            
            if (trim($_POST['nodes_mgmtip_' . $i]) != '') {
                fwrite($yamlFH, '            mgmt_ip: ' . $_POST['nodes_mgmtip_' . $i] . "\r\n");
            }
            if (trim($_POST['nodes_mgmtip1_' . $i]) != '') {
                fwrite($yamlFH, '            mgmt_ip1: ' . $_POST['nodes_mgmtip1_' . $i] . "\r\n");
            }
            if (trim($_POST['nodes_emsip_' . $i]) != '') {
                fwrite($yamlFH, '            ems_ip: ' . $_POST['nodes_emsip_' . $i] . "\r\n");
            }
            if (trim($_POST['nodes_emsip1_' . $i]) != '') {
                fwrite($yamlFH, '            ems_ip1: ' . $_POST['nodes_emsip1_' . $i] . "\r\n");
            }
            if (trim($_POST['nodes_ntpip_' . $i]) != '') {
                fwrite($yamlFH, '            ntp_server: ' . $_POST['nodes_ntpip_' . $i] . "\r\n");
            }
        }
        
        // Array to store BO links
        $bo_links = array();
        array_push($bo_links,999);
        $dp_links = array();
        array_push($dp_links,999);
        
        for ($i=1;$i<=$_POST['home_tgens'];$i++) {
            fwrite($yamlFH, '    ' . strtoupper($_POST['tgens_name_' . $i]) . ':' . "\r\n");
            fwrite($yamlFH, '        type: tgen' . "\r\n");
            fwrite($yamlFH, '        alias: ' . strtolower($_POST['tgens_alias_' . $i]) . "\r\n");
            fwrite($yamlFH, '        connections:' . "\r\n");
            fwrite($yamlFH, '            a:' . "\r\n");
            fwrite($yamlFH, '                protocol: telnet' . "\r\n");
            fwrite($yamlFH, '                ip: ' . $_POST['tgens_ip_' . $i] . "\r\n");
            if ((trim($_POST['tgens_connectortype_' . $i]) != '') && (strtoupper(substr($_POST['tgens_name_' . $i],0,4)) === 'JDSU')) {
                fwrite($yamlFH, '        custom:' . "\r\n");
                fwrite($yamlFH, '            connector_type: ' . $_POST['tgens_connectortype_' . $i] . "\r\n");
            }
        }
        
        fwrite($yamlFH, 'topology:' . "\r\n");
        
        for ($i=1;$i<=$_POST['home_nodes'];$i++) {
            fwrite($yamlFH, '    ' . $_POST['nodes_hostname_' . $i] . ':' . "\r\n");
            fwrite($yamlFH, '        interfaces:' . "\r\n");
            
            foreach($_POST as $key=>$value) {
                if (substr($key, 0, 11) === 'rsips_rsip_') {
                    $xx = substr($key, 11);
                    //print('xx='.$xx .'<br>');
                    $parts = explode('_', $xx);
                    $firstnode = $parts[0];          // Node1
                    $secondnode = $parts[1];         // Node2/Tgen1
                    $linkno = $parts[2];             // 1/2
                    //print('--- firstnode='.$firstnode .'<br>');
                    //print('--- secondnode='.$secondnode .'<br>');
                    //print('--- linkno='.$linkno .'<br>');
                    if ('Node'.$i == $firstnode) {
                        $rsip = $value;
                        $type = 'dummy';
                        $plink = 1;
                        if (array_key_exists('rsips_link_' . $firstnode . '_' . $secondnode . '_' . $linkno, $_POST)) {
                            $type = $_POST['rsips_link_' . $firstnode . '_' . $secondnode . '_' . $linkno];     // otn-100G
                            $plink = $_POST['rsips_plink_' . $firstnode . '_' . $secondnode . '_' . $linkno];     // 1
                        }
                        else if (array_key_exists('rsips_link_' . $secondnode . '_' . $firstnode . '_' . $linkno, $_POST)) {
                            $type = $_POST['rsips_link_' . $secondnode . '_' . $firstnode . '_' . $linkno];     // otn-100G
                            $plink = $_POST['rsips_plink_' . $secondnode . '_' . $firstnode . '_' . $linkno];     // 1
                        }
                        else {
                            print('ERROR:: Unexpected key search: rsips_link_' . $firstnode . '_' . $secondnode . '_' . $linkno);
                        }
                        $link_band = explode('-', $type);
                        $band_val = $link_band[1];
                        $bandwidth = '';
                        if ($band_val == '10G') {
                            $bandwidth = 'TenGigE';
                        }
                        else if ($band_val == '100G') {
                            $bandwidth = 'HundredGigE';
                        }
                        else if ($band_val == '40G') {
                            $bandwidth = 'FortyGigE';
                        }
                        else {
                            $bandwidth = 'TenGigECheck';
                        }
                        
                        //$alias = 'dummy1';
                        $alias_no = '1';
                        $alias_1 = 'dummy1';
                        $alias_2 = 'dummy2';
                        if (substr($firstnode, 0, 4) === 'Node') {
                            $alias_no = substr($firstnode, 4);
                            $alias_1 = strtolower($_POST['nodes_alias_'.$alias_no]);
                        }
                        if (substr($secondnode, 0, 4) === 'Node') {
                            $alias_no = substr($secondnode, 4);
                            $alias_2 = strtolower($_POST['nodes_alias_'.$alias_no]);
                            $uni_nni = 'nni';
                        }
                        else if (substr($secondnode, 0, 4) === 'Tgen') {
                            $alias_no = substr($secondnode, 4);
                            $alias_2 = strtolower($_POST['tgens_alias_'.$alias_no]);
                            $uni_nni = 'uni';
                        }
                        else {
                            print('ERROR: Undefined variable:' . $secondnode);
                        }
                        // If DP checkbox is set then add _dp_ in alias
                        //print('<br>'. 'rsips_chbx_' . substr($firstnode, 0, 5)  . '_' . substr($secondnode, 0, 5) . '_' . $linkno . '<br>');
                        
                        // if there are 4 slashes that means it is a BO port - insert bo_ before linkno
                        
                        $rsip_parts = explode('/', $rsip);
                        if ((array_key_exists('rsips_chbx_' . substr($firstnode, 0, 5)  . '_' . substr($secondnode, 0, 5) . '_' . $linkno, $_POST)) && 
                           ($_POST['rsips_chbx_' . substr($firstnode, 0, 5)  . '_' . substr($secondnode, 0, 5) . '_' . $linkno])) {
                            //if ($_POST['rsips_chbx_' . substr($firstnode, 0, 5)  . '_' . substr($secondnode, 0, 5) . '_' . $linkno]) {
                            $alias = $alias_1 . '_' . $alias_2 . '_' . $uni_nni . '_dp_' . $linkno;
                            //print('In 1:' . $alias . '<br>');
                            array_push($dp_links,$plink);
                            //}
                            // else {
                                // $alias = $alias_1 . '_' . $alias_2 . '_' . $uni_nni . '_' . $linkno;
                                // print('In 2:' . $alias . '<br>');
                            // }
                        }
                        else if (count($rsip_parts) > 4) {
                            $alias = $alias_1 . '_' . $alias_2 . '_' . $uni_nni . '_bo_' . $linkno;
                            array_push($bo_links,$plink);
                        }
                        else {
                            $alias = $alias_1 . '_' . $alias_2 . '_' . $uni_nni . '_' . $linkno;
                        }
                        
                        fwrite($yamlFH, '            ' . $bandwidth . '-' . $rsip . ':' . "\r\n");
                        fwrite($yamlFH, '                alias: ' . $alias . "\r\n");
                        fwrite($yamlFH, '                link: link_' . $plink . "\r\n");
                        fwrite($yamlFH, '                type: ' . $type . "\r\n");
                    }
                }
                // if (substr($key, 0, 11) === 'rsips_utip_') {
                    // // rsips_utip_src_1 => 0/2/0/1
                    // // rsips_utip_dst_1 => 0/2/0/1
                    // // rsips_utip_src_2 => 0/2/0/2
                    // // rsips_utip_dst_2 => 0/2/0/2
                    // if (substr($key, 11,3) === $_POST['nodes_alias_' . $i]) {
                        
                    // }
                // }
                
                
            }
        }
        //print_r($bo_links);
        
        for ($i=1;$i<=$_POST['home_tgens'];$i++) {
            fwrite($yamlFH, '    ' . strtoupper($_POST['tgens_name_' . $i]) . ':' . "\r\n");
            fwrite($yamlFH, '        interfaces:' . "\r\n");
            foreach($_POST as $key=>$value) {
                if (substr($key, 0, 11) === 'rsips_rsip_') {
                    $xx = substr($key, 11);
                    //print('xx='.$xx .'<br>');
                    $parts = explode('_', $xx);
                    $firstnode = $parts[0];          // Node1
                    $secondnode = $parts[1];         // Node2/Tgen1
                    $linkno = $parts[2];             // 1/2
                    //print('--- firstnode='.$firstnode .'<br>');
                    //print('--- secondnode='.$secondnode .'<br>');
                    //print('--- linkno='.$linkno .'<br>');
                    if ('Tgen'.$i == $firstnode) {
                        $rsip = $value;
                        $type = 'dummy';
                        $plink = 1;
                        if (array_key_exists('rsips_link_' . $firstnode . '_' . $secondnode . '_' . $linkno, $_POST)) {
                            $type = $_POST['rsips_link_' . $firstnode . '_' . $secondnode . '_' . $linkno];     // otn-100G
                            $plink = $_POST['rsips_plink_' . $firstnode . '_' . $secondnode . '_' . $linkno];     // 1
                        }
                        else if (array_key_exists('rsips_link_' . $secondnode . '_' . $firstnode . '_' . $linkno, $_POST)) {
                            $type = $_POST['rsips_link_' . $secondnode . '_' . $firstnode . '_' . $linkno];     // otn-100G
                            $plink = $_POST['rsips_plink_' . $secondnode . '_' . $firstnode . '_' . $linkno];     // 1
                        }
                        else {
                            print('ERROR:: Unexpected key search: rsips_link_' . $firstnode . '_' . $secondnode . '_' . $linkno);
                        }
                        $link_band = explode('-', $type);
                        $band_val = $link_band[1];
                        $bandwidth = '';
                        if ($band_val == '10G') {
                            $bandwidth = 'TenGigE';
                        }
                        else if ($band_val == '100G' or $band_val == '200G') {
                            $bandwidth = 'HundredGigE';
                        }
                        else if ($band_val == '40G') {
                            $bandwidth = 'FortyGigE';
                        }
                        else {
                            $bandwidth = 'HundredGigE';
                        }
                        
                        //$alias = 'dummy1';
                        $alias_no = '1';
                        $alias_1 = 'dummy1';
                        $alias_2 = 'dummy2';
                        if (substr($firstnode, 0, 4) === 'Tgen') {
                            $alias_no = substr($firstnode, 4);
                            $alias_1 = strtolower($_POST['tgens_alias_'.$alias_no]);
                        }
                        if (substr($secondnode, 0, 4) === 'Node') {
                            $alias_no = substr($secondnode, 4);
                            $alias_2 = strtolower($_POST['nodes_alias_'.$alias_no]);
                            $uni_nni = 'uni';
                        }
                        else if (substr($secondnode, 0, 4) === 'Tgen') {
                            $alias_no = substr($secondnode, 4);
                            $alias_2 = strtolower($_POST['tgens_alias_'.$alias_no]);
                            $uni_nni = 'uni';
                        }
                        else {
                            print('ERROR: Undefined variable2:' . $secondnode);
                        }
                        // Find if the plink is a DP link if yes, add dp_ in alias
                        if (array_search($plink, $dp_links) > 0) {
                            $alias = $alias_1 . '_' . $alias_2 . '_' . $uni_nni . '_dp_' . $linkno;
                        }
                        // else {
                            // $alias = $alias_1 . '_' . $alias_2 . '_' . $uni_nni . '_' . $linkno;
                        // }
                        // // Find if the plink is a BO link if yes, add bo_ in alias
                        else if (array_search($plink, $bo_links) > 0) {
                            $alias = $alias_1 . '_' . $alias_2 . '_' . $uni_nni . '_bo_' . $linkno;
                        }
                        else {
                            $alias = $alias_1 . '_' . $alias_2 . '_' . $uni_nni . '_' . $linkno;
                        }
                        
                        fwrite($yamlFH, '            ' . $bandwidth . '-' . $rsip . ':' . "\r\n");
                        fwrite($yamlFH, '                alias: ' . $alias . "\r\n");
                        fwrite($yamlFH, '                link: link_' . $plink . "\r\n");
                        fwrite($yamlFH, '                type: ' . $type . "\r\n");
                    }
                }
            }
        }
        
        fclose($yamlFH);
    ?>
    
    <tr>
        <td>
            <br>
            <p>
                
                <b>YAML Filename:</b><i> <?php print($file_name); ?></i>
                <br><br>
                
                <a href="<?php print($file_name); ?>" download><img border="0" alt="DOWNLOAD" src="./images/download-red.png" width="200" height="60"></a>
            </p>
        </td>
    </tr>
    
    </table>
    <br>
    
    <!--   Submit Button ---->
    <br>
    <p align="left">
    <a href="home.php"><img border="0" alt="HOME" src="./images/home-blue.png" width="70" height="70"></a>
    </p>
    
</body>
</html>
