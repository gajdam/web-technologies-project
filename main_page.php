
<?php 
require_once('config.php');
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

class Post
{
    public $id;
    public $title;
    public $content;
    public $photo;
    public $author_id;
    public $localization;
    public $author_name;

    public function displayPost()
    {
        echo '<div>';
        echo '<h2>' . $this->title . '</h2>';
        echo '<p>' . $this->content . '</p>';
        echo '<p>Author: ' . $this->author_name . '</p>';
        echo '<p>Localization: ' . $this->localization . '</p>';

        // Jeśli istnieje ścieżka do zdjęcia, wyświetl je
        if ($this->photo) {
            echo '<img src="' . $this->photo . '" alt="Post Photo">';
        }

        echo '</div>';
    }
}

class PostManager
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getPosts()
    {
        $posts = [];

        // Zapytanie SQL do pobrania postów z dołączeniem informacji o autorze
        $sql = "SELECT posts.id, posts.title, posts.content, posts.photo, posts.author_id, posts.localization, users.username 
                FROM posts
                JOIN users ON posts.author_id = users.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post = new Post();
            $post->id = $row['id'];
            $post->title = $row['title'];
            $post->content = $row['content'];
            $post->photo = $row['photo'];
            $post->author_id = $row['author_id'];
            $post->localization = $row['localization'];
            $post->author_name = $row['username'];

            $posts[] = $post;
        }

        return $posts;
    }
}

try {
    $db = new PDO('mysql:host='.$serwer.';dbname='.$dbname, $user, $password);
} catch (PDOException $e) {
    echo 'Połączenie nieudane: ' . $e->getMessage();
    exit();
}

$postManager = new PostManager($db);

$posts = $postManager->getPosts();

if (!empty($posts)) {
    foreach ($posts as $post) {
        $post->displayPost();
    }
} else {
    echo 'Brak dostępnych postów.';
}

$db = null;
?>
