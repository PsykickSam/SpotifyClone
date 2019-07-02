<?php

  include("../../db/db_connect.php");
  include("../../db/query.php");

  $data = array();

  if (isset($_POST['playlist_name']) && isset($_POST['username'])) {
    $name = $_POST['playlist_name'];
    $username = $_POST['username'];
    $date = date("Y-m-d");

    $db = new Connection();
    $table = $db->db_tables();
    $querier = new Query();

    $values = array('', $name, $username, $date);

    $sql = $querier->add($table::$playlists['table'], $values);

    $result = mysqli_query($db->connection(), $sql);
    $data = array("type"=>"success", "message"=>"Playlist saved...");
    echo json_encode($data); 
  } else {
    $data = array("type"=>"error", "message"=>"Name or Username not set properly...");
    echo json_encode($data);
  }

?>