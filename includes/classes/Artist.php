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


    }

?>