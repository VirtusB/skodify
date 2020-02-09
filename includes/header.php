<?php
include_once 'includes/config.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Artist.php';
include_once 'includes/classes/Album.php';
include_once 'includes/classes/Song.php';
include_once 'includes/classes/Playlist.php';
include_once 'functions/escape.php';

if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = new User($conn, $_SESSION['userLoggedIn']);
    $username = $userLoggedIn->getUsername();
    echo "
        <script>
            userLoggedIn = '$username';
        </script>
    ";
} else {
    header('Location: welcome');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Skodify</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/fontawesome/css/fontawesome-all.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="assets/js/script.js"></script>
    <link rel="stylesheet" href="assets/css/alertify.min.css">
    <link rel="stylesheet" href="assets/css/theme-alertify.css">
    <script src="assets/js/alertify.min.js"></script>
</head>
<body>
    <div id="mainContainer">
        <div id="topContainer">
            <?php include_once 'includes/navBarContainer.php' ?>
            <div id="mainViewContainer">
                <div id="mainContent">