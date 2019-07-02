<?php

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    include ('includes/db/db_connect.php');
    include ('includes/db/query.php');

    include ('includes/classes/Constant.php');

    include('includes/classes/Artist.php');
    include('includes/classes/Album.php');
    include('includes/classes/Song.php');
    include('includes/classes/User.php');
    include('includes/classes/Playlist.php');

    $db = new Connection();
    $querier = new Query();
    $table = $db->db_tables();

    if (isset($_GET['userLoggedIn'])) {
      $userLoggedIn = new User($db->connection(), $_GET['userLoggedIn'], $table, $querier);
    } else {
      echo "Username was not passed into page. Check the 'openPage' JS function.";
      exit();
    }
  } else {
    include("fragments/header.php");
    include("fragments/footer.php");

    $URL = $_SERVER['REQUEST_URI'];
    echo "<script>openPage('$URL')</script>";
    exit();

  }

?>