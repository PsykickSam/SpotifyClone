<?php 

  include("../../db/db_connect.php");
  include("../../db/query.php");

  if (isset($_POST['artistId'])) {

    $artistId = $_POST['artistId'];

    $db = new Connection();
    $querier = new Query();

    $conn = $db->connection();
    $table = $db->db_tables();

    $query = array(
        $table::$artists['columns']['_id']=>$artistId
    );

    $sql = $querier::get($table::$artists['table'], $query, array(), array());

    $result = mysqli_query($db->connection(), $sql);

    $artist = mysqli_fetch_array($result);

    echo json_encode($artist);

  }

?>