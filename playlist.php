<?php include("fragments/includedFiles.php");

    if (isset($_GET['id'])) {
        $playlistId = $_GET['id'];
    } else {
        header("Location: index.php");
    }

    $playlist = new Playlist($db->connection(), $playlistId, $table, $querier);

?>

<div class="entityInfo">
    <div class="leftSection playListImage">
        <img src="assets/images/icons/playlist.png" alt="Playlist Image">
    </div>

    <div class="rightSection">
        <h2><?php echo $playlist->getName() ?></h2>
        <p>By <?php echo $playlist->getOwner() ?></p> 
        <p><?php echo $playlist->getNumberOfSongs() ?> songs</p>
        <button class="button" onclick="deletePlaylist(<?php echo $playlistId; ?>)">DELETE PLAYLIST</button>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php 
            $songIdArray = $playlist->getSongIds();

            foreach($songIdArray as $index=>$songId) {
                $playlistSong = new Song($db->connection(), $songId, $table, $querier);

                $songId = $playlistSong->getId();
                $songTitle = $playlistSong->getTitle();
                $songArtist = $playlistSong->getArtist()->getName();
                $songDuration = $playlistSong->getDuration();
                
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

