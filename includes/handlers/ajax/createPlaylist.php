<?php 
include_once '../../config.php';
include_once '../../../functions/escape.php';

if(isset($_POST['title']) && isset($_POST['username'])) {
    $title = escape($_POST['title']);
    $username = $_POST['username'];
    $date = date("Y-m-d");

    $query = mysqli_query($conn, "INSERT INTO Playlists VALUES('', '$title', '$username', '$date')");
} else {
    echo "Something went wrong, try again later. (createPlaylist error)";
}


?>