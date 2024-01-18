<?php 

require_once('config.php');

$conn = new mysqli($serwer, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $salt = bin2hex(random_bytes(16));

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password, salt) VALUES ('$username', '$hashed_password', '$salt')";
    $conn->query($sql);
}


?>