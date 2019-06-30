<?php 

  include("../../db/db_connect.php");
  include("../../db/query.php");

  if (isset($_POST['albumId'])) {

    $albumId = $_POST['albumId'];

    $db = new Connection();
    $querier = new Query();

    $conn = $db->connection();
    $table = $db->db_tables();

    $query = array(
        $table::$albums['columns']['_id']=>$albumId
    );

    $sql = $querier::get($table::$albums['table'], $query, array(), array());

    $result = mysqli_query($db->connection(), $sql);

    $album = mysqli_fetch_array($result);

    echo json_encode($album);

  }

?>