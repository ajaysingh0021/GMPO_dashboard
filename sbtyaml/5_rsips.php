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
    <form name="5_rsips" action="6_create.php" method="post">
    
<?php
    // Pass all the POST variables
    foreach ($_POST as $key => $value) {
        //print($key . " => " . $value . "<br>");
        print('<input type="hidden" name="' . $key .'" value="' . trim($value) . '"/>');
    }
    
    // Verify all the values passed from previous screen
    // Verify that there should be atleast 1 connection available
    $errors = array();
    $b_populated = false;
    foreach($_POST as $key=>$value) {
        if ((substr($key, 0, 6) === 'count_') && trim($value)) {
            $b_populated = true;
            break;
        }
    }
    if (!$b_populated) {
        array_push($errors, "No connections specified between nodes. Please specify the connections correctly to create the yaml.");
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
?>

	<!-- <table border="1" cellpadding="6" cellspacing="1"> -->
    <table class="table-style-one">
	
	<tr>
        <th colspan="2" height="30">
			<p class=MsoNormal style='text-align:center'><span
			style='font-size:28.0pt;font-family:US;text-decoration:bold;
			font-weight:bold;language:EN'>
            <img align="left" border="0" alt="STEP1" src="./images/GMPO-logo.png" width="70" height="40">
            Specify RSIPs</span>
            <br><img border="0" alt="STEP5" src="./images/step5.png" width="500" height="70">
			</p>
		</th>
	</tr>
    <tr>
        <td>
			<b>Please specify the rsips of the connections between Nodes-Nodes & Nodes-Tgens</b><br>
			<font size="1"><i>Do not leave any field as blank</i></font>
		</td>
    </tr>
    
    <?php
        $physical_links_count = 1;
        $tgen_for_utnls = 1;
        $utnls_link_start = 1;
        
        $utnls_link_start = 1;
        $utnls_link_start_src = 1;
        $utnls_link_start_dst = 1;
        
        // Code for Unmonitored tunnel
        // If SPIRENT is present then use tgenspirent else use JDSU
        // Find if spirent is added as a tgen
        $b_utnls_on = false;
        if (intval($_POST['home_utnls']) > 0) {
            $b_utnls_on = true;
            for($u=1;$u<=intval($_POST['home_tgens']);$u++) {
                $key = $_POST['tgens_name_' . $u];
                if (strtolower(substr($key, 0, 4)) === 'spir') {
                    $tgen_for_utnls = $u;   // 2
                    break;
                }
            }
        }
        
        // Create the combinations of nodes and tgens to specify the connection counts
        for($i=1;$i<=$_POST['home_nodes'];$i++) {
            // Nodes to Nodes
            $key = 'combn_nodes_nodes';
            $m=$i+1;
            for($j=$m;$j<=$_POST['home_nodes'];$j++) {
                $node_combn = 'Node' . $i . '_' . 'Node' . $j;      // Here the dilimiter is changed to _ from - in previous screen
                $node_combn_rev = 'Node' . $j . '_' . 'Node' . $i;      // Here the dilimiter is changed to _ from - in previous screen
                
                $node_hname_combn = $_POST['nodes_hostname_' . $i] . '-' . $_POST['nodes_hostname_' . $j];
                $node_hname_combn_field = 'count_' . $_POST['nodes_hostname_' . $i] . '-' . $_POST['nodes_hostname_' . $j];
                if (intval(trim($_POST[$node_hname_combn_field])) > 0) {
                    print('<tr>');
                    print('<td>');
                    print('<table class="table-style-four">');
                    
                    print('<tr>');
                        print('<th>Link Alias</th>');
                        print('<th>Node' . $i . '/' . $_POST['nodes_hostname_'.$i] . '/' . strtolower($_POST['nodes_alias_'.$i]) . '</th>');
                        print('<th>Node' . $j . '/' . $_POST['nodes_hostname_'.$j] . '/' . strtolower($_POST['nodes_alias_'.$j]) . '</th>');
                        print('<th>Link Type</th>');
                        print('<th>Reverse Link Alias</th>');
                        print('<th>Link Number</th>');
                    print('</tr>');
                    
                    $link_count = 1;
                    for($x=1;$x<=intval(trim($_POST[$node_hname_combn_field]));$x++) {
                        print('<tr>');
                            print('<td align="center">' . strtolower($_POST['nodes_alias_'.$i]) . '_' . strtolower($_POST['nodes_alias_'.$j]) . '_nni_' . $link_count . '</td>');
                            
                            print('<td align="center"><input type="text" name="rsips_rsip_' . $node_combn . '_' . $link_count .'"></td>');
                            print('<td align="center"><input type="text" name="rsips_rsip_' . $node_combn_rev . '_' . $link_count .'"></td>');
                            
                            //print('<td align="center"><input type="text" name="rsips_link_' . $node_combn . '_' . $link_count .'"></td>');
                            print('<td align="center">');
                            print('<select name="rsips_link_' . $node_combn . '_' . $link_count .'">');
                            print('<option value="">Select Link Type</option>');
                            print('<option value="otn-10G">10G</option>');
                            print('<option value="otn-40G">40G</option>');
                            print('<option value="otn-100G">100G</option>');
                            print('<option value="otn-200G">200G</option>');
                            print('</select></td>');
                            
                            print('<td align="center">' . strtolower($_POST['nodes_alias_'.$j]) . '_' . strtolower($_POST['nodes_alias_'.$i]) . '_nni_' . $link_count . '</td>');
                            print('<td align="center">' . $physical_links_count . '</td>');
                            
                            print('<input type="hidden" name="rsips_plink_' . $node_combn . '_' . $link_count . '" value=' . $physical_links_count . '>');
                            
                            $link_count = $link_count + 1;
                            $physical_links_count = $physical_links_count + 1;
                        print('</tr>');
                    }
                    print('</table>');
                    print('</td>');
                    print('</tr>');
                }
            }
            
            // Nodes to Tgens
            $key = 'combn_nodes_tgens';
            for($j=1;$j<=$_POST['home_tgens'];$j++) {
                $node_combn = 'Node' . $i . '_' . 'Tgen' . $j;      // Here the dilimiter is changed to _ from - in previous screen
                $node_combn_rev = 'Tgen' . $j . '_' . 'Node' . $i;      // Here the dilimiter is changed to _ from - in previous screen
                
                $node_hname_combn = $_POST['nodes_hostname_' . $i] . '-' . $_POST['tgens_name_' . $j];
                $node_hname_combn_field = 'count_' . $_POST['nodes_hostname_' . $i] . '-' . $_POST['tgens_name_' . $j];
                if (intval(trim($_POST[$node_hname_combn_field])) > 0) {
                    print('<tr>');
                    print('<td>');
                    print('<table class="table-style-six">');
                    
                    print('<tr>');
                        print('<th>Link Alias</th>');
                        print('<th>Node' . $i . '/' . $_POST['nodes_hostname_'.$i] . '/' . strtolower($_POST['nodes_alias_'.$i]) . '</th>');
                        print('<th>Tgen' . $j . '/' . $_POST['tgens_name_'.$j] . '/' . strtolower($_POST['tgens_alias_'.$j]) . '</th>');
                        print('<th>Link Type</th>');
                        print('<th>Reverse Link Alias</th>');
                        print('<th>Link Number</th>');
                    print('</tr>');
                    
                    $link_count = 1;
                    for($x=1;$x<=intval(trim($_POST[$node_hname_combn_field]));$x++) {
                        print('<tr>');
                            print('<td align="center">' . strtolower($_POST['nodes_alias_'.$i]) . '_' . strtolower($_POST['tgens_alias_'.$j]) . '_uni_' . $link_count . '</td>');
                            print('<td align="center"><input type="text" name="rsips_rsip_' . $node_combn . '_' . $link_count .'"></td>');
                            
                            //print('<td align="left"><input type="text" class="text_style_one" name="rsips_rsip_' . $node_combn_rev . '_' . $link_count .'">');
                            if (strpos(strtolower($_POST['tgens_alias_'.$j]), 'jdsu') > 0) {
                                print('<td align="left"><input type="text" class="text_style_one" name="rsips_rsip_' . $node_combn_rev . '_' . $link_count .'">');
                                print('<input type="checkbox" name="rsips_chbx_' . $node_combn . '_' . $link_count .'" value="'. $physical_links_count .'">Deep Analysis Port');
                            }
                            else {
                                print('<td align="left"><input type="text" name="rsips_rsip_' . $node_combn_rev . '_' . $link_count .'">');
                            }
                            print('</td>');
                            
                            print('<td align="center">');
                            print('<select name="rsips_link_' . $node_combn . '_' . $link_count .'">');
                            print('<option value="">Select Link Type</option>');
                            print('<option value="ethernet-10G">10G</option>');
                            print('<option value="ethernet-40G">40G</option>');
                            print('<option value="ethernet-100G">100G</option>');
                            print('<option value="ethernet-200G">200G</option>');
                            print('</select></td>');
                            
                            print('<td align="center">' . strtolower($_POST['tgens_alias_'.$j]) . '_' . strtolower($_POST['nodes_alias_'.$i]) . '_uni_' . $link_count . '</td>');
                            print('<td align="center">' . $physical_links_count . '</td>');
                            
                            print('<input type="hidden" name="rsips_plink_' . $node_combn . '_' . $link_count . '" value=' . $physical_links_count . '>');
                            
                            $link_count = $link_count + 1;
                            $physical_links_count = $physical_links_count + 1;
                        print('</tr>');
                    }
                    
                    print('</table>');
                    print('</td>');
                    print('</tr>');
                }
                if ($b_utnls_on) {
                    if ($tgen_for_utnls == $j) {
                        $utnls_link_start = $link_count;
                        if (strtolower($_POST['nodes_alias_'.$i]) === 'src') {
                            $utnls_link_start_src = $link_count;
                        }
                        if (strtolower($_POST['nodes_alias_'.$i]) === 'dst') {
                            $utnls_link_start_dst = $link_count;
                        }
                    }
                }
            }
        }
        
        // If # of Unmonitored tunnels is > 0 then ask for UNI rsips on src and dst - home_utnls
        $no_of_utnls = intval($_POST['home_utnls']);
        if ($no_of_utnls > 0) {
            print('<tr>');
            print('<td>');
            print('<b>Please specify UNI ports at src and dst for the unmonitored tunnels to be created</b>');
            print('</td>');
            print('</tr>');
            
            print('<tr>');
            print('<td>');
            print('<table class="table-style-six">');
            
            print('<tr>');
                print('<th>Link Alias</th>');
                print('<th>RSIP for unmonitored tunnel</th>');
                print('<th>Tgen' . $tgen_for_utnls . '/' . $_POST['tgens_name_'.$tgen_for_utnls] . '/' . strtolower($_POST['tgens_alias_'.$tgen_for_utnls]) . '</th>');
                print('<th>Link Type</th>');
                print('<th>Reverse Link Alias</th>');
                print('<th>Link Number</th>');
            print('</tr>');
            
            // Find $i for src and dst
            $src_no = 1;
            $dst_no = 2;
            for ($d=1 ; $d<=$_POST['home_nodes'] ; $d++) {
                if ($_POST['nodes_alias_' . $d] === 'src') {
                    $src_no = $d;
                }
                if ($_POST['nodes_alias_' . $d] === 'dst') {
                    $dst_no = $d;
                }
            }
            $i = 1;
            $utnl = 0;
            //print('<br>--'.$utnls_link_start_src);
            //print('<br>--'.$utnls_link_start_dst.'<br>');
            foreach ([$src_no,$dst_no] as $n) {
                if (strtolower($_POST['nodes_alias_'.$n]) === 'src') {
                    $utnls_link_start = $utnls_link_start_src;
                }
                else {
                    $utnls_link_start = $utnls_link_start_dst;
                }
                
                $node_combn = 'Node' . $n . '_' . 'Tgen' . $tgen_for_utnls;      // Node1 is considered as src, Node2 as dst
                $node_combn_rev = 'Tgen' . $tgen_for_utnls . '_' . 'Node' . $n;
                
                for($x=1 ; $x<=$no_of_utnls ; $x++) {
                    print('<tr>');
                    //src: UNI-1 (src_tgenspirent1_uni_4)
                    print('<td align="center">'.strtolower($_POST['nodes_alias_'.$n]).': UNI-' . $x . '('.strtolower($_POST['nodes_alias_'.$n]).'_' .  strtolower($_POST['tgens_alias_'.$tgen_for_utnls]) . '_uni_' . $utnls_link_start . ')</td>');
                    print('<td align="center"><input type="text" name="rsips_rsip_' . $node_combn . '_' . $utnls_link_start .'"></td>');
                    
                    print('<td align="center">' . 'x/'.$utnl . '</td>');
                    
                    print('<td align="center">ethernet-10G'.'</td>');
                    print('<td align="center">' . strtolower($_POST['tgens_alias_'.$tgen_for_utnls]) . '_' . strtolower($_POST['nodes_alias_'.$n]) . '_uni_' . $utnls_link_start . '</td>');
                    print('<td align="center">' . $physical_links_count . '</td>');
                    
                    print('<input type="hidden" name="rsips_rsip_' . $node_combn_rev . '_' . $utnls_link_start . '" value=x/' . $utnl .'>');
                    print('<input type="hidden" name="rsips_link_' . $node_combn . '_' . $utnls_link_start . '" value=ethernet-10G >');
                    print('<input type="hidden" name="rsips_plink_' . $node_combn . '_' . $utnls_link_start . '" value=' . $physical_links_count . '>');
                    
                    $utnl = $utnl + 1;
                    $utnls_link_start = $utnls_link_start + 1;
                    $physical_links_count = $physical_links_count + 1;
                    print('</tr>');
                }
            }
            
            
            // print('<tr>');
            // print('<td>');
            // print('<table class="table-style-four">');
            
            // print('<tr>');
                // print('<th>Node Port</th>');
                // print('<th>UNI RSIP</th>');
                // print('<th></th>');
                // print('<th>Node Port</th>');
                // print('<th>UNI RSIP</th>');
            // print('</tr>');
            // for ($k=1;$k<=$_POST['home_utnls'];$k++) {
                // print('<tr>');
                // print('<td align="center">src: UNI-' . $k . '</td>');
                // print('<td align="center"><input type="text" name="rsips_utip_src_' . $k .'"></td>');
                // print('<td></td>');
                // print('<td align="center">dst: UNI-' . $k . '</td>');
                // print('<td align="center"><input type="text" name="rsips_utip_dst_' . $k .'"></td>');
                // print('</tr>');
            // }
            print('</table>');
            
            print('</td>');
            print('</tr>');
            
        }
        
    ?>
    </table>
    
    <!--   Submit Button 
	<p align="left">
    <button onclick="goBack()"> < Back </button>
    <input type="submit" value="Create YAML" name="b_rsips_next"></p>
    ---->
    <!--   Back-Next Button ---->
    <?php
    if (($_POST['browser_type'] == 'Chrome') || ($_POST['browser_type'] == 'Firefox')) {
        print('<p align="left">');
        print('<button onclick="goBack()"> < Back </button>');
        print('&nbsp;&nbsp;');
        print('<input type="submit" id="submit" value="Next >" name="b_rsips_next">');
        print('<p>');
    }
    else {
        print('<p align="left">');
        print('<input type="submit" id="submit" value="Next >" name="b_rsips_next">');
        print('<br>');
        print('<font size="2"><i>Click the above Next button to go to next screen. Use browser\'s back button to return to previous screen if needed</i></font>');
        print('<p>');
    }
    ?>
</body>
</html>
