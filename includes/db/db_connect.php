<?php
session_start();

include ('config.db.php');
include ('tables.db.php');

class Connection {

    private $conn;
    private $tables;

    public function __construct() {
        $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME);
        $this->tables = new Table();
    }

    public function __distruct() {
        // End
    }

    public function connection() {
        return $this->conn;
    }

    public function db_tables() {
        return $this->tables;
    }
}

?>