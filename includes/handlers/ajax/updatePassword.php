<?php 

  include("../../db/db_connect.php");
  include("../../db/query.php");
  
  include("../../classes/Constant.php");

  if (!isset($_POST['username']) || !isset($_POST['oldPassword']) || 
      !isset($_POST['newPassword']) || !isset($_POST['confirmPassword'])) {
    echo Constant::$userNameAndPasswordNotSet;
    exit();
  }

  $username = $_POST['username'];  
  $oldPassword = $_POST['oldPassword'];  
  $newPassword = $_POST['newPassword'];  
  $confirmPassword = $_POST['confirmPassword'];  

  if (empty($username)) {
    echo Constant::$usernameNotDefined;
    exit();
  }

  if (empty($oldPassword)) {
    echo Constant::$passwordEmpty;
    exit();
  }

  if (empty($newPassword)) {
    echo Constant::$passwordEmpty;
    exit();
  }

  if (empty($confirmPassword)) {
    echo Constant::$passwordEmpty;
    exit();
  }

  $db = new Connection();
  $querier = new Query();

  $conn = $db->connection();
  $table = $db->db_tables();

  $hash = crypt($oldPassword, Constant::$SALTSHA512);

  $params = array(
    $table::$users['columns']['uname']=>$username,
    "conditionAndBetweenUsernameAndPassword"=>"AND",
    $table::$users['columns']['paswd']=>$hash
  );

  $condition = array("conditionAndBetweenUsernameAndPassword");

  $sql = $querier->get($table::$users['table'], $params, $condition, array());

  $query = mysqli_query($db->connection(), $sql);

  if (mysqli_num_rows($query) != 1) {
    echo Constant::$passwordIncorrect;
    exit();
  }

  if ($newPassword != $confirmPassword) {
    echo Constant::$passwordNotMatch;
    exit();
  }

  if (preg_match('/[^A-Za-z0-9]/', $newPassword)) {
    echo Constant::$passwordNotAlphanumeric;
    exit();
  }

  if (strlen($newPassword) < 6) {
    echo Constant::$passwordCharecters;
    exit();
  }

  $hash = crypt($newPassword, Constant::$SALTSHA512);

  $sets = array(
    $table::$users['columns']['paswd']=>$hash
  );

  $condition = array(
    $table::$users['columns']['uname']=>$username
  );

  $sql = $querier->update($table::$users['table'], $sets, $condition);

  $query = mysqli_query($db->connection(), $sql);

  echo Constant::$passwordUpdated;

?>