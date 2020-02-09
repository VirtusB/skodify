<?php
class Account {
    private $errorArray;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->errorArray = array();
    }

    public function login($un, $ps) {
        $passwordQuery =  mysqli_query($this->conn, "SELECT userpassword FROM Users WHERE username ='$un'")->fetch_object()->userpassword;
        if(empty($passwordQuery)) {
            array_push($this->errorArray, Constants::$usernameNonexistent);
            return false;
        }
        if(!password_verify($ps, $passwordQuery)) {
            array_push($this->errorArray, Constants::$incorrectPassword);
            return false;
        } else {
            return true;
        }
    }

    public function register($un, $fn, $ln, $em, $emCf, $ps, $psCf) {
        $this->validateUsername($un);
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateEmails($em, $emCf);
        $this->validatePasswords($ps, $psCf);

        if(empty($this->errorArray)) {
            return $this->insertUser($un, $fn, $ln, $em, $ps);
        } else {
            return false;
        }
    }

    public function getError($err) {
        if(!in_array($err, $this->errorArray)) {
            $err = "";
        }
        return "<span class='error-message'>$err</span>";
    }

    private function insertUser($un, $fn, $ln, $em, $ps) {
        $hashedPassword = password_hash($ps, PASSWORD_DEFAULT);
        $profilePic = "assets/images/profile-pics/placeholder.jpg";
        $date = date("Y-m-d");

        $result = mysqli_query($this->conn, "INSERT INTO Users VALUES ('', '$un', '$fn', '$ln', '$em', '$hashedPassword', '$date', '$profilePic')");
        return $result;
    }

    private function validateUsername($un) {
        if (strlen($un) > 25 || strlen($un) < 5) {
            array_push($this->errorArray, Constants::$usernameLength);
            return;
        }
        $checkUsernameQuery = mysqli_query($this->conn, "SELECT username FROM Users WHERE username ='$un'");
        if(mysqli_num_rows($checkUsernameQuery) != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
            return;
        }
    }
    
    private function validateFirstName($fn) {
        if (strlen($fn) > 25 || strlen($fn) < 2) {
            array_push($this->errorArray, Constants::$firstNameLength);
            return;
        }
    }
    
    private function validateLastName($ln) {
        if (strlen($ln) > 25 || strlen($ln) < 2) {
            array_push($this->errorArray, Constants::$lastNameLength);
            return;
        }
    }
    
    private function validateEmails($em, $emCf) {
        if ($em != $emCf) {
            array_push($this->errorArray, Constants::$emailsNotMatching);            
            return;
        } else if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailNotValid);            
            return;
        }
    }
    
    private function validatePasswords($ps, $psCf) {
        if ($ps != $psCf) {
            array_push($this->errorArray, Constants::$passwordsNotMatching);            
            return;
        } else if (strlen($psCf) > 30 || strlen($psCf) < 6) {
            array_push($this->errorArray, Constants::$passwordLength);
            return;
        }
    }
}
?>