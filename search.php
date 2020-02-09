<?php 
include_once 'includes/includedFiles.php';

if(isset($_GET['term'])) {
    $term = urldecode($_GET['term']);
} else {
    $term = "";
}

?>

<div class="searchContainer">
    <h4>Search for an artist, album or song</h4>
    <div class="inputDiv">
        <input onfocus="this.selectionStart = this.selectionEnd = this.value.length;" autofocus="autofocus" type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing">        
        <span onclick="deleteSearch();" class="fa fa-times searchRemoveIcon"></span>
    </div>
</div>

<style>
    .searchRemoveIcon {
        font-size: 35px;
        float: right;
        cursor: pointer;
        display: none;
    }

    .inputDiv {
        display: flex;
        align-items: center;
    }
</style>

<script>
    $(function() {
        
        $(".searchInput").keyup(function() {
            clearTimeout(timer);

            timer = setTimeout(function() {
                var val = $(".searchInput").val();
                openPage("search?term=" + val);
            }, 650);
        });
    });

    $(".searchInput").focus();
    $(".searchInput:text:visible:first").focus();

    if($(".searchInput").val() != "") {
        $(".searchRemoveIcon").css("display", "block");
    } else {
        $(".searchRemoveIcon").css("display", "none");
    }

    function deleteSearch() {
        $(".searchInput").val("");
        $(".searchInput").keyup();
    }
</script>

<?php if($term == "") { exit(); } ?>

<div class="trackListContainer borderBottom">
    <h2>SONGS</h2>
    <ul class="trackList"> 
        <?php 
            $term = escape($term);
            $songsQuery = mysqli_query($conn, "SELECT id FROM Songs WHERE title LIKE '$term%' LIMIT 10");
            if(mysqli_num_rows($songsQuery) == 0) {
                echo "<span class='noResults'>No songs found matching " . $term . "</span>";
            }


            $songIdArray = array();
            $i = 1;

            while($row = mysqli_fetch_array($songsQuery)) {
                if($i > 15) {
                    break;
                }
                array_push($songIdArray, $row['id']);

                $albumSong = new Song($conn, $row['id']);
                $albumArtist = $albumSong->getArtist();

                echo "
                    <li class='trackListRow'>
                        <div class='trackCount'>
                            <i onclick='setTrack(\"".$albumSong->getId()."\", tempPlaylist, true);' class='fa fa-play play'></i>
                            <span class='trackNumber'>$i</span>
                        </div>
                        <div class='trackInfo'>
                            <span class='trackName'>".$albumSong->getTitle()."</span>
                            <span class='artistName'>".$albumArtist->getName()."</span>
                        </div>
                        <div class='trackOptions'>
                            <input type='hidden' class='songId' value='".$albumSong->getId()."'>
                            <i onclick='showOptionsMenu(this)' class='fa fa-ellipsis-h optionsButton'></i>
                        </div>
                        <div class='trackDuration'>
                            <span class='duration'>".$albumSong->getDuration()."</span>
                        </div>
                    </li>
                ";
                $i++;
            }
        ?>
        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
    </ul>
</div>

<div class="artistsContainer borderBottom">
    <h2>ARTISTS</h2>
    <?php 
        $artistsQuery = mysqli_query($conn, "SELECT id from Artists WHERE name LIKE '$term%' LIMIT 10");
        if(mysqli_num_rows($artistsQuery) == 0) {
            echo "<span class='noResults'>No artists found matching " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($artistsQuery)) {
            $artistFound = new Artist($conn, $row['id']);

            echo "
            <div class='searchResultRow'>
                <div class='artistName'>
                    <span role='link' tabindex='0' onclick='openPage(\"artist?id=". $artistFound->getId() ."\");'>".$artistFound->getName()."</span>
                </div>
            </div>
            ";
        }
    ?>
</div>


<div class="gridViewContainer">
    <h2>ALBUMS</h2>
    <?php 
        $albumQUery = mysqli_query($conn, "SELECT * FROM Albums WHERE title LIKE '$term%' LIMIT 10");

        if(mysqli_num_rows($albumQUery) == 0) {
            echo "<span class='noResults'>No albums found matching " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($albumQUery)) {
            echo "
            <div class='gridViewItem'>
                <span role='link' tabindex='0' onclick='openPage(\"album?id=".$row['id']."\");'>
                    <img src='".$row['artworkPath']."'>
                    <div class='gridViewInfo'>
                        ".$row['title']."
                    </div>
                </span>
            </div>
            ";
        }
    ?>
</div>


<nav class="optionsMenu">
    <input type="hidden" class="songId">    
    <?php echo Playlist::getPlaylistDropdown($conn, $userLoggedIn->getUsername()); ?>
</nav>