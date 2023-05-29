<?php
  class Comment {
    private $db;
    private $userModel;

    public function __construct(){
      $this->db = new Database;
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
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            $user->commentID = $this->db->lastInsertID();
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
            return $this->userModel->getUserById($_SESSION['user_id']);
        } else {
            return false;
        }
    }

    public function getPostComments($post_id)
    {
        $query = "SELECT post_comments.*, users.name, users.img, users.username FROM post_comments";
        $query .= " LEFT JOIN users ON post_comments.user_id = users.id WHERE post_id = :post_id";

        $this->db->query($query);
        $this->db->bind(":post_id", $post_id);
        $comments = $this->db->resultSet();

        return $comments;
    }

    public function getCommentReplies($comment_id) {
        $query = "SELECT comment_replies.*, users.name, users.img, users.username FROM comment_replies";
        $query .= " LEFT JOIN users ON comment_replies.user_id = users.id WHERE comment_id = :comment_id";

        $this->db->query($query);
        $this->db->bind(":comment_id", $comment_id);
        $replies = $this->db->resultSet();

        return $replies;
    }
  }