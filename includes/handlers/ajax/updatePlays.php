<?php 
include_once '../../config.php';

if (isset($_POST['songId'])) {
    $songId = $_POST['songId'];

    mysqli_query($conn, "UPDATE Songs SET plays = plays + 1 WHERE id ='$songId'");
}

?>