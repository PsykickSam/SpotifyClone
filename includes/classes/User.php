<?php

class User {

    private $conn;
    private $username;
    private $table;
    private $querier;

    public function __construct($conn, $username, $db_tables, $querier) {
        $this->conn = $conn;
        $this->username = $username;
        $this->table = $db_tables;
        $this->querier = $querier;
    }

    public function getUserName() {
      return $this->username;
    }

    public function getEmail() {
      $params = array(
        $this->table::$users['columns']['uname']=>$this->username
      );

      $fname = $this->table::$users['columns']['fname'];
      $lname = $this->table::$users['columns']['lname'];

      $operator = "email";

      $sql = $this->querier->getWithOperator($operator, $this->table::$users['table'], $params, array(), array());

      $query = mysqli_query($this->conn, $sql);

      $row = mysqli_fetch_array($query);

      return $row[$this->table::$users['columns']['email']];
    }

    public function getFirstNameAndLastName() {

      $params = array(
        $this->table::$users['columns']['uname']=>$this->username
      );

      $fname = $this->table::$users['columns']['fname'];
      $lname = $this->table::$users['columns']['lname'];

      $operator = "concat($fname, ' ', $lname) as 'name'";

      $sql = $this->querier->getWithOperator($operator, $this->table::$users['table'], $params, array(), array());

      $query = mysqli_query($this->conn, $sql);

      $row = mysqli_fetch_array($query);

      return $row['name'];
    }
    
}

?>