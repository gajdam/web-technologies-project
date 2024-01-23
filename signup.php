<?php

require_once('config.php');

class UserRegistration {
    private $conn;

    public function __construct($serwer, $user, $password, $dbname) {
        $this->conn = new mysqli($serwer, $user, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function registerUser($username, $password) {
        // $salt = bin2hex(random_bytes(16));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // $sql = "INSERT INTO users (username, password, salt) VALUES ('$username', '$hashed_password', '$salt')";
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        $this->conn->query($sql);
    }
}

$userRegistration = new UserRegistration($serwer, $user, $password, $dbname);

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userRegistration->registerUser($username, $password);
}

?>