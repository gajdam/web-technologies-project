<?php 
require_once('config.php');

if(isset($_POST['username']) && isset($_POST['password'])) {
    $login = $_POST['username'];
    $form_password = $_POST['password'];

    $conn = new mysqli($serwer, $user, $password, $dbname);
    $sql = "SELECT * FROM users WHERE username = '$login'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_salt = $row['salt'];
        $stored_password = $row['password'];

        $hashed_password = password_hash($form_password,  PASSWORD_DEFAULT);
        if (password_verify($form_password, $stored_password)) {
            // if ($hashed_password == $stored_password) {
            session_start();
            $_SESSION['login'] = $_POST['username'];
            header('Location: main_page.php');
            exit;
        } else {
            echo 'Bledne dane logowania ale w logowaniu';
        }
    } else {
        echo 'Bledne dane logowania';
    }

    $conn->close();
}
?>
