var currentPlaylist = []
var shufflePlaylist = []
var tempPlaylist = []
var audioElement = null
var mouseDown = false
var currentIndex = 0
var repeat = false
var mute = false
var shuffle = false
var userLoggedIn
var timer

function openPage(url) {

  if (timer != null) {
    clearTimeout(timer)
  }

  if (url.indexOf("?") == -1) {
    url = url + "?";
  }

  var encodedURL = encodeURI(url + "&userLoggedIn=" + userLoggedIn)
  $("#mainContent").load(encodedURL)
  $("body").scrollTop(0)
  history.pushState(null, null, url)
}

function playFirstSong() {
  setTrack(tempPlaylist[0], tempPlaylist, true)
}

function createPlaylist() {
  var playlistName = prompt("Please enter the name of the playlist")

  if (playlistName != null) {
    $.post("includes/handlers/ajax/createPlaylist.php", { playlist_name: playlistName, username: userLoggedIn })
      .done(function (data) {
       var json = JSON.parse(data)
       if (json.type === "error") {
         alert(json.message)
         return
       }
       
      openPage("user_music.php")
    })
  } 
}

function formatTime(duration) {
  var time = Math.round(duration)
  
  var minutes = Math.floor(time / 60);
  var seconds = time - (minutes * 60);

  if (seconds < 10) {
    seconds = "0" + String(seconds);
  }

  return minutes + ":" + seconds;
}

function updateTimeProgressBar(audio) {
  $(".progressTime.current").text(formatTime(audio.currentTime))
  $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime))

  var progress = audio.currentTime / audio.duration * 100
  $(".playbackBar .progress").css("width", progress + "%") 
}

function updateVolumeProgressBar(audio) {
  var progress = audio.volume * 100
  $(".volumeBar .progress").css("width", progress + "%") 
}

function Audio() {

  this.currentlyPlaying = null
  this.audio = document.createElement('audio')

  this.audio.addEventListener("canplay", function() {
    $(".progressTime.remaining").text(formatTime(this.duration))
  })

  this.audio.addEventListener("timeupdate", function () {
    if (this.duration) {
      updateTimeProgressBar(this)
    }
  })

  this.audio.addEventListener("ended", function() {
    nextSong()
  })

  this.audio.addEventListener("volumechange", function () {
    updateVolumeProgressBar(this)
  })

  this.setTrack = function(track) {
    this.currentlyPlaying = track
    this.audio.src = track.path
  }

  this.play = function() {
    this.audio.play()
  }

  this.pause = function () {
    this.audio.pause()
  }
  
  this.setTime = function(seconds) {
    this.audio.currentTime = seconds
  }

  this.setMute = function(mute) {
    this.audio.muted = mute
  }

  this.setVolume = function(volume) {
    this.audio.volume = volume
  }

  this.getCurrentTime = function () {
    return this.audio.currentTime
  }

  this.getVolume = function() {
    return this.audio.volume
  }

}