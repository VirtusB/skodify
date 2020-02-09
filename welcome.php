<?php
include_once 'includes/config.php';
include_once 'functions/escape.php';
include_once 'includes/classes/Account.php';
include_once 'includes/classes/Constants.php';

$account = new Account($conn);

include_once 'includes/handlers/register-handler.php';
include_once 'includes/handlers/login-handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Skodify</title>
    <link rel="stylesheet" href="assets/css/register.css">
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="assets/js/register.js"></script>
    <link rel="stylesheet" href="assets/fontawesome/css/fontawesome-all.min.css">
</head>
<body>
    <?php 
        if(isset($_POST['registerButton'])) {
            echo '
                <style>
                    #loginForm {
                        display: none;
                    }
                    #registerForm {
                        display: block;
                    }
                </style>
            ';
        } else {
            echo '
            <style>
                #loginForm {
                    display: block;
                }
                #registerForm {
                    display: none;
                }
        </style>
            ';
        }
    ?>
    
<div id="background">
    <div id="loginContainer">
        <div id="inputContainer">
            <form method="post" action="welcome" id="loginForm">
                <h2>Login to your account</h2>
                <?php echo $account->getError(Constants::$usernameNonexistent); ?>
                <?php echo $account->getError(Constants::$incorrectPassword); ?>
                <label for="loginUsername">Username</label>
                <input value="<?php echo escape($_POST['loginUsername'] ?? '') ?>" required placeholder="Username" id="loginUsername" name="loginUsername" type="text">
                <br>
                <label for="loginPassword">Password</label>
                <input required placeholder="Password" id="loginPassword" name="loginPassword" type="password">
                
                <br>
                <button name="loginButton" type="submit">Log in</button>

                <div class="hasAccountText">
                    <a href="javascript:void(0);">
                        <span id="hideLogin">Don't have an account yet? Create account here.</span>
                    </a>
                </div>
            
            </form>


            <form method="post" action="welcome" id="registerForm">
                <h2>Create an account</h2>
                <?php echo $account->getError(Constants::$usernameLength); ?>
                <?php echo $account->getError(Constants::$usernameTaken); ?>
                <label for="username">Username</label>
                <input value="<?php echo escape($_POST['username'] ?? '') ?>" required placeholder="Username" id="username" name="username" type="text">
                <br>
                <?php echo $account->getError(Constants::$firstNameLength); ?>
                <label for="firstName">First name</label>
                <input value="<?php echo escape($_POST['firstName'] ?? '') ?>" required placeholder="First name" id="firstName" name="firstName" type="text">
                <br>
                <?php echo $account->getError(Constants::$lastNameLength); ?>
                <label for="lastName">Last name</label>
                <input value="<?php echo escape($_POST['lastName'] ?? '') ?>" required placeholder="Last name" id="lastName" name="lastName" type="text">
                <br>            
                <?php echo $account->getError(Constants::$emailsNotMatching); ?>            
                <?php echo $account->getError(Constants::$emailNotValid); ?>            
                <label for="email">Email</label>
                <input value="<?php echo escape($_POST['email'] ?? '') ?>" required placeholder="Email" id="email" name="email" type="email">
                <br>            
                <label for="confirmEmail">Email again</label>
                <input value="<?php echo escape($_POST['confirmEmail'] ?? '') ?>" required placeholder="Confirm email" id="confirmEmail" name="confirmEmail" type="email">
                <br>
                <?php echo $account->getError(Constants::$passwordsNotMatching); ?>            
                <?php echo $account->getError(Constants::$passwordLength); ?>            
                <label for="password">Password</label>
                <input required placeholder="Password" id="password" name="password" type="password">
                <br>
                <label for="confirmPassword">Password again</label>
                <input required placeholder="Confirm password" id="confirmPassword" name="confirmPassword" type="password">
                
                <br>
                <button name="registerButton" type="submit">Create account</button>

                <div class="hasAccountText">
                    <a href="javascript:void(0);">
                        <span id="hideRegister">Already have an account? Log in here.</span>
                    </a>
                </div>
            
            </form>

        </div>

        <div id="loginText">
            <h1>Great music, anytime</h1>
            <h2>Listen to lots of songs, completely free</h2>
            <ul>
                <li><i class="fa fa-check"></i> Discover new music</li>
                <li><i class="fa fa-check"></i> Create your own playlists</li>
                <li><i class="fa fa-check"></i> Follow your favorite artists</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
