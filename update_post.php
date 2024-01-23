<?php 
require_once('config.php');
$conn = new mysqli($serwer, $user, $password, $dbname);
$id = $_GET['idp'];
$sql = "UPDATE posts SET title = ?, content = ?, photo = ?, localization = ? WHERE id = $id";
$prep = $conn->prepare($sql);
$prep->bind_param('ssss', $_POST['title'], $_POST['content'], $_POST['photo'], $_POST['localization']);
$prep->execute();

?>
<a href="main_page.php"><button>Wróć</button></a>