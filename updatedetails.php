<?php 
include_once 'includes/includedFiles.php';
?>

<div class="userDetails">
    <div class="container borderBottom">
        <h2>EMAIL</h2>
        <input value="<?php echo $userLoggedIn->getEmail(); ?>" type="text" class="email" name="email" placeholder="Email address">
        <span class="message"></span>
        <button class="button" onclick="updateEmail('email')">UPDATE</button>
    </div>
    <div class="container">
        <h2>PASSWORD</h2>
        <input type="password" class="oldPassword" name="oldPassword" placeholder="Current password">
        <input type="password" class="newPassword" name="newPassword" placeholder="New password">
        <input type="password" class="newPasswordConfirm" name="newPasswordConfirm" placeholder="Confirm new password">
        <span class="message"></span>
        <button class="button" onclick="updatePassword('oldPassword', 'newPassword', 'newPasswordConfirm');">UPDATE</button>
    </div>
</div>