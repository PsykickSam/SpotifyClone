<?php

  include("fragments/includedFiles.php");

  if (isset($_GET['query'])) {
    $query = urldecode($_GET['query']);    
  } else {
    $query = "";
  }

?>

<div class="searchContainer">

  <h4>Search for an artist, album or song</h4>
  <input type="text" class="searchInput" value="<?php echo $query; ?>" placeholder="Start typing....." onfocus="this.value = this.value;" />

</div>

<script>
  // $(".searchInput").focus()
  
  $(function() {
    $(".searchInput").keyup(function() {
      clearTimeout(timer);

      timer = setTimeout(() => {
        var query = $(".searchInput").val()
        openPage(`search.php?query=${query}`)
      }, 2000);
    })
  })

  function onFocus() {
    $(".searchInput").attr("value", $(".searchInput").val());
  }
</script>

<?php if ($query == "") exit(); ?>

<div class="tracklistContainer borderBottom">
  <h2>SONGS</h2>
  <ul class="tracklist">
    <?php 
      $params = array(
        $table::$songs['columns']['title']=>"LIKE '%$query%'",
        "LIMIT"=>"15"
      );

      $cluase = array($table::$songs['columns']['title'], "LIMIT");

      $sql = $querier->get($table::$songs['table'], $params, array(), $cluase);

      $songQuery = mysqli_query($db->connection(), $sql);

      if (mysqli_num_rows($songQuery) == 0) {
        echo "<span class='noResults'>No songs found matching '$query'</span>";
      }
      
      $songIdArray = array();
      $index = 0;

      while($row = mysqli_fetch_array($songQuery)) {

        array_push($songIdArray, $row['_id']);

        $song = new Song($db->connection(), $row['_id'], $table, $querier);

        $songId = $song->getId();
        $songTitle = $song->getTitle();
        $songArtist = $song->getArtist()->getName();
        $songDuration = $song->getDuration();
        
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

<div class="artistContainer borderBottom">
  <h2>ARTISTS</h2>
  <?php
    $params = array(
      $table::$artists['columns']['name']=>"LIKE '%$query%'",
      "LIMIT"=>"5"
    );

    $cluase = array($table::$artists['columns']['name'], "LIMIT");

    $sql = $querier->get($table::$artists['table'], $params, array(), $cluase);

    $artistsQuery = mysqli_query($db->connection(), $sql);

    if (mysqli_num_rows($artistsQuery) == 0) {
      echo "<span class='noResults'>No artist found matching '$query'</span>";
    }

    while($row = mysqli_fetch_array($artistsQuery)) {
      $artistFound = new Artist($db->connection(), $row['_id'], $table, $querier);
      $artistId = $artistFound->getId();
      $artistName = $artistFound->getName();

      echo "<div class='searchResultRow'>
              <span class='artistsName'>
                <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=$artistId\")'>
                  $artistName
                </span>
              </span>
            </div>";
    }
  ?>
</div>

<div class="gridViewContainer">
  
  <h2>ALBUMS</h2>
  <?php
    $params = array(
      $table::$albums['columns']['title']=>"LIKE '%$query%'",
      "LIMIT"=>"3"
    );

    $cluase = array($table::$albums['columns']['title'], "LIMIT");

    $sql = $querier->get($table::$albums['table'], $params, array(), $cluase);

    $albumsQuery = mysqli_query($db->connection(), $sql);

    if (mysqli_num_rows($albumsQuery) == 0) {
      echo "<span class='noResults'>No artist found matching '$query'</span>";
    }

    while ($row = mysqli_fetch_array($albumsQuery)) {
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
