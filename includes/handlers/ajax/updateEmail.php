<?php 
include_once '../../config.php';
include_once '../../../functions/escape.php';

if(!isset($_POST['username'])) {
    echo "Error, username missing";
    exit();
}

if(isset($_POST['email']) && !empty($_POST['email'])) {
    $username = $_POST['username'];
    $email = escape($_POST['email']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email is invalid";
        exit();
    }

    $updateQuery = mysqli_query($conn, "UPDATE Users SET email = '$email' WHERE username = '$username'");
    echo 'Email successfully updated
    <script>
        alertify.notify("Saved new email", "custom", 3);
    </script>
    ';
} else {
    echo "Email missing";
}
?>