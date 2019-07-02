<?php 

    $songQuery = mysqli_query($db->connection(), "SELECT * FROM songs ORDER BY RAND() LIMIT 10");

    $resultArray = array();

    while ($row = mysqli_fetch_array($songQuery)) {
        array_push($resultArray, $row['_id']);
    }

    $jsonArray = json_encode($resultArray);

?>

<script>

    $(document).ready(function() {
        audioElement = new Audio()
        var newPlaylist = <?php echo $jsonArray; ?>

        updateVolumeProgressBar(audioElement.audio)
        // setTrack(newPlaylist[0], newPlaylist, false)

        // Now Playing Bar Container
        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(event) {
            event.preventDefault()
        }) 

        // Progress Bar
        $(".playbackBar .progressBar").mousedown(function() {
            mouseDown = true
        })

        $(".playbackBar .progressBar").mousemove(function(event) {
            if (mouseDown) {
                timeFromOffset(event, this)
            }
        })

        $(".playbackBar .progressBar").mouseup(function(event) {
            timeFromOffset(event, this)
        })

        // Volume Bar
        $(".volumeBar .progressBar").mousedown(function() {
            mouseDown = true
        })

        $(".volumeBar .progressBar").mousemove(function(event) {
            if (mouseDown) {
                volumeFromOffset(event, this)
            }
        })

        $(".volumeBar .progressBar").mouseup(function(event) {
            volumeFromOffset(event, this)
        })

        $(document).keydown(function(event) {
            if (event.keyCode == 38) { // ArrowUp
                event.preventDefault()
                volumeFromKeyPress(event, this, true)
            } else if (event.keyCode == 40) { // ArrowDown
                event.preventDefault()
                volumeFromKeyPress(event, this, false)
            }
        })

        $(document).mouseup(function(event) {
            mouseDown = false
        })

    })

    function timeFromOffset(mouse, progressBar) {
        var percentage = mouse.offsetX / $(progressBar).width() * 100
        var seconds  = audioElement.audio.duration * (percentage / 100)

        audioElement.setTime(seconds)
    }
    
    function volumeFromOffset(mouse, volumeBar) {
        var volume = mouse.offsetX / $(volumeBar).width()

        audioElement.setVolume(volume)
        $(".volumeBar .progress").css("width", (volume * 100) + "%")
    }

    function volumeFromKeyPress(key, volumeBar, isIncrease) {
        var volume = audioElement.getVolume() 
        volume = isIncrease ? volume + 0.1 : volume - 0.1

        if (volume >= 1) {
            volume = 1
        } else if (volume <= 0) {
            volume = 0
        }

        audioElement.setVolume(volume)
        $(".volumeBar .progress").css("width", (volume * 100) + "%")
    }

    function nextSong() {
        if (repeat) {
            audioElement.setTime(0)
            playSong()
            return
        }

        if (currentIndex == currentPlaylist.length - 1) {
            currentIndex = 0
        } else {
            currentIndex += 1
        }


        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex]
        setTrack(trackToPlay, currentPlaylist, true)
    }

    function previousSong() {

        if (repeat) {
            audioElement.setTime(0)
            playSong()
            return
        }
        
        if (audioElement.audio.currentTime >= 3) {
            audioElement.setTime(0)
            return 
        } if (currentIndex == 0) {
            currentIndex = currentPlaylist.length - 1
        } else {
            currentIndex -= 1
        }

        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex]
        setTrack(trackToPlay, currentPlaylist, true)
    }

    function repeatSong() {
        repeat = !repeat

        var imageName = repeat ? "repeat-active.png" : "repeat.png" 
        $(".controlButton.repeat img").attr("src", `assets/images/icons/${imageName}`) 
    }

    function muteVolume() {
        mute = !mute
        var imageName = mute ? "volume-mute.png" : "volume.png"
        var volumePercentage = mute ? 0 : 100
        
        audioElement.setMute(mute)
        audioElement.setVolume(volumePercentage / 100)

        $(".controlButton.volume img").attr("src", `assets/images/icons/${imageName}`)
    }

    function shuffleSong() {
        shuffle = !shuffle
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png"
        
        $(".controlButton.shuffle img").attr("src", `assets/images/icons/${imageName}`)

        if (shuffle) {
            shuffler(shufflePlaylist)
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying._id)
        } else {
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying._id)
        }
    }
  
    function shuffler(array) {
        var j, x, i
        for (i = array.length; i; i--) {
            j = Math.floor(Math.random() * i)
            x = array[i  - 1]
            array[i - 1] = array[j]
            array[j] = x
        }
    }

    function setTrack(trackId, newPlaylist, play) {

        if (newPlaylist != currentPlaylist) {
            currentPlaylist = newPlaylist
            shufflePlaylist = currentPlaylist.slice()

            shuffler(shufflePlaylist)
        }

        if (shuffle) {
            currentIndex = shufflePlaylist.indexOf(trackId)
        } else {
            currentIndex = currentPlaylist.indexOf(trackId)
        }

        if (currentIndex < 0) currentIndex = 0

        pauseSong()

        $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(song) {
            var track = JSON.parse(song)
            audioElement.setTrack(track)
            
            $(".trackName span").text(track.title)
            $(".trackName span").attr("onclick", `openPage("album.php?id=${track.album}")`)

            $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(artist) {
                var trackArtist = JSON.parse(artist)
                
                $(".trackInfo .artistName span").text(trackArtist.name)
                $(".trackInfo .artistName span").attr("onclick", `openPage("artist.php?id=${trackArtist._id}")`)

                $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(album) {
                    var trackAlbum = JSON.parse(album)

                    $(".content .albumLink img").attr("src", trackAlbum.artwork_path)
                    $(".content .albumLink img").attr("onclick", `openPage("album.php?id=${trackAlbum._id}")`)
                })
            })

            if (play) {
                playSong()
            }
        })
    }

    function playSong() {   
        if (audioElement.getCurrentTime() == 0) {
            $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying._id }, function(data) {
                console.log(data)
            })
        } 

        $(".controlButton.play").hide()
        $(".controlButton.pause").show()
        audioElement.play()
    }

    function pauseSong() {
        $(".controlButton.pause").hide()
        $(".controlButton.play").show()
        audioElement.pause()
    }

