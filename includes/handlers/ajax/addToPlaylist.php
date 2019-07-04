<?php
  
  include("../../db/db_connect.php");
  include("../../db/query.php");

  if (isset($_POST['playlist_id']) && isset($_POST['song_id'])) {
    $playlistId = $_POST['playlist_id'];
    $songId = $_POST['song_id'];

    $db = new Connection();
    $table = $db->db_tables();
    $querier = new Query();

    $param = array(
      $table::$playlist_songs['columns']['playlist_id']=>$playlistId
    );

    $operator = "MAX(" . $table::$playlist_songs['columns']['playlist_order'] . ") + 1 as maxPlaylistOrder";

    $sql1 = $querier->getWithOperator($operator, $table::$playlist_songs['table'], $param, array(), array());

    $result = mysqli_query($db->connection(), $sql1);

    $row = mysqli_fetch_array($result);

    $order = $row['maxPlaylistOrder'];

    $values = array('', $songId, $playlistId, $order);

    $sql = $querier->add($table::$playlist_songs['table'], $values);

    $result = mysqli_query($db->connection(), $sql);

    $data = array("type"=>"success", "message"=>"Song added to the playlist...");
    echo json_encode($data); 
  } else {
    $data = array("type"=>"error", "message"=>"Playlist Id or Song Id or Both are not passed properly. Check 'addToPlaylist.php'.");
    echo json_encode($data);
  }

?>