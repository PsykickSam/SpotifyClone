<!-- page name: your_music -->

<?php include("fragments/includedFiles.php"); ?>

<div class="playlistsContainer">
  <div class="gridViewContainer">
    <h2>PLAYLISTS</h2>

    <div class="buttonItems">
      <button class="button green" onclick="createPlaylist()">NEW PLAYLIST</button>
    </div>

    
<div class="gridViewContainer">

    <?php
      $params = array(
        $table::$playlists['columns']['owner']=>$userLoggedIn->getUsername()
      );

      $sql = $querier->get($table::$playlists['table'], $params, array(), array());

      $playlistsQuery = mysqli_query($db->connection(), $sql);

      if (mysqli_num_rows($playlistsQuery) == 0) {
        echo "<span class='noResults'>You don't have any playlists yet.</span>";
        exit();
      }

      while ($row = mysqli_fetch_array($playlistsQuery)) {
        $playlist = new Playlist($db->connection(), $row, $table, $querier);

        $id = $playlist->getId();
        $name = $playlist->getName();

        echo 
        "
            <div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=$id\")'>
              <div class='playListImage'>
                <img src='assets/images/icons/playlist.png' />
              </div>

              <div class='gridViewInfo'>$name</div>    
            </div>
        ";
      }

    ?>

  </div>

  </div>
</div>