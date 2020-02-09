<?php
$songQuery = mysqli_query($conn, "SELECT id FROM Songs ORDER BY RAND() LIMIT 10");
$resultArray = array();
while($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);

?>
<script>
$(document).ready(function() {
	var newPlaylist = <?php echo $jsonArray; ?>;
	audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeProgressBar(audioElement.audio);

    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
        e.preventDefault();
    });


	$(".playbackBar .progressBar").mousedown(function() {
        mouseDown = true;
	});

	$(".playbackBar .progressBar").mousemove(function(e) {
		if(mouseDown == true) {
			//Set time of song, depending on position of mouse
			timeFromOffset(e, this);
		}
	});

	$(".playbackBar .progressBar").mouseup(function(e) {
		timeFromOffset(e, this);
    });
    

    $(".volumeBar .progressBar").mousedown(function() {
        mouseDown = true;
	});

	$(".volumeBar .progressBar").mousemove(function(e) {
		if(mouseDown == true) {
            var percentage = e.offsetX / $(this).width();
            if(percentage >= 0 && percentage <= 1) {
                audioElement.audio.volume = percentage;
            }  
		}
	});

	$(".volumeBar .progressBar").mouseup(function(e) {
		var percentage = e.offsetX / $(this).width();
        if(percentage >= 0 && percentage <= 1) {
            audioElement.audio.volume = percentage;
        } 
	});

	$(document).mouseup(function() {
        mouseDown = false;
	});




});

function timeFromOffset(mouse, progressBar) {
	var percentage = mouse.offsetX / $(progressBar).width() * 100;
	var seconds = audioElement.audio.duration * (percentage / 100);
	audioElement.setTime(seconds);
}

function previousSong() {
    if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
        audioElement.setTime(0);
    } else {
        currentIndex = currentIndex - 1;
        setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
}

function nextSong() {
    if(repeat) {
        audioElement.setTime(0);
        playSong();
        return;
    }

    if(currentIndex == currentPlaylist.length - 1) {
        currentIndex = 0;
    } else {
        currentIndex++;
    }
    var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackToPlay, currentPlaylist, true);
}

function setRepeat() {
    repeat = !repeat;
    //var imageName = repeat ? "repeat-active.png" : "repeat.png";

    if(repeat) {
        $("#repeatIcon").css("color", "#07d159");
    } else {
        $("#repeatIcon").css("color", "#a0a0a0");
    }
}

function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    //var imageName = repeat ? "repeat-active.png" : "repeat.png";

    if(audioElement.audio.muted) {
        $("#volumeIcon").removeClass("fa-volume-up");
        $("#volumeIcon").addClass("fa-volume-off");
    } else {
        $("#volumeIcon").removeClass("fa-volume-off");
        $("#volumeIcon").addClass("fa-volume-up");
    }
}

function setShuffle() {
    shuffle = !shuffle;
    //var imageName = repeat ? "repeat-active.png" : "repeat.png";

    if(shuffle) {
        $("#shuffleIcon").css("color", "#07d159");
    } else {
        $("#shuffleIcon").css("color", "#a0a0a0");
    }
    
    if(shuffle) {
        shuffleArray(shufflePlaylist);
        currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
    } else {
        currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
    }
}

function shuffleArray(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}

    function setTrack(trackId, newPlaylist, play) {

        if(newPlaylist != currentPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }

        if(shuffle) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        } else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        
        pauseSong();

        $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId}, function(data) {            
            var track = JSON.parse(data);
            $(".trackName span").text(track.title);

            $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist}, function(data) {
                var artist = JSON.parse(data);
                $(".trackInfo .artistName span").text(artist.name);
                $(".trackInfo .artistName span").attr("onclick", "openPage('artist?id=" + artist.id + "')");
            });

            $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album}, function(data) {
                var album = JSON.parse(data);
                console.log(album);
                window.album = album;
                if($(".albumLink img").attr("src") == "") {
                    while($(".albumLink img").attr("src") == "") {
                        $(".albumLink img").attr("src", album.artworkPath);
                    } 
                } else {
                    $(".albumLink img").attr("src", album.artworkPath);
                }
                       
                $(".albumLink img").attr("onclick", "openPage('album?id=" + album.id + "')");
                $(".trackName span").attr("onclick", "openPage('album?id=" + album.id + "')");         
            });

            audioElement.setTrack(track);

            if(play) {
                playSong();
            }
        });

        
    }

    function playSong() {

        if(audioElement.audio.currentTime == 0) {
            $.post("includes/handlers/ajax/updatePlays.php", {songId: audioElement.currentlyPlaying.id});
        }

        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.play();
    }

    function pauseSong() {
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
        audioElement.pause();
    }
</script>
<div id="nowPlayingBarContainer">
            <div id="nowPlayingBar">
                <div id="nowPlayingLeft">
                    <div class="content">
                        <span class="albumLink">
                            <img role="link" tabindex="0" class="albumArtwork" src="">
                        </span>
                        <div class="trackInfo">
                            <span class="trackName">
                                <span role="link" tabindex="0"></span>
                            </span>
                            <span class="artistName">
                                <span role="link" tabindex="0"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div id="nowPlayingCenter">
                    <div class="content playerControls">
                        <div class="buttons">
                            <button onclick="setShuffle();" class="controlButton shuffle" title="Shuffle">
                                <i id="shuffleIcon" class="fa fa-random"></i>
                            </button>
                            <button onclick="previousSong();" class="controlButton previous" title="Previous">
                                <i class="fa fa-step-backward"></i>
                            </button>
                            <button onclick="playSong();" class="controlButton play" title="Play">
                                <i class="fa fa-play-circle"></i>
                            </button>
                            <button onclick="pauseSong();" style="display: none;" class="controlButton pause" title="Pause">
                                <i class="fa fa-pause-circle"></i>
                            </button>
                            <button onclick="nextSong();" class="controlButton next" title="Next">
                                <i class="fa fa-step-forward"></i>
                            </button>
                            <button onclick="setRepeat();" class="controlButton repeat" title="Repeat">
                                <i id="repeatIcon" class="fa fa-redo"></i>
                            </button>
                        </div>
                        <div class="playbackBar">
                            <span class="progressTime current">0:00</span>
                            <div class="progressBar">
                                <div class="progressBarBg">
                                    <div class="progress"></div>
                                </div>
                            </div>
                            <span class="progressTime remaining">0:00</span>
                        </div>
                    </div>
                </div>
                <div id="nowPlayingRight">
                    <div class="volumeBar">
                        <button onclick="setMute();" class="controlButton volume" title="Volume">
                            <i id="volumeIcon" class="fa fa-volume-up"></i>
                        </button>
                        <div class="progressBar">
                            <div class="progressBarBg">
                                <div class="progress"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

