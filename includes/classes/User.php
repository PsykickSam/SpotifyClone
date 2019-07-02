<?php

class User {

    private $conn;
    private $username;
    private $db_tables;
    private $querier;

    public function __construct($conn, $username, $db_tables, $querier) {
        $this->conn = $conn;
        $this->username = $username;
        $this->db_tables = $db_tables;
        $this->querier = $querier;
    }

    public function getUserName() {
      return $this->username;
    }
    
}

?>