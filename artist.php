<?php

include("fragments/includedFiles.php");

if (isset($_GET['id'])) {
  $artistId = $_GET['id'];
} else {
  header("Location: index.php");
}

$artist = new Artist($db->connection(), $artistId, $table, $querier);

?>

<div class="entityInfo borderBottom">
  <div class="centerSection">
    <div class="artistInfo">
      <h1 class="artistName"><?php echo $artist->getName() ?></h1>

      <div class="headerButtons">
        <button class="button green" onclick="playFirstSong()">PLAY</button>
      </div>
    </div>
  </div>
</div>

<div class="tracklistContainer borderBottom">
  <h2>SONGS</h2>
  <ul class="tracklist">
    <?php 
      $songIdArray = $artist->getSongIds();

      foreach($songIdArray as $index=>$songId) {
        $artistSong = new Song($db->connection(), $songId, $table, $querier);

        $songId = $artistSong->getId();
        $songTitle = $artistSong->getTitle();
        $songArtist = $artistSong->getArtist()->getName();
        $songDuration = $artistSong->getDuration();
        
        $index += 1;

        echo "<li class='tracklistRow'>
                <div class='trackCount'>
                    <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"$songId\", tempPlaylist, true)' />
                    <span class='trackNumber'>$index</span>
                </div>

                <div class='trackInfo'>
                    <span class='trackName'>$songTitle</span>
                    <span class='artistName'>$songArtist</span>
                </div>

                <div class='trackOptions'>
                    <img class='play' src='assets/images/icons/more.png' />
                </div>

                <div class='trackDuration'>
                    <span class='duration'>$songDuration</span>
                </div>
              </li>";
      }
    ?>

    <script>
        var tempSongIds = `<?php echo json_encode($songIdArray) ?>`

        tempPlaylist = JSON.parse(tempSongIds)
    </script>

  </ul>
</div>

<div class="gridViewContainer">
  
  <h2>ALBUMS</h2>
  <?php

    $query = array(
      $table::$songs['columns']['artist']=>$artistId
    );

    $sql = $querier::get($table::$albums['table'], $query, array(), array());    
    $result = mysqli_query($db->connection(), $sql);

    while ($row = mysqli_fetch_array($result)) {
      $id = $row[$table::$albums['columns']['_id']];
      $title = $row[$table::$albums['columns']['title']];
      $artwork = $row[$table::$albums['columns']['artwork_path']];

      echo 
      "
          <div class='gridViewItem'>
              <span role='link' tabindex='0' onclick='openPage(\"album.php?id=$id\")'>
                  <img src='$artwork' alt='Album Image'>
                  <div class='gridViewInfo'>$title</div>
              </span>
          </div>

      ";
    }

  ?>

</div>
