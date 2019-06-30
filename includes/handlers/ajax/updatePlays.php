<?php 

  include("../../db/db_connect.php");
  include("../../db/query.php");

  if (isset($_POST['songId'])) {
    $songId = $_POST['songId'];

    $db = new Connection();
    $querier = new Query();

    $conn = $db->connection();
    $table = $db->db_tables();

    $sets = array(
      $table::$songs['columns']['plays']=>$table::$songs['columns']['plays'] . " + 1"
    );

    $conditions = array(
      $table::$songs['columns']['_id']=>$songId
    );

    $sql = $querier::update($table::$songs['table'], $sets, $conditions);

    $result = mysqli_query($db->connection(), $sql);

    echo $result == 1 ? "Play Count Updated" : "Play Count Not Updated";

  }



?>