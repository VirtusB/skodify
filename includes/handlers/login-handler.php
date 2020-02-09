<?php
if (isset($_POST['loginButton'])) {
    $username = escape($_POST['loginUsername']);
    $password = escape($_POST['loginPassword']);

    $result = $account->login($username, $password);

    if($result) {
        $_SESSION['userLoggedIn'] = $username;
        header("Location: /");
    }
} 
?>