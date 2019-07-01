<?php

    class Artist {

        private $conn;
        private $id;
        private $table;
        private $querier;

        public function __construct($conn, $id, $table, $querier) {
            $this->conn = $conn;
            $this->id = $id;

            $this->table = $table;
            $this->querier = $querier;
        }

        public function getName() {
            $query = array(
                $this->table::$artists['columns']['_id']=>$this->id
            );
            $sql = $this->querier::get($this->table::$artists['table'], $query, array(), array());
            $fetchArtist = mysqli_query($this->conn, $sql);
            $artist = mysqli_fetch_array($fetchArtist);

            return $artist[$this->table::$artists['columns']['name']];
        }

        public function getSongIds() {
            $query = array(
                $this->table::$songs['columns']['artist']=>$this->id,
                "ORDER BY"=>$this->table::$songs['columns']['plays'] . " DESC", 
                "LIMIT"=>"5"
            );

            $clause = array("ORDER BY", "LIMIT");

            $sql = $this->querier::get($this->table::$songs['table'], $query, array(), $clause);
            
            $query = mysqli_query($this->conn, $sql);

            $array = array();

            while($row = mysqli_fetch_array($query)) {
                array_push($array, $row[$this->table::$albums['columns']['_id']]); 
            }

            return $array;
        }
        
    }

?>