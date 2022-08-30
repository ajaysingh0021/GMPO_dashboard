<?php
// mysql_connect("localhost","","");
// mysql_select_db("GMPO_automation");
$db = new PDO('mysql:host=localhost;dbname=GMPO_automation;charset=utf8mb4', 'root', 'gmpoadmin123');


// Open the file [XAMPP Installation Path] / phpmyadmin / config.inc.php in your favorite text editor.
// Search for the string 
// $cfg\['Servers'\]\[$i\]['password'] = ''; and change it to like this,
// $cfg\['Servers'\]\[$i\]['password'] = 'password'; Here the ‘password’ is what we set to the root user using the SQL query.
// Now all set to go. Save the config.inc.php file and restart the XAMPP server.

?>




