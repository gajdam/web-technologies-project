<link rel="stylesheet" type="text/css" href="style2.css">

<?php 
require_once('config.php');
require_once('comments.php');
session_start();

if (isset($_SESSION['login'])) {
    include('navbar_logged_in.html');
} else {
    include('navbar.html');
}

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
        $currentUser = isset($_SESSION['login']) ? $_SESSION['login'] : null;
        $flag = isset($_GET['flag']) ? $_GET['flag'] : null;

        echo '<div class="post-container">';
        echo '<h2 class="post-title">' . $this->title . '</h2>';
        echo '<p class="post-content">' . $this->content . '</p>';
        echo '<p class="post-author">Author: ' . $this->author_name . '</p>';
        echo '<p class="post-localization">Localization: ' . $this->localization . '</p>';

        if ($this->photo) {
            echo '<img class="post-photo" src="' . $this->photo . '" alt="Post Photo">';
        }

        if ($flag) {
            if ($currentUser) {
                echo '<a href="print_post.php?idp=' . $this->id . '"><button class="btn">print</button></a>';
                echo '<a href="add_comment.php?idp=' . $this->id . '"><button class="btn">add comment</button></a>';
            }
        }

        if ($currentUser && $currentUser == $this->author_id) {
            echo '<a href="update_post_form.php?idp=' . $this->id . '"><button class="btn">edit</button></a>';
            echo '<a href="delete_post.php?idp=' . $this->id . '"><button class="btn">delete</button></a>';
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
$commentManager = new CommentManager($db);

$posts = $postManager->getPosts();

if (!empty($posts)) {
    foreach ($posts as $post) {
        $post->displayPost();
        $comments = $commentManager->getCommentsByPostId($post->id);
        if (!empty($comments)) {
            echo '<div class="comments-container">';
            echo '<h3 class="comments-heading">Komentarze:</h3>';
            foreach ($comments as $comment) {
                echo '<p class="comment"><strong>' . $comment->authorName . ':</strong> ' . $comment->content;

                if (isset($_SESSION['login']) && ($_SESSION['login'] == $comment->author_id || $_SESSION['login'] == $post->author_id)) {
                    echo ' <a class="delete-link" href="delete_com.php?idc=' . $comment->id . '">Usuń</a>';
                }

                echo '</p>';
            }
            echo '</div>';
        } else {
            echo '<p class="no-comments">Brak komentarzy.</p>';
        }
    }
} else {
    echo '<p class="no-posts">Brak dostępnych postów.</p>';
}

$db = null;
?>
