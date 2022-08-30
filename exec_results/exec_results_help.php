<html>
<head>
<link rel="stylesheet" href="../style/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

<meta name="viewport" content="width=device-width, initial-scale=1">

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
<div class='w3-container w3-teal' style='text-align:center; margin:0 auto;'>
    <h2><img align='left' border='0' alt='GMPO' src='../images/GMPO-logo.png' width='70' height='40'>Execution Logs Help</h2>
</div>

<div class='w3-card-4' style='width:70%; margin:50 auto;'>
    <div class='w3-container w3-teal'>
        <h2>Steps to Update Execution logs</h2>
    </div>
    
<table class='w3-container' style="width:100%">
<tr>
    
    <td class='w3-label w3-text-teal'>
        <b>Follow below steps to make your execution logs permanent in hostname webserver</b><br>
        <hr>
        <ol>
        <li>VNC Viewer -> <b>hostname-win10.GMPO.com</b></li>
        <li>Windows Explorer -> C:\xampp\htdocs\GMPO\reports\</li>
        <li>Go to 'release-folder'. e.g. 02.GMPO_4.0_GA</li>
        <li>Create New-Folder -> {YYYYmmddHHMMSS}_{buildNumber}_{text}. e.g.: 20200423180501_GMPO786_gravity_uiux</li>
        <li>Copy your execution files from VM to hostname folder created in above step</li>
        <li>Open cmd and cd to above folder</li>
        <li>Run this command: <b>allure generate . --clean -o allure-report</b></li>
        <li>Verify your results are available via weblink. Open using any web-browser (chrome):<br>
        http://hostname-win10.GMPO.com/GMPO/reports/{release-folder}/{folder-name}/allure-report/index.html<br>
        Example: http://hostname-win10.GMPO.com/GMPO/reports/02.GMPO_4.0_GA/ts_xyz/allure-report/index.html<br>
        <!--<font size="1"><i>Each link corresponds to results for that build. Clicking will open it in new browser tab<br><br> 
        <font size="1"><i> Clicking will open it in new browser tab. If you get error 'Object not found!' that means the allure results are not yet generated for that directory.<br>
        RI owner will generate it once the execution is over or ask admin to get it generated.
        For any question, contact gmpoemailid@GMPO.com or GMPO-india-test@GMPO.com
        </i></font>
        -->
        
        
    </td>
</tr>


</table>

</div>

</form>
</body>
</html>
