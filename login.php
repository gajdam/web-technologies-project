<?php

require_once('config.php');

class UserLogin {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($GLOBALS['serwer'], $GLOBALS['user'], $GLOBALS['password'], $GLOBALS['dbname']);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function loginUser($login, $formPassword) {
        $sql = "SELECT * FROM users WHERE username = '$login'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedSalt = $row['salt'];
            $storedPassword = $row['password'];

            $hashedPassword = password_hash($formPassword, PASSWORD_DEFAULT);
            if (password_verify($formPassword, $storedPassword)) {
                session_start();
                $_SESSION['login'] = $row['id'];
                $_SESSION['is_admin'] = $row['is_admin'];
                
                // Logowanie powiodło się
                $this->logger('Successful login for user: ' . $login);
                
                header('Location: main_page.php?flag=true');
                exit;
            } else {
                // Błąd logowania
                $this->logger('Failed login attempt for user: ' . $login);
                echo 'Błędne dane logowania';
            }
        } else {
            // Błąd logowania
            $this->logger('Failed login attempt for user: ' . $login);
            echo 'Błędne dane logowania';
        }
    }
    
    public function logger($message) {
        $logFile = 'login_logs.txt';
        $logData = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
        file_put_contents($logFile, $logData, FILE_APPEND);
    }
}

// Użycie klasy
$userLogin = new UserLogin();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $login = $_POST['username'];
    $formPassword = $_POST['password'];

    $userLogin->loginUser($login, $formPassword);
}

?>
