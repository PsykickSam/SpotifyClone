<?php

    class Song {
        private $conn;
        private $id;
        private $table;
        private $querier;
        private $mysqlData;
        private $title;
        private $artistId;
        private $albumId;
        private $genre;
        private $duration;
        private $path;
        
        public function __construct($conn, $id, $table, $querier) {
            $this->conn = $conn;
            $this->id = $id;

            $this->table = $table;
            $this->querier = $querier;

            $query = array(
                $this->table::$songs['columns']['_id']=>$this->id
            );
            $sql = $this->querier::get($this->table::$songs['table'], $query, array(), array());
            $fetchAlbum = mysqli_query($this->conn, $sql);
            $this->mysqlData = mysqli_fetch_array($fetchAlbum);

            $this->title = $this->mysqlData[$this->table::$songs['columns']['title']];
            $this->artistId = $this->mysqlData[$this->table::$songs['columns']['artist']];
            $this->albumId = $this->mysqlData[$this->table::$songs['columns']['album']];
            $this->genre = $this->mysqlData[$this->table::$songs['columns']['genre']];
            $this->duration = $this->mysqlData[$this->table::$songs['columns']['duration']];
            $this->path = $this->mysqlData[$this->table::$songs['columns']['path']];
        }

        public function getId() {
            return $this->id;
        }

        public function getTitle() {
            return $this->title;
        }

        public function getArtist() {
            return new Artist($this->conn, $this->artistId, $this->table, $this->querier);
        }

        public function getAlbum() {
            return new Album($this->conn, $this->albumId, $this->table, $this->querier);
        }

        public function getPath() {
            return $this->path;
        }

        public function getDuration() {
            return $this->duration;
        }

        public function getGenre() {
            return $this->genre;
        }

        public function getMysql() {
            return $this->mysqlData;
        }

    }

?>