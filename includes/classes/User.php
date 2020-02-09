<?php
class User {
    private $conn;
    private $username;

    public function __construct($conn, $username) {
        $this->conn = $conn;
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getFullName() {
        $query = mysqli_query($this->conn, "SELECT concat(firstName, ' ', lastName) as 'name' FROM Users WHERE username = '$this->username' ");
        $row = mysqli_fetch_array($query);
        return $row['name'];
    }

    public function getEmail() {
        $query = mysqli_query($this->conn, "SELECT email FROM Users WHERE username = '$this->username' ");
        $row = mysqli_fetch_array($query);
        return $row['email'];
    }
}
?>