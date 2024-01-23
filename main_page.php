
<?php 
session_start();
if (isset($_SESSION['login'])) {
    include('navbar_logged_in.html');
}
else {
    include('navbar.html');
}

// if (session_status() == PHP_SESSION_NONE) {
//     include('navbar.html'); 
// }
// else {
//     include('navbar_logged_in.html');
// }
// session_destroy();



?>

