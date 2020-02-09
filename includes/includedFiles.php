<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    include_once 'includes/config.php';
    include_once 'includes/classes/User.php';
    include_once 'includes/classes/Artist.php';
    include_once 'includes/classes/Album.php';
    include_once 'includes/classes/Song.php';
    include_once 'includes/classes/Playlist.php';
    include_once 'functions/escape.php';
    if(isset($_GET['userLoggedIn'])) {
        $userLoggedIn = new User($conn, $_GET['userLoggedIn']);
    } else {
        echo "userLoggedIn empty";
    }
} else {
    include_once 'includes/header.php';
    include_once 'includes/footer.php';

    $url = $_SERVER['REQUEST_URI'];
    echo "
        <script>
            openPage('$url');
        </script>
    ";
    exit();
}
?>