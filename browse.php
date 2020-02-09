<?php 
include_once 'includes/includedFiles.php'; 
?>

<h1 class="pageHeadingBig">You might also like</h1>

<div class="gridViewContainer">
    <?php 
        $albumQUery = mysqli_query($conn, "SELECT * FROM Albums ORDER BY RAND() LIMIT 10");

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
