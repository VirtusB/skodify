<?php
include_once 'includes/includedFiles.php';
?>

<div class="entityInfo">
    <div class="centerSection">
        <div class="userInfo">
            <h1><?php echo $userLoggedIn->getFullname(); ?></h1>
        </div>
    </div>
    <div class="buttonItems">
        <button onclick="openPage('updatedetails');" class="button">USER DETAILS</button>
        <button onclick="logout();" class="button">LOGOUT</button>
    </div>
</div>