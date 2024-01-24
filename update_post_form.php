<?php 
require_once('config.php');
$conn = new mysqli($serwer, $user, $password, $dbname);
$id = $_GET['idp'];
$sql = "SELECT * FROM posts where id = $id";
$score = $conn->query($sql);

$rekord = $score->fetch_assoc();
echo "<form method='POST' action='update_post.php?idp=$id'>";
echo "<input name='title' value='".$rekord['title']."'>";
echo "<input name='content' value='".$rekord['content']."'>";
echo "<input name='photo' value='".$rekord['photo']."'>";
echo "<input name='localization' value='".$rekord['localization']."'>";

echo "<input type=submit>";
echo "</form>";
?>

<a href="main_page.php?flag=true"><button>Wróć</button></a>