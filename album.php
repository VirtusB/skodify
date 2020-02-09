<?php include_once 'includes/includedFiles.php'; 

if(isset($_GET['id'])) {
    $albumId = $_GET['id'];
} else {
    header("Location: /");
}

$album = new Album($conn, $albumId);
$artist = $album->getArtist();
?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>" alt="">
    </div>
    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <span>By <?php echo $artist->getName(); ?></span>
        <p><?php echo ($album->getSongCount() > 1) ? "".$album->getSongCount()." songs":"1 song"; ?></p>
    </div>
</div>

<div class="trackListContainer">
    <ul class="trackList"> 
        <?php 
            $songIdArray = $album->getSongIds();
            $i = 1;

            foreach($songIdArray as $songId) {
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

<nav class="optionsMenu">
    <input type="hidden" class="songId">    
    <?php echo Playlist::getPlaylistDropdown($conn, $userLoggedIn->getUsername()); ?>
</nav>
