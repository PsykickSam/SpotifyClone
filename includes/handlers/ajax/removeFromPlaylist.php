<?php 

  include("../../db/db_connect.php");
  include("../../db/query.php");

  if (isset($_POST['playlist_id']) && isset($_POST['song_id'])) {
    $playlistId = $_POST['playlist_id'];
    $songId = $_POST['song_id'];

    $db = new Connection();
    $table = $db->db_tables();
    $querier = new Query();

    $values = array(
      $table::$playlist_songs['columns']['playlist_id']=>$playlistId,
      $table::$playlist_songs['columns']['song_id']=>$songId
    );

    $sql = $querier::delete($table::$playlist_songs['table'], $values, "AND");

    $result = mysqli_query($db->connection(), $sql);

    $data = array("type"=>"success", "message"=>"Song deleted from playlist...");
    echo json_encode($data); 
  } else {
    $data = array("type"=>"error", "message"=>"Playlist Id or Song Id or Both are not passed properly. Check 'removeFromPlaylist.php'.");
    echo json_encode($data);
  }

?>