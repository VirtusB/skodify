<?php 
include_once 'includes/includedFiles.php';
?>

<div class="playlistsContainer">
    <div class="gridViewContainer">
        <h2>PLAYLISTS</h2>
        <div class="buttonItems">
            <button onclick="createPlaylist();" class="button green">NEW PLAYLIST</button>
        </div>
        <?php 
            $username = $userLoggedIn->getUsername();
            $playlistsQuery = mysqli_query($conn, "SELECT * FROM Playlists WHERE owner = '$username'");

            if(mysqli_num_rows($playlistsQuery) == 0) {
                echo "<span class='noResults'>No playlists yet</span>";
            }

            while($row = mysqli_fetch_array($playlistsQuery)) {
                $playlist = new Playlist($conn, $row);

                echo "
                <div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist?id=".$playlist->getId()."\")'>
                    <div class='playlistImage'>
                    <svg width='200' height='200' viewBox='0 0 219 219' xmlns='http://www.w3.org/2000/svg'><path fill='#282828' d='M0 0h219v219H0V0z'/><path fill='#404040' d='M141.67 67.61c4.64-.92 9.22-2.22 13.95-2.59-.05 23.66 0 47.33-.03 70.99.02 5.55-2.86 11-7.42 14.16-6.82 4.96-17.38 4.06-22.94-2.43-7-7.21-5.77-20.32 2.57-26 4.66-3.47 11.17-4.29 16.57-2.16 2.64 1.23 4.95 3.06 7.39 4.64.17-18.29.1-36.59.03-54.88-19.47 3.96-38.89 8.23-58.35 12.31-.24 2.43-.44 4.86-.32 7.31.1 18.03-.04 36.05.07 54.08.23 5.78-.38 12.15-4.76 16.41-6.4 7.59-19.37 7.5-25.74-.07-6.41-6.7-5.88-18.47 1.03-24.62 4.49-4.2 11.34-5.93 17.19-3.81 3.12 1.06 5.66 3.25 8.31 5.13.5-19.13-.09-38.28.29-57.41 17.38-3.71 34.78-7.37 52.16-11.06z'/><path fill='#282828' d='M135.36 122.34c8.19-1.9 17.03 5.19 16.5 13.69.4 8.56-8.77 15.6-16.94 13.24-6.04-1.29-10.66-7.08-10.59-13.25-.14-6.39 4.73-12.49 11.03-13.68zM72.25 134.28c7.42-2.07 15.62 3.14 16.94 10.7 1.88 7.95-4.93 16.62-13.2 16.24-7.33.63-14.17-5.88-14.18-13.17-.29-6.3 4.33-12.34 10.44-13.77z'/></svg>
                    </div>
                    <div class='gridViewInfo'>
                        ".$playlist->getName()."
                    </div>
                </div>
                ";
            }
    ?>
    </div>
</div>