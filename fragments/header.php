<?php

include ('includes/db/db_connect.php');
include ('includes/db/query.php');

include ('includes/classes/Constant.php');

include('includes/classes/Artist.php');
include('includes/classes/Album.php');
include('includes/classes/Song.php');

$db = new Connection();
$querier = new Query();
$table = $db->db_tables();

if (isset($_SESSION[Constant::$session_loggedin])) {
    $userLoggedIn = $_SESSION[Constant::$session_loggedin];
    echo "<script>
            userLoggedIn = '$userLoggedIn'
          </script>";
    
    // session_destroy(); 
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

    <link rel="stylesheet" href="assets/css/style.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>
</head>
<body>

    <div id="mainContainer">
        
        <div id="topContainer">
            <?php include('navbarContainer.php') ?>

            <div id="mainViewContainer">
                <div id="mainContent">