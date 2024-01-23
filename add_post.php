<?php
require_once('config.php');
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $localization = $_POST['localization'];
    $author_id = $_SESSION['login'];

    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    try {
        $db = new PDO('mysql:host='.$serwer.';dbname='.$dbname, $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO posts (title, content, photo, author_id, localization) 
                VALUES (:title, :content, :photo, :author_id, :localization)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->bindParam(':localization', $localization);
        $stmt->execute();

        header('Location: main_page.php');
        exit();
    } catch (PDOException $e) {
        echo 'Błąd: ' . $e->getMessage();
    }
}
?>
