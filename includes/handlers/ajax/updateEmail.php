<?php 

  include("../../db/db_connect.php");
  include("../../db/query.php");
  include("../../classes/Constant.php");

  if (!isset($_POST['username']) || !isset($_POST['email'])) {
    echo Constant::$usernameEmailNotSet;
    exit();
  }

  $username = $_POST['username'];  
  $email = $_POST['email'];  

  if (empty($username)) {
    echo Constant::$usernameNotDefined;
    exit();
  }

  if (empty($email)) {
    echo Constant::$emailNotDefined;
    exit();
  }

  $db = new Connection();
  $querier = new Query();

  $conn = $db->connection();
  $table = $db->db_tables();

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo Constant::$emailNotValid;
    exit();
  }

  $params = array(
    $table::$users['columns']['email']=>$email,
    "conditionAndBetweenUsernameAndEmail"=>"AND",
    "not"=>array($table::$users['columns']['uname'], $username)
  );

  $condition = array("conditionAndBetweenUsernameAndEmail");

  $operator = "email";

  $sql = $querier->getWithOperator($operator, $table::$users['table'], $params, $condition, array());

  $emailCheckQuery = mysqli_query($db->connection(), $sql);

  if (mysqli_num_rows($emailCheckQuery) > 0) {
    echo Constant::$emailIsAlreadyInUse;
    exit();
  }

  $sets = array(
    $table::$users['columns']['email']=>$email
  );

  $condition = array(
    $table::$users['columns']['uname']=>$username
  );

  $sql = $querier->update($table::$users['table'], $sets, $condition);

  $updateQuery = mysqli_query($db->connection(), $sql);

  echo Constant::$updateEmailSuccess;

?>