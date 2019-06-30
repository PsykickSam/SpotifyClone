<?php 

  include("../../db/db_connect.php");
  include("../../db/query.php");

  if (isset($_POST['songId'])) {

    $songId = $_POST['songId'];

    $db = new Connection();
    $querier = new Query();

    $conn = $db->connection();
    $table = $db->db_tables();

    $query = array(
        $table::$songs['columns']['_id']=>$songId
    );

    $sql = $querier::get($table::$songs['table'], $query, array(), array());

    $result = mysqli_query($db->connection(), $sql);

    $song = mysqli_fetch_array($result);

    echo json_encode($song);

  }

?>