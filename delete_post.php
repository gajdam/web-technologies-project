<?php 
require_once('config.php');
$conn = new mysqli($serwer, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['idp'];

$stmt = $conn->prepare("DELETE FROM comments WHERE post_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute() === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $stmt->error;
}
$stmt->close();
?>
<a href="main_page.php?flag=true"><button>Wróć</button></a>