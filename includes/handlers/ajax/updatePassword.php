<?php 
include_once '../../config.php';
include_once '../../../functions/escape.php';

if(!isset($_POST['username'])) {
    echo "Error, username missing";
    exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword']) || !isset($_POST['newPasswordConfirm'])) {
    echo "POST error, updatePassword, try again later";
    exit();
}

if(empty($_POST['oldPassword']) || empty($_POST['newPassword']) || empty($_POST['newPasswordConfirm'])) {
    echo "You need to fill in all 3 passwords";
    exit();
}

$username = $_POST['username'];
$oldPassword = escape($_POST['oldPassword']);
$newPassword = escape($_POST['newPassword']);
$newPasswordConfirm = escape($_POST['newPasswordConfirm']);

$dbPassword = mysqli_query($conn, "SELECT userpassword FROM Users WHERE username = '$username'")->fetch_object()->userpassword;

if(!password_verify($oldPassword, $dbPassword)) {
    echo 'Current password is incorrect';
    exit();
}

if($newPassword != $newPasswordConfirm) {
    echo "Your new password doesn't matched the confirmed password";
    exit();
}

if (strlen($newPassword) > 30 || strlen($newPassword) < 6) {
    echo "Your new password has to be between 6 characters and 30 characters long";
    exit();
}

$newHashed = password_hash($newPassword, PASSWORD_DEFAULT);

$query = mysqli_query($conn, "UPDATE Users SET userpassword = '$newHashed' WHERE username = '$username'");

echo 'Password successfully updated
    <script>
        alertify.notify("Saved new password", "custom", 3);
    </script>
    ';
?>


