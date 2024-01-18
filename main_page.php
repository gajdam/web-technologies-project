
<?php 
session_start();
if (session_status() == PHP_SESSION_NONE) {
    include('navbar.html'); 
}
else {
    include('navbar_logged_in.html');
}
session_destroy();



?>