</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img role="link" tabindex="0" src="https://www.allcolourenvelopes.co.uk/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/s/q/square-deep-blue-envelopes.jpg" width="57" height="100%" alt="Album Artwork" class="albumArtwork">
                </span>

                <div class="trackInfo">
                    <span class="trackName">
                        <span role="link" tabindex="0">Track Name</span>
                    </span>

                    <span class="artistName">
                        <span role="link" tabindex="0">Artist Name</span>
                    </span>
                </div>
            </div>
        </div>
        
        <div id="nowPlayingCenter">
            <div class="content playerControl">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle" onclick="shuffleSong()">
                        <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>

                    <button class="controlButton previous" title="Previous" onclick="previousSong()">
                        <img src="assets/images/icons/previous.png" alt="Previous">
                    </button>

                    <button class="controlButton play" title="Play" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="Play">
                    </button>

                    <button class="controlButton pause" title="Pause"  onclick="pauseSong()" style="display: none;">
                        <img src="assets/images/icons/pause.png" alt="Pause">
                    </button>

                    <button class="controlButton next" title="Next">
                        <img src="assets/images/icons/next.png" alt="Next" onclick="nextSong()">
                    </button>

                    <button class="controlButton repeat" title="Repeat">
                        <img src="assets/images/icons/repeat.png" alt="Repeat" onclick="repeatSong()">
                    </button>
                </div>

                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">
                        <div class="progressBarBG">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">0.00</span>
                </div>
            </div>
        </div>
        
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume" onclick="muteVolume()">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>

                <div class="progressBar">
                    <div class="progressBarBG">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
