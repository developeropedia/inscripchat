<?php
  class Comment {
    private $db;
    private $userModel;

    public function __construct(){
      $this->db = Database::getInstance();
      $this->userModel = new User;
    }

    public function insert($post_id, $comment)
    {
        $user_id = $_SESSION['user_id'];
        $this->db->query("INSERT INTO post_comments (post_id, user_id, comment) VALUES (:post_id, :user_id, :comment)");
        $this->db->bind(':post_id', $post_id);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':comment', $comment);
        $res = $this->db->execute();

        if($res) {
            $lastCommentID = $this->db->lastInsertID();
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            $user->commentID = $lastCommentID;
            return $user;
        } else {
            return false;
        }
    }

    public function reply($post_id, $comment_id, $reply) {
        $user_id = $_SESSION['user_id'];
        $this->db->query("INSERT INTO comment_replies (comment_id, user_id, reply) VALUES (:comment_id, :user_id, :reply)");
        $this->db->bind(':comment_id', $comment_id);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':reply', $reply);
        $res = $this->db->execute();

        if ($res) {
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            $user->replyID = $this->db->lastInsertID();
            return $user;
        } else {
            return false;
        }
    }

    public function getPostComments($post_id) {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT pc.*, users.name, users.img, users.username, cl.like_dislike
              FROM post_comments pc
              LEFT JOIN users ON pc.user_id = users.id
              LEFT JOIN comment_likes cl ON pc.id = cl.comment_id AND cl.user_id = :user_id
              WHERE pc.post_id = :post_id
              ORDER BY (
                  SELECT COUNT(*) FROM comment_likes
                  WHERE comment_id = pc.id AND like_dislike = 1
              ) DESC";

        $this->db->query($query);
        $this->db->bind(":post_id", $post_id);
        $this->db->bind(":user_id", $user_id);
        $comments = $this->db->resultSet();

        return $comments;
    }


    public function getCommentReplies($comment_id) {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT cr.*, users.name, users.img, users.username, rl.like_dislike
              FROM comment_replies cr
              LEFT JOIN users ON cr.user_id = users.id
              LEFT JOIN reply_likes rl ON cr.id = rl.reply_id AND rl.user_id = :user_id
              WHERE cr.comment_id = :comment_id
              ORDER BY (
                  SELECT COUNT(*) FROM reply_likes
                  WHERE reply_id = cr.id AND like_dislike = 1
              ) DESC";

        $this->db->query($query);
        $this->db->bind(":comment_id", $comment_id);
        $this->db->bind(":user_id", $user_id);
        $replies = $this->db->resultSet();

        return $replies;
    }


    public function like_dislike($comment_id, $like_dislike) {
        $user_id = $_SESSION['user_id'];
        $this->db->query("SELECT * FROM comment_likes WHERE comment_id = :comment_id AND user_id = :user_id");
        $this->db->bind(':comment_id', $comment_id);
        $this->db->bind(':user_id', $user_id);

        $userLikeExists = $this->db->single();
        $like_dislike_count = new stdClass;
        $result = false;

        if (empty($userLikeExists)) {
            $this->db->query("INSERT INTO comment_likes (comment_id, user_id, like_dislike) VALUES (:comment_id, :user_id, :like_dislike)");
            $this->db->bind(':comment_id', $comment_id);
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':like_dislike', $like_dislike);
            $result = $this->db->execute();
        } else {
            $this->db->query("UPDATE comment_likes SET like_dislike = :like_dislike WHERE comment_id = :comment_id AND user_id = :user_id");
            $this->db->bind(':like_dislike', $like_dislike);
            $this->db->bind(':comment_id', $comment_id);
            $this->db->bind(':user_id', $user_id);
            $result = $this->db->execute();
        }

        if (!$result) {
            return false;
        } else {
            $likes_dislikes = $this->getCommentLikesDislikes($comment_id);
            $like_dislike_count->likes = $likes_dislikes->likes;
            $like_dislike_count->dislikes = $likes_dislikes->dislikes;

            return $like_dislike_count;
        }
    }

    public function reply_like_dislike($reply_id, $like_dislike) {
        $user_id = $_SESSION['user_id'];
        $this->db->query("SELECT * FROM reply_likes WHERE reply_id = :reply_id AND user_id = :user_id");
        $this->db->bind(':reply_id', $reply_id);
        $this->db->bind(':user_id', $user_id);

        $userLikeExists = $this->db->single();
        $like_dislike_count = new stdClass;
        $result = false;

        if (empty($userLikeExists)) {
            $this->db->query("INSERT INTO reply_likes (reply_id, user_id, like_dislike) VALUES (:reply_id, :user_id, :like_dislike)");
            $this->db->bind(':reply_id', $reply_id);
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':like_dislike', $like_dislike);
            $result = $this->db->execute();
        } else {
            $this->db->query("UPDATE reply_likes SET like_dislike = :like_dislike WHERE reply_id = :reply_id AND user_id = :user_id");
            $this->db->bind(':like_dislike', $like_dislike);
            $this->db->bind(':reply_id', $reply_id);
            $this->db->bind(':user_id', $user_id);
            $result = $this->db->execute();
        }

        if (!$result) {
            return false;
        } else {
            $likes_dislikes = $this->getReplyLikesDislikes($reply_id);
            $like_dislike_count->likes = $likes_dislikes->likes;
            $like_dislike_count->dislikes = $likes_dislikes->dislikes;

            return $like_dislike_count;
        }
    }

    public function getCommentLikesDislikes($comment_id)
    {
        $query = "SELECT COUNT(CASE WHEN like_dislike = 1 THEN 1 END) AS likes,
                  COUNT(CASE WHEN like_dislike = 0 THEN 1 END) AS dislikes
            FROM comment_likes
            WHERE comment_id = :comment_id";

        $this->db->query($query);
        $this->db->bind(":comment_id", $comment_id);
        return $this->db->single();
    }

    public function getReplyLikesDislikes($reply_id) {
        $query = "SELECT COUNT(CASE WHEN like_dislike = 1 THEN 1 END) AS likes,
                  COUNT(CASE WHEN like_dislike = 0 THEN 1 END) AS dislikes
            FROM reply_likes
            WHERE reply_id = :reply_id";

        $this->db->query($query);
        $this->db->bind(":reply_id", $reply_id);
        return $this->db->single();
    }

    public function checkNewComments($group_id, $lastCommentTime) {
        $query = "SELECT c.*, p.id AS postID, u.username, u.img
        FROM post_comments c
        INNER JOIN posts p ON c.post_id = p.id
        INNER JOIN users u ON c.user_id = u.id
        WHERE c.created_at > :lastCommentTime
        AND c.user_id != :user_id AND p.group_id = :group_id;
        ";

        $this->db->query($query);
        $this->db->bind(":group_id", $group_id);
        $this->db->bind(":user_id", $_SESSION['user_id']);
        $this->db->bind(":lastCommentTime", $lastCommentTime);
        $comments = $this->db->resultSet();

        return $comments;
    }

    public function checkNewCommentsPost($post_id, $lastCommentTime) {
        $query = "SELECT c.*, p.id AS postID, u.username, u.img
        FROM post_comments c
        INNER JOIN posts p ON c.post_id = p.id
        INNER JOIN users u ON c.user_id = u.id
        WHERE c.created_at > :lastCommentTime
        AND c.user_id != :user_id AND c.post_id = :post_id;
        ";

        $this->db->query($query);
        $this->db->bind(":post_id", $post_id);
        $this->db->bind(":user_id", $_SESSION['user_id']);
        $this->db->bind(":lastCommentTime", $lastCommentTime);
        $comments = $this->db->resultSet();

        return $comments;
    }

    public function checkNewReplies($group_id, $lastReplyTime) {
        $query = "SELECT r.*, p.id AS postID, c.id AS commentID, u.username, u.img
        FROM comment_replies r
        INNER JOIN post_comments c ON r.comment_id = c.id
        INNER JOIN posts p ON c.post_id = p.id
        INNER JOIN users u ON r.user_id = u.id
        WHERE r.created_at > :lastReplyTime
        AND r.user_id != :user_id AND p.group_id = :group_id;
        ";

        $this->db->query($query);
        $this->db->bind(":group_id", $group_id);
        $this->db->bind(":user_id", $_SESSION['user_id']);
        $this->db->bind(":lastReplyTime", $lastReplyTime);
        $replies = $this->db->resultSet();

        return $replies;
    }

    public function checkNewRepliesPost($post_id, $lastReplyTime) {
        $query = "SELECT r.*, p.id AS postID, c.id AS commentID, u.username, u.img
        FROM comment_replies r
        INNER JOIN post_comments c ON r.comment_id = c.id
        INNER JOIN posts p ON c.post_id = p.id
        INNER JOIN users u ON r.user_id = u.id
        WHERE r.created_at > :lastReplyTime
        AND r.user_id != :user_id AND c.post_id = :post_id;
        ";

        $this->db->query($query);
        $this->db->bind(":post_id", $post_id);
        $this->db->bind(":user_id", $_SESSION['user_id']);
        $this->db->bind(":lastReplyTime", $lastReplyTime);
        $replies = $this->db->resultSet();

        return $replies;
    }
  }