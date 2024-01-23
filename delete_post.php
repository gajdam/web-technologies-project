<?php 
require_once('config.php');
$conn = new mysqli($serwer, $user, $password, $dbname);
$id = $_GET['idp'];
$sql = "DELETE FROM posts WHERE id = $id";

?>
<a href="main_page.php"><button>Wróć</button></a>