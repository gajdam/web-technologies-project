<?php 
require_once('config.php');
$conn = new mysqli($serwer, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['idc'];

$stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute() === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $stmt->error;
}
$stmt->close();
?>
<a href="main_page.php"><button>Wróć</button></a>