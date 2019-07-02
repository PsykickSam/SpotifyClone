<?php 

  include("../../db/db_connect.php");
  include("../../db/query.php");

  $data = array();

  if (isset($_POST['playlist_id'])) {
    $playlistId = $_POST['playlist_id'];

    $db = new Connection();
    $table = $db->db_tables();
    $querier = new Query();
    
    $valuesPlaylist = array($table::$playlists['columns']['_id']=>$playlistId);
    $valuesSong = array($table::$playlist_songs['columns']['playlist_id']=>$playlistId);

    $sqlPlaylist = $querier::delete($table::$playlists['table'], $valuesPlaylist);
    $sqlSong = $querier::delete($table::$playlist_songs['table'], $valuesSong);

    $playlistQuery = mysqli_query($db->connection(), $sqlPlaylist);
    $songQuery = mysqli_query($db->connection(), $sqlSong);

    $data = array("type"=>"success", "message"=>"Playlist deleted...");
    echo json_encode($data); 
  } else {
    $data = array("type"=>"error", "message"=>"Playlist id not passed through the params...");
    echo json_encode($data);
  }

?>