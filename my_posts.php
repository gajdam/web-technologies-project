<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['login'])) {
    echo "Access Denied. You are not logged in.";
    // Opcjonalnie możesz przekierować użytkownika na stronę logowania
    // header('Location: login.php');
    // exit();
} else {
    // Tutaj umieść treść, do której dostęp jest tylko dla zalogowanych użytkowników
    echo "Welcome! This content is only accessible to logged-in users.";
    include('navbar_logged_in.html');

}
?>
