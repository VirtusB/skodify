var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

$(document).click(function(click) {
    var target = $(click.target);
    if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
        hideOptionsMenu();
    }
});

$(window).scroll(function() {
    hideOptionsMenu();
});

$(document).on("change", "select.item.playlist", function() {
    var playlistId = $(this).val();
    var songId = $(this).prev(".songId").val();

    $.post("includes/handlers/ajax/addToPlaylist.php", {playlistId: playlistId, songId: songId}).done(function(error) {
        if(error != "") {
            alert(error);
            return;
        }

        hideOptionsMenu();
        $("select.item.playlist").val("");
        alertify.notify('Song added', 'custom', 3);
    });
});

function openPage(url) {
    if(timer != null) {
        clearTimeout(timer);
    }
	if(url.indexOf("?") == -1) {
		url = url + "?";
	}
	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	$("#mainContent").load(encodedUrl);
	
	$('html, body').animate({
        scrollTop: 0
	},500, 'easeOutExpo');
	
	history.pushState(null, null, url);

	console.log(encodedUrl);
}

function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function deletePlaylist(playlistId) {
    alertify.confirm('Delete playlist', 'Are you sure?', function(){ 
        $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId: playlistId} ).done(function(error) {
            if(error != "") {
                alert(error);
                return;
            }
            alertify.notify('Playlist deleted', 'customError', 3);
            openPage("yourmusic");
        });
    }
    , function(){ 
        //alertify.error('Cancel');
    }).set('labels', {ok:'Yes', cancel:'Cancel'});
}

function removeFromPlaylist(button, playlistId) {
    var songId = $(button).prevAll(".songId").val();

    $.post("includes/handlers/ajax/removeFromPlaylist.php", {playlistId: playlistId, songId: songId} ).done(function(error) {
        if(error != "") {
            alert(error);
            return;
        }
        alertify.notify('Song removed', 'customError', 2);
        openPage("playlist?id=" + playlistId);
    });
}

function createPlaylist() {
    alertify.prompt( 'New playlist', 'Playlist title:', ''
    , function(evt, value) { 
        $.post("includes/handlers/ajax/createPlaylist.php", {title: value, username: userLoggedIn} ).done(function(error) {
            if(error != "") {
                alert(error);
                return;
            }
            alertify.notify('Playlist created', 'custom', 3);
            openPage("yourmusic");
        });
    }
    , function() { 
        //alertify.error('Cancel') 
    });
    
    $("input.ajs-input").attr("autofocus", "autofocus");
    $("input.ajs-input").attr("onfocus", "this.selectionStart = this.selectionEnd = this.value.length;");
    $("input.ajs-input").focus();
    $("input.ajs-input:text:visible:first").focus();
    $("input.ajs-input").attr("placeholder", "My new playlist");
    
}


function logout() {
    $.post("includes/handlers/ajax/logout.php", function() {
        location.reload();
    });
}


function hideOptionsMenu() {
    var menu = $(".optionsMenu");
    if(menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

function showOptionsMenu(button) {
    var songId = $(button).prev(".songId").val(); //prevAll goes up as many levels as it needs to, prev takes the immediate ancestor
    var menu = $(".optionsMenu");
    var menuWidth = menu.width();
    menu.find(".songId").val(songId);

    var scrollTop = $(window).scrollTop();
    var elementOffset = $(button).offset().top;

    var top = elementOffset - scrollTop;
    var left = $(button).position().left;

    menu.css({
        "top": top + "px",
        "left": left - (menuWidth + 2) + "px",
        "display": "inline"
    });
}


function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60); //Rounds down
	var seconds = time - (minutes * 60);

	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progress = audio.currentTime / audio.duration * 100;
	$(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}

function Audio() {

	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	this.audio.addEventListener("canplay", function() {
		//'this' refers to the object that the event was called on
		var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
	});

	this.audio.addEventListener("timeupdate", function(){
		if(this.duration) {
			updateTimeProgressBar(this);
		}
    });
    
    this.audio.addEventListener("volumechange", function() {
        updateVolumeProgressBar(this);
    });

	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}

}

function updateEmail(emailClass) {
    var emailValue = $("." + emailClass).val();
    $.post("includes/handlers/ajax/updateEmail.php", {email: emailValue, username: userLoggedIn}).done(function(response) {
        $("." + emailClass).nextAll(".message").html(response);
        window.setTimeout(function() {
            $(".container span.message").each(function() {
                $(this).hide("slow", function() {
                    $(this).html("");
                    $(this).css("display", "table");
                });
                
            });
        }, 3000);
    });
}

function updatePassword(oldPasswordClass, newPasswordClass, newPasswordClassConfirm) {
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword = $("." + newPasswordClass).val();
    var newPasswordConfirm = $("." + newPasswordClassConfirm).val();

    $.post("includes/handlers/ajax/updatePassword.php", {oldPassword: oldPassword, newPassword: newPassword, newPasswordConfirm: newPasswordConfirm, username: userLoggedIn}).done(function(response) {
        $("." + oldPasswordClass).nextAll(".message").html(response);
        window.setTimeout(function() {
            $(".container span.message").each(function() {
                $(this).hide("slow", function() {
                    $(this).html("");
                    $(this).css("display", "table");
                });
                
            });
        }, 3000);
    });
}