<?php

include ('includes/classes/Constants.php');
session_start();

if (isset($_SESSION[Constants::$session_loggedin])) {
    $userLoggedIn = $_SESSION[Constants::$session_loggedin];
    echo $userLoggedIn;
    
    session_destroy(); 
} else {
    header("Location: auth.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome to Spotify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    
</body>
</html>