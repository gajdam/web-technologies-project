<?php
require_once('config.php');
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}
$author_id = $_SESSION['login'];
$post_id = $_GET['idp'];

echo '<form action="add_comment.php" method="POST">';
echo '    <label for="comment">Content:</label>';
echo '    <textarea id="content" name="content" rows="4" cols="50"></textarea>';
echo '    <input type="hidden" name="idp" value="' . $post_id . '">'; // Hidden input field for idp
echo '    <br>';
echo '    <input type="submit" value="Add comment">';
echo '</form>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $post_id = $_POST['idp'];

    try {
        $db = new PDO('mysql:host='.$serwer.';dbname='.$dbname, $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO comments (content, user_id, post_id) 
                VALUES (:content, :author_id, :post_id)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();

        header('Location: main_page.php?flag=true');
        exit();
    } catch (PDOException $e) {
        echo 'Błąd: ' . $e->getMessage();
    }
}
?>
