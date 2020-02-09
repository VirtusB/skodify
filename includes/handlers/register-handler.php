<?php

function sanitizePassword($input) {
    $input = strip_tags($input);
    return $input;
}

function sanitizeUsername($input) {
    $input = str_replace(" ", "", strip_tags($input));
    return $input;
}

function sanitizeString($input) {
    $input = ucfirst(strtolower(str_replace(" ", "", strip_tags($input))));
    return $input;
}



if (isset($_POST['registerButton'])) {
    $username = sanitizeUsername($_POST['username']);
    $firstName = sanitizeString($_POST['firstName']);
    $lastName = sanitizeString($_POST['lastName']);
    $email = strtolower(sanitizeString($_POST['email']));
    $confirmEmail = strtolower(sanitizeString($_POST['confirmEmail']));
    $password = sanitizePassword($_POST['password']);
    $confirmPassword = sanitizePassword($_POST['confirmPassword']);

    $result = $account->register($username, $firstName, $lastName, $email, $confirmEmail, $password, $confirmPassword);
    if($result) {
        $_SESSION['userLoggedIn'] = $username;
        header('Location: /');
    }
}

?>