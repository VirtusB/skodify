<?php 
include_once '../../config.php';

if(isset($_POST['playlistId'])) {
    $playlistId = $_POST['playlistId'];

    $playlistQuery = mysqli_query($conn, "DELETE FROM Playlists WHERE id = '$playlistId'");
    $songsQuery = mysqli_query($conn, "DELETE FROM playlistSongs WHERE playlistId = '$playlistId'");
} else {
    echo "Something went wrong, try again later. (deletePlaylist error)";
}


?>