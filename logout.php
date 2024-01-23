<?php
session_start();

function logout() {
    // Remove all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Optionally, you can redirect the user to the login page
    header('Location: login.html');
    exit();
}

// Example usage
logout();
?>
