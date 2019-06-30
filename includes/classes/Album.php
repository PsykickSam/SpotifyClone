<?php

    class Album {
        private $conn;
        private $id;
        private $table;
        private $querier;
        private $title;
        private $artistId;
        private $artworkPath;
        private $genre;

        public function __construct($conn, $id, $table, $querier) {
            $this->conn = $conn;
            $this->id = $id;

            $this->table = $table;
            $this->querier = $querier;

            $query = array(
                $this->table::$albums['columns']['_id']=>$this->id
            );
            $sql = $this->querier::get($this->table::$albums['table'], $query, array(), array());
            $fetchAlbum = mysqli_query($this->conn, $sql);
            $album = mysqli_fetch_array($fetchAlbum);

            $this->title = $album[$table::$albums['columns']['title']];
            $this->artistId = $album[$table::$albums['columns']['artist']];
            $this->artworkPath = $album[$table::$albums['columns']['artwork_path']];
            $this->genre = $album[$table::$albums['columns']['genre']];
        }

        public function getTitle() {
            return $this->title;
        }

        public function getArtist() {
            return new Artist($this->conn, $this->artistId, $this->table, $this->querier);
        }

        public function getArtworkPath() {
            return $this->artworkPath;
        }

        public function getGenre() {
            return $this->genre;
        }

        public function getNumberOfSongs() {
            $query = array(
                $this->table::$songs['columns']['album']=>$this->id
            );
            $sql = $this->querier::get($this->table::$songs['table'], $query, array(), array());
            $fetchSongs = mysqli_query($this->conn, $sql);
            
            return mysqli_num_rows($fetchSongs);
        }

        public function getSongIds() {
            $query = array(
                $this->table::$songs['columns']['album']=>$this->id,
                "ORDER BY"=>$this->table::$songs['columns']['album_order']
            );

            $clause = array("ORDER BY");

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
