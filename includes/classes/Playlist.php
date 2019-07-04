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
      $this->table = $table;
      $this->querier = $querier;

      if (!is_array($data)) {
        $params = array(
          $this->table::$playlists['columns']['_id']=>$data
        );

        $sql = $this->querier->get($this->table::$playlists['table'], $params, array(), array());

        $data = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_assoc($data);
      }

      $this->id = $data[$table::$playlists['columns']['_id']];
      $this->name = $data[$table::$playlists['columns']['name']];
      $this->owner = $data[$table::$playlists['columns']['owner']];
    }

    public function getId() {
      return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    public function getOwner() {
      return $this->owner;
    }

    public function getNumberOfSongs() {
      $params = array(
        $this->table::$playlist_songs['columns']['playlist_id']=>$this->id
      );

      $sql = $this->querier->get($this->table::$playlist_songs['table'], $params, array(), array());
      
      $result = mysqli_query($this->conn, $sql);
      $numberOfSongs = mysqli_num_rows($result);
      return $numberOfSongs;
    }

    public function getSongIds() {
      $params = array(
        $this->table::$playlist_songs['columns']['playlist_id']=>$this->id,
        "ORDER BY"=>$this->table::$playlist_songs['columns']['playlist_order'] . " ASC"
      );

      $clause = array("ORDER BY");

      $sql = $this->querier->get($this->table::$playlist_songs['table'], $params, array(), $clause);
      
      $query = mysqli_query($this->conn, $sql);

      $array = array();

      while($row = mysqli_fetch_array($query)) {
        array_push($array, $row[$this->table::$playlist_songs['columns']['song_id']]); 
      }

      return $array;
    }

    public static function getPlaylistsDropdown($conn, $username, $table, $querier) {
      $dropdown = '<select name="" id="" class="item playlist">
                       <option value="">Add to Playlist</option>';

      $operator = $table::$playlists['columns']['_id'] . ", " . 
                  $table::$playlists['columns']['name'];

      $params = array($table::$playlists['columns']['owner']=>$username);

      $sql = $querier->getWithOperator($operator, $table::$playlists['table'], $params, array(), array());

      $query = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_array($query)) {
        $id = $row[$table::$playlists['columns']['_id']];
        $name = $row[$table::$playlists['columns']['name']];
        
        $dropdown .= "<option value='$id'>$name</option>";
      }

      return $dropdown . '</select>';
    }
}

?>