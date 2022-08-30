<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>

<html>
<head>
<link rel="stylesheet" href="../style/w3.css">
<title>
Logout
</title>
</head>
<body onload="move()">

<script>
function move() {
  var elem = document.getElementById("myBar");
  var width = 1;
  var id = setInterval(frame, 50);
  function frame() {
    if (width >= 100) {
      clearInterval(id);
    } else {
      width++;
      elem.style.width = width + '%';
    }
  }
}
</script>
<?php
    $formmessage_part1 = "<br><br>
                          <div class='w3-container'>
                          <div class='w3-card-4'>
                          <div class='w3-container w3-teal'>
                          <h2>Message</h2>
                          </div>
                          <div class='w3-container'>
                          <br>";
    $formmessage_part2 = "<br><br></div></div></div>";
    $progressbar = "<br>
                    <div class='w3-container'>
                    <div class='w3-progress-container'>
                    <div id='myBar' class='w3-progressbar w3-green' style='width:1%'></div>
                    </div></div>";
    if ($username && $userid) {
        $userid = "";
        $username = "";
        $_SESSION['userid'] = "";
        $_SESSION['username'] = "";
        echo $formmessage_part1;
        echo "You have been successfully logged out.<br>Redirecting to login screen...";
        echo $formmessage_part2;
    }
    else {
        echo $formmessage_part1;
        echo "You are not logged in.<br>Redirecting to login screen...";
        echo $formmessage_part2;
    }
    
    // Redirect to login screen
    header('refresh:5; url=./login.php');
    echo $progressbar;
?>
</body>
</html>
