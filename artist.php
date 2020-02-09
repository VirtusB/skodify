<?php 
include_once 'includes/includedFiles.php';

if(isset($_GET['id'])) {
    $artistId = $_GET['id'];
} else {
    header("Location: /");
}

$artist = new Artist($conn, $artistId);

?>

<div class="entityInfo borderBottom">
    <div class="centerSection">
        <div class="artistInfo">
            <h1 class="artistName"><?php echo $artist->getName(); ?></h1>
            <div class="headerButtons">
                <button onclick="playFirstSong();" class="button green">PLAY</button>
            </div>
        </div>
    </div>
</div>



<div class="trackListContainer borderBottom">
    <h2>POPULAR</h2>
    <ul class="trackList"> 
        <?php 
            $songIdArray = $artist->getSongIds();
            $i = 1;

            foreach($songIdArray as $songId) {
                if($i > 5) {
                    break;
                }
                $albumSong = new Song($conn, $songId);
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


<div class="gridViewContainer">
    <h2>ALBUMS</h2>
    <?php 
        $albumQUery = mysqli_query($conn, "SELECT * FROM Albums WHERE artist = '$artistId'");

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