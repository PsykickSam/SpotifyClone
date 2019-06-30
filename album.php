<?php include("pages/index/header.php");

    if (isset($_GET['id'])) {
        $albumId = $_GET['id'];
    } else {
        header("Location: index.php");
    }

    $album = new Album($db->connection(), $albumId, $table, $querier);
    $artist = $album->getArtist();

?>

<div class="entryInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath() ?>" alt="">
    </div>

    <div class="rightSection">
        <h2><?php echo $album->getTitle() ?></h2>
        <p>By <?php echo $artist->getName() ?></p> 
        <p><?php echo $album->getNumberOfSongs() ?> songs</p>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php 
            $songIdArray = $album->getSongIds();

            foreach($songIdArray as $index=>$songId) {
                $albumSong = new Song($db->connection(), $songId, $table, $querier);

                $songId = $albumSong->getId();
                $songTitle = $albumSong->getTitle();
                $songArtist = $albumSong->getArtist()->getName();
                $songDuration = $albumSong->getDuration();
                
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
  
<?php include("pages/index/footer.php") ?>