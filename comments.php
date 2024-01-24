<?php
class Comment
{
    public $id;
    public $authorName;
    public $content;
    public $author_id;
}

class CommentManager
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getCommentsByPostId($postId)
    {
        $comments = [];

        try {
            $sql = "SELECT comments.content, users.username, comments.user_id, comments.id 
                    FROM comments
                    JOIN users ON comments.user_id = users.id
                    WHERE comments.post_id = :post_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':post_id', $postId);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $comment = new Comment();
                $comment->content = $row['content'];
                $comment->authorName = $row['username'];
                $comment->author_id = $row['user_id'];
                $comment->id = $row['id'];

                $comments[] = $comment;
            }

            return $comments;
        } catch (PDOException $e) {
            echo 'Błąd: ' . $e->getMessage();
            return [];
        }
    }
}
?>

