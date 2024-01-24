<?php 
require_once('config.php');
header('Content-Type: application/msword');
$conn = new mysqli($serwer, $user, $password, $dbname);
$id = $_GET['idp'];
$sql = "SELECT * FROM posts where id = $id";
$score = $conn->query($sql);
$record = $score->fetch_assoc();

$file_name = 'post.rtf';
$file = fopen($file_name, 'r');

$data = fread($file, filesize($file_name));
$data = str_replace('<title>', $record['title'], $data);
$data = str_replace('<content>', $record['content'], $data);
$data = str_replace('<localization>', $record['localization'], $data);

echo $data;

?>

<a href="main_page.php?flag=true"><button>Wróć</button></a>