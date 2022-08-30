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
        <b>Follow below steps to make your execution logs permanent in hostname webserver.</b><br>
        <hr>
        <p>
            copy_command = "robocopy \\\\$getvmname\\GMPOautomation\\NGGMPODriver\\${getvmfolder} C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder\\  /NFL /NP /LOG+:$robo_log_file"
            <br>E.g. copy_command = robocopy \\GMPOautotest6-w7\GMPOautomation\NGGMPODriver\allure-results C:\xampp\htdocs\GMPO\reports\01.GMPO_4.0_LA\test\ /NFL /NP /LOG+:robolog.txt
            <hr>
            allure_command = "cd C:\\xampp\\htdocs\\GMPO\\reports\\$getreleasename\\$getdestfolder && START /B allure generate . --clean -o allure-report"
            <br>allure_command = cd C:\xampp\htdocs\GMPO\reports\01.GMPO_4.0_LA\test && START /B allure generate . --clean -o allure-report
            <br>Report successfully generated to allure-report
            
            <hr>
            E.g. http://hostname-win10.GMPO.com/GMPO/reports/01.GMPO_4.0_LA/test/allure-report/index.html
        </p>
        
        <hr>
    </td>
</tr>


</table>

</div>

</form>
</body>
</html>
