<?php

class Playlist {

    private $conn;
    private $id;
    private $name;
    private $owner;
    private $table;
    private $querier;

    public function __construct($conn, $data, $table, $querier) {
        $this->conn = $conn;
        $this->id = $data[$table::$playlists['columns']['_id']];
        $this->name = $data[$table::$playlists['columns']['name']];
        $this->owner = $data[$table::$playlists['columns']['owner']];
        $this->table = $table;
        $this->querier = $querier;
    }

    public function getId() {
      return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    public function getOnwer() {
      return $this->owner;
    }

    
    
}

?>